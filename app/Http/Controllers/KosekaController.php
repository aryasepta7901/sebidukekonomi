<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class KosekaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDetail($kdkec)
    {
        // Path ke file GeoJSON
        $pathKec = public_path('wilayah/final_kec_202521674.geojson');
        $pathDesa = public_path('wilayah/final_desa_202521674.geojson');
        $pathSLS = public_path('wilayah/final_sls_202521674.geojson');
        $pathSubSLS = public_path('wilayah/final_subsls_202521674.geojson');

        // Fungsi Helper untuk filter
        $filterGeoJSON = function ($path, $key, $value) {
            $data = json_decode(File::get($path), true);
            $data['features'] = array_filter($data['features'], function ($feature) use ($key, $value) {
                // Mencocokkan kdkec (misal: "011" dari "1674011")
                // Mengambil 3 digit terakhir dari ID yang dikirim
                $shortKec = substr($value, -3);
                return $feature['properties'][$key] == $shortKec;
            });
            // Re-index array agar tetap valid JSON
            $data['features'] = array_values($data['features']);
            return $data;
        };
        // Logika Ambil Data Excel untuk Detail Kecamatan
        $sheetUrl = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTfA-GmgjJmgK4Hh3ZnIq6MWj4OX0pFUkYecLNbWEtM9tvcXgUaIdmLPxi3CJ3wHQ/pub?output=csv";
        $rekapKelurahan = [];
        $totalKecamatan = 0;

        try {
            $response = Http::timeout(10)->get($sheetUrl);
            if ($response->successful()) {
                $rows = str_getcsv($response->body(), "\n");

                // 1. Lewati baris metadata pertama
                array_shift($rows);

                // 2. Ambil header asli
                $header = str_getcsv(array_shift($rows), ",");
                $cleanHeader = array_map(fn($h) => trim($h), $header);

                // 3. Cari index kolom kode_wilayah dan kolom hasil "1"
                $idxId = array_search('kode_wilayah', $cleanHeader);
                $idxValue = array_search('1', $cleanHeader);

                foreach ($rows as $row) {
                    $data = str_getcsv($row, ",");

                    if (isset($data[$idxId]) && isset($data[$idxValue])) {
                        $kodeFull = trim($data[$idxId]);
                        $jumlah = (int) preg_replace('/[^0-9]/', '', $data[$idxValue]);

                        if ($jumlah <= 0) continue;

                        // 4. Cek apakah kode wilayah diawali dengan kode kecamatan ($kdkec)
                        if (str_starts_with($kodeFull, $kdkec)) {

                            // A. Jika kodenya tepat sama dengan kode kecamatan (Parent)
                            if ($kodeFull === $kdkec) {
                                $totalKecamatan += $jumlah;
                            }

                            // B. Jika kodenya adalah kelurahan (Child, biasanya 10 digit)
                            elseif (strlen($kodeFull) > 7) {
                                $totalKecamatan += $jumlah;

                                // Ambil 3 digit terakhir untuk ID kelurahan (misal 001)
                                $kodeDesa = substr($kodeFull, -3);
                                $rekapKelurahan[$kodeDesa] = ($rekapKelurahan[$kodeDesa] ?? 0) + $jumlah;
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error jika diperlukan: Log::error($e->getMessage());
        }
        $targetKec = $filterGeoJSON($pathKec, 'kdkec', $kdkec);
        $targetDesa = $filterGeoJSON($pathDesa, 'kdkec', $kdkec);
        $targetSLS = $filterGeoJSON($pathSLS, 'kdkec', $kdkec);
        $targetSubSLS = $filterGeoJSON($pathSubSLS, 'kdkec', $kdkec);

        return view('landingpage.koseka_detail', compact(
            'targetKec',
            'targetDesa',
            'targetSLS',
            'targetSubSLS',
            'kdkec',
            'totalKecamatan',
            'rekapKelurahan'
        ));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
