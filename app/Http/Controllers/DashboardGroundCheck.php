<?php

namespace App\Http\Controllers;

use App\Models\GroundCheck;
use App\Models\PetugasGC;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardGroundCheck extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // 1. Inisialisasi Query: Tambahkan has('petugas') agar hanya ambil yang ada relasinya
            $query = GroundCheck::has('petugas')->with('petugas');

            // 2. Logika Search (Tetap sama)
            if ($request->filled('search.value')) {
                $searchValue = $request->search['value'];
                $query->where(function ($q) use ($searchValue) {
                    $q->where('prelist_se.nama_usaha', 'like', "%$searchValue%")
                        ->orWhere('prelist_se.idsbr', 'like', "%$searchValue%")
                        ->orWhere('prelist_se.alamat', 'like', "%$searchValue%")
                        ->orWhere('prelist_se.kdkec', 'like', "%$searchValue%")
                        ->orWhere('prelist_se.kddesa', 'like', "%$searchValue%")
                        ->orWhereHas('petugas', function ($sub) use ($searchValue) {
                            $sub->where('nama', 'like', "%$searchValue%");
                        });
                });
            }

            // 3. Hitung total SEBELUM join (Pastikan hitung yang punya petugas saja)
            $totalData = GroundCheck::has('petugas')->count(); // Total record yang punya petugas
            $filteredData = $query->count(); // Total record setelah filter search

            // 4. Logika Sorting
            $query->select('prelist_se.*');

            if ($request->has('order')) {
                $columnIndex = $request->order[0]['column'];
                $columnName = $request->columns[$columnIndex]['data'];
                $columnSortOrder = $request->order[0]['dir'];

                $dbColumns = ['idsbr', 'nama_usaha', 'alamat', 'kdkec', 'kddesa', 'catatan'];

                if (in_array($columnName, $dbColumns)) {
                    $query->orderBy('prelist_se.' . $columnName, $columnSortOrder);
                } elseif ($columnName == 'nama_petugas') {
                    // Gunakan join (bukan leftJoin) karena kita hanya ingin data yang ada petugasnya
                    $query->join('petugas_gc', 'prelist_se.petugas_id', '=', 'petugas_gc.id')
                        ->orderBy('petugas_gc.nama', $columnSortOrder);
                }
            } else {
                $query->orderBy('prelist_se.idsbr', 'asc');
            }

            // 5. Pagination
            $data = $query->skip($request->start)
                ->take($request->length)
                ->get();

            // 6. Transformasi Data
            $data->transform(function ($item) {
                return [
                    'idsbr'        => $item->idsbr,
                    'nama_usaha'   => $item->nama_usaha,
                    'alamat'       => $item->alamat,
                    'kdkec'        => $item->kdkec,
                    'kddesa'       => $item->kddesa,
                    'catatan'      => \Illuminate\Support\Str::limit($item->catatan, 30),
                    'nama_petugas' => $item->petugas->nama, // Tidak perlu ?? 'N/A' karena sudah difilter
                    'aksi_html'    => '
            <div class="btn-group">
                <button class="btn btn-xs btn-warning btn-gambar" 
                    data-foto="' . asset($item->foto_usaha) . '" 
                    data-usaha="' . $item->nama_usaha . '">
                    <i class="fas fa-image"></i>
                </button>
                <button class="btn btn-xs btn-success btn-map" 
                    data-lat="' . $item->latitude . '" 
                    data-long="' . $item->longitude . '" 
                    data-usaha="' . $item->nama_usaha . '">
                    <i class="fas fa-map-marker-alt"></i>
                </button>
            </div>'
                ];
            });

            return response()->json([
                "draw"            => intval($request->draw),
                "recordsTotal"    => $totalData,
                "recordsFiltered" => $filteredData,
                "data"            => $data
            ]);
        }

        $topPetugas = PetugasGC::withCount('groundchecks')
            ->orderBy('groundchecks_count', 'desc')
            ->take(10)
            ->get();

        return view('backend.dashboardGroundCheck', compact('topPetugas'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportData(Request $request)
    {
        // Ambil SEMUA data yang memiliki petugas tanpa filter search
        $results = GroundCheck::has('petugas')
            ->with('petugas')
            ->get();

        if ($results->isEmpty()) {
            return response()->json([]);
        }

        $data = $results->map(function ($item) {
            return [
                'IDSBR'        => $item->idsbr,
                'Nama Usaha'   => $item->nama_usaha,
                'Alamat'       => $item->alamat,
                'Kecamatan'    => $item->kdkec,
                'Desa'         => $item->kddesa,
                'Nama Petugas' => $item->petugas->nama,
                'Catatan'      => $item->catatan,
                'Latitude'     => $item->latitude,
                'Longitude'    => $item->longitude,
                'Waktu Update' => $item->updated_at ? $item->updated_at->format('d-m-Y H:i') : '-',
            ];
        })->values()->all();

        return response()->json($data);
    }
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
    public function show(GroundCheck $groundCheck)
    {
        //
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
    public function update(Request $request, GroundCheck $groundCheck)
    {
        //
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
