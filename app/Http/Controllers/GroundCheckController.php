<?php

namespace App\Http\Controllers;

use App\Models\GroundCheck;
use App\Models\PetugasGC;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class GroundCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Di dalam GroundCheckController.php

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // 1. Ambil mapping wilayah dari JSON
            $wilayah = $this->getWilayahMapping();
            $kecMap = $wilayah['kec'];
            $desaMap = $wilayah['desa'];

            // 2. Daftar kode kecamatan yang diizinkan & urutan kustom
            $allowedKec = ['011', '012', '021', '022', '031', '032', '041', '042'];
            $customOrderString = "'" . implode("','", $allowedKec) . "'";

            // 3. Inisialisasi Query
            $query = GroundCheck::with('petugas');

            // 4. LOGIKA FILTER DROPDOWN (PENTING: Ditaruh sebelum filter global agar datanya akurat)
            // Jika filter kecamatan dipilih
            if ($request->filled('filterKec')) {
                $query->where('kdkec', $request->filterKec);

                // Jika filter kelurahan dipilih (hanya jalan jika kecamatan sudah dipilih)
                if ($request->filled('filterDesa')) {
                    $query->where('kddesa', $request->filterDesa);
                }
            } else {
                // Jika tidak ada filter yang dipilih, gunakan filter default (Allowed Kec + Data Kosong)
                $query->where(function ($q) use ($allowedKec) {
                    $q->whereIn('kdkec', $allowedKec)
                        ->orWhereNull('kdkec')
                        ->orWhere('kdkec', '0')
                        ->orWhere('kdkec', '');
                });
            }

            // --- Logika Pencarian Global (Search Bar) ---
            if ($request->has('search') && !empty($request->search['value'])) {
                $searchValue = strtolower($request->search['value']);

                // Reverse search: cari kode dari nama di JSON
                $matchedKec = array_keys(array_filter($kecMap, fn($v) => str_contains(strtolower($v), $searchValue)));

                $matchedDesaPairs = [];
                foreach ($desaMap as $key => $name) {
                    if (str_contains(strtolower($name), $searchValue)) {
                        $parts = explode('-', $key);
                        $matchedDesaPairs[] = ['kdkec' => $parts[0], 'kddesa' => $parts[1]];
                    }
                }

                $query->where(function ($q) use ($searchValue, $matchedKec, $matchedDesaPairs) {
                    $q->where('nama_usaha', 'like', "%$searchValue%")
                        ->orWhere('idsbr', 'like', "%$searchValue%")
                        ->orWhere('alamat', 'like', "%$searchValue%");

                    if (!empty($matchedKec)) {
                        $q->orWhereIn('kdkec', $matchedKec);
                    }

                    if (!empty($matchedDesaPairs)) {
                        foreach ($matchedDesaPairs as $pair) {
                            $q->orWhere(function ($sub) use ($pair) {
                                $sub->where('kdkec', $pair['kdkec'])
                                    ->where('kddesa', $pair['kddesa']);
                            });
                        }
                    }
                });
            }

            // Hitung total setelah filter
            $totalData = GroundCheck::count();
            $filteredData = $query->count();

            // --- Logika Sorting ---
            if ($request->has('order') && $request->order[0]['column'] != 0) {
                $columnIndex = $request->order[0]['column'];
                $columnName = $request->columns[$columnIndex]['data'];
                $columnSortOrder = $request->order[0]['dir'];

                if (in_array($columnName, ['kdkec', 'kddesa'])) {
                    $query->orderByRaw("CASE WHEN $columnName = '0' OR $columnName IS NULL OR $columnName = '' THEN 1 ELSE 0 END ASC")
                        ->orderBy($columnName, $columnSortOrder);
                } else {
                    $query->orderBy($columnName, $columnSortOrder);
                }
            } else {
                // DEFAULT SORTING
                $query->orderByRaw("CASE WHEN kdkec IN ($customOrderString) THEN 0 ELSE 1 END ASC")
                    ->orderByRaw("FIELD(kdkec, $customOrderString) ASC")
                    ->orderBy('kddesa', 'asc');
            }

            // 5. Pagination
            $data = $query->skip($request->start)->take($request->length)->get();

            // --- Transformasi Output: Mapping Kode -> Nama ---
            $data->transform(function ($item) use ($kecMap, $desaMap) {
                $kKec = $item->kdkec;
                $kDesa = $item->kddesa;

                $item->kdkec_raw = $kKec; // Menyimpan kode asli jika diperlukan
                $item->kdkec = $kecMap[$kKec] ?? ($kKec ?: '-');
                $item->kddesa = $desaMap[$kKec . '-' . $kDesa] ?? ($kDesa ?: '-');

                return $item;
            });

            return response()->json([
                "draw"            => intval($request->draw),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($filteredData),
                "data"            => $data
            ]);
        }

        $listKecamatan = $this->getListKecamatan();
        return view('groundcheck.index', compact('listKecamatan'));
    }

    /**
     * Fungsi pembantu untuk memproses JSON Wilayah
     */
    private function getWilayahMapping()
    {
        $kecFile = public_path('wilayah/kec_1674.json');
        $desaFile = public_path('wilayah/desa_1674.json');

        $kecMap = [];
        if (file_exists($kecFile)) {
            $kecData = json_decode(file_get_contents($kecFile), true);
            foreach ($kecData['features'] as $f) {
                $kecMap[$f['properties']['kdkec']] = $f['properties']['nmkec'];
            }
        }

        $desaMap = [];
        if (file_exists($desaFile)) {
            $desaData = json_decode(file_get_contents($desaFile), true);
            foreach ($desaData['features'] as $f) {
                $p = $f['properties'];
                $desaMap[$p['kdkec'] . '-' . $p['kddesa']] = $p['nmdesa'];
            }
        }

        return ['kec' => $kecMap, 'desa' => $desaMap];
    }
    public function getListKecamatan()
    {
        $wilayah = $this->getWilayahMapping();
        $kecMap = $wilayah['kec'];

        // 1. Definisikan kode kecamatan yang diizinkan (sesuai permintaan Anda)
        $allowedKec = ['011', '012', '021', '022', '031', '032', '041', '042'];

        $listKec = [];
        foreach ($kecMap as $id => $nama) {
            // 2. Filter hanya masukkan ke array jika ID ada dalam daftar allowedKec
            if (in_array($id, $allowedKec)) {
                $listKec[] = [
                    'id'   => $id,
                    'nama' => $nama
                ];
            }
        }

        // 3. Opsional: Urutkan list berdasarkan urutan di array allowedKec
        usort($listKec, function ($a, $b) use ($allowedKec) {
            return array_search($a['id'], $allowedKec) - array_search($b['id'], $allowedKec);
        });

        return $listKec;
    }

    /**
     * Mengambil daftar kelurahan berdasarkan Kode Kecamatan
     */
    public function getListDesa($kdkec)
    {
        $wilayah = $this->getWilayahMapping();
        $desaMap = $wilayah['desa']; // Format key: 'kdkec-kddesa'

        $listDesa = [];
        foreach ($desaMap as $key => $nama) {
            // Cek apakah key diawali dengan kdkec yang diminta
            if (str_starts_with($key, $kdkec . '-')) {
                $parts = explode('-', $key);
                $listDesa[] = [
                    'id'   => $parts[1], // kddesa
                    'nama' => $nama
                ];
            }
        }

        return $listDesa;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroundCheck  $groundCheck
     * @return \Illuminate\Http\Response
     */

    public function show(GroundCheck $GroundCheck)
    {
        // 1. Ambil mapping wilayah dari JSON
        $wilayah = $this->getWilayahMapping();

        // 2. Mapping kode ke nama untuk Nama Kecamatan dan Desa
        $kKec = $GroundCheck->kdkec;
        $kDesa = $GroundCheck->kddesa;
        $GroundCheck->nama_kecamatan = $wilayah['kec'][$kKec] ?? ($kKec ?: '-');
        $GroundCheck->nama_desa = $wilayah['desa'][$kKec . '-' . $kDesa] ?? ($kDesa ?: '-');

        // 3. AMBIL DATA PETUGAS dari tabel petugas_gc
        $listPetugas = PetugasGC::orderByRaw("
        CASE WHEN LENGTH(id) <= 3 THEN 0 
            ELSE 1 
        END ASC")
            ->orderBy('nama', 'asc')
            ->get();

        // 4. Load relasi petugas yang saat ini tertaut
        $GroundCheck->load('petugas');

        return view('groundcheck.view', compact('GroundCheck', 'listPetugas'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroundCheck  $groundCheck
     * @return \Illuminate\Http\Response
     */
    public function edit(GroundCheck $groundCheck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroundCheck  $groundCheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 1. Ambil data petugas untuk pengecekan nama
        $petugas = PetugasGC::find($request->petugas_id); // Sesuaikan namespace model Petugas Anda
        $isAgenStatistik = ($petugas && $petugas->nama == 'Agen Statistik Universitas Bina Insan');

        // 2. Validasi Input dengan Logika Kondisional
        $request->validate([
            'petugas_id'      => 'required|exists:petugas_gc,id',
            'latitude'        => 'required',
            'longitude'       => 'required',
            // Jika Agen Statistik, maka foto_compressed & catatan menjadi optional (nullable)
            'foto_compressed' => $isAgenStatistik ? 'nullable' : 'required',
            'deskripsi_usaha' => 'nullable|string',
            'catatan'         => $isAgenStatistik ? 'nullable|string' : 'required|string',
        ], [
            'petugas_id.required'      => 'Petugas harus dipilih.',
            'latitude.required'        => 'Koordinat lokasi (Latitude) belum terdeteksi.',
            'longitude.required'       => 'Koordinat lokasi (Longitude) belum terdeteksi.',
            'foto_compressed.required' => 'Foto usaha wajib diambil/diunggah.',
            'catatan.required'         => 'Catatan harus diisi, minimal strip (-).',
        ]);

        try {
            $item = GroundCheck::findOrFail($id);

            // 3. Update Data Teknis & Tambahan
            $item->petugas_id      = $request->petugas_id;
            $item->latitude        = $request->latitude;
            $item->longitude       = $request->longitude;
            $item->deskripsi_usaha = $request->deskripsi_usaha;
            $item->catatan         = $request->catatan;

            // 4. Proses Foto (Hanya jika ada foto yang diunggah)
            if ($request->filled('foto_compressed')) {
                $imageData = $request->foto_compressed;

                // Hapus foto lama jika ada proses upload foto baru
                if ($item->foto_usaha && file_exists(public_path($item->foto_usaha))) {
                    unlink(public_path($item->foto_usaha));
                }

                $imageInfo = explode(";base64,", $imageData);
                $imageTypeInfo = explode("image/", $imageInfo[0]);
                $imageType = $imageTypeInfo[1];
                $imageContent = str_replace(' ', '+', $imageInfo[1]);

                $folderPath = 'uploads/foto_groundcheck/';
                $fileName = 'gc_' . $item->idsbr . '_' . time() . '.' . $imageType;
                $fullPath = public_path($folderPath . $fileName);

                if (!File::isDirectory(public_path($folderPath))) {
                    File::makeDirectory(public_path($folderPath), 0777, true, true);
                }

                File::put($fullPath, base64_decode($imageContent));
                $item->foto_usaha = $folderPath . $fileName;
            }

            $item->save();

            return redirect()->route('GroundCheck.index')
                ->with('success', "Data {$item->nama_usaha} berhasil di-groundcheck.");
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroundCheck  $groundCheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroundCheck $groundCheck)
    {
        //
    }
}
