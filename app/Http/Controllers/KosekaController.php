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
        // Logika Ambil Data Excel
        $sheetUrl = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTfA-GmgjJmgK4Hh3ZnIq6MWj4OX0pFUkYecLNbWEtM9tvcXgUaIdmLPxi3CJ3wHQ/pub?output=csv";
        $rekapKelurahan = [];
        $totalKecamatan = 0;

        try {
            $response = Http::timeout(10)->get($sheetUrl);
            if ($response->successful()) {
                $rows = str_getcsv($response->body(), "\n");
                $header = str_getcsv(array_shift($rows), ",");
                $cleanHeader = array_map(fn($h) => strtolower(trim(preg_replace('/[^A-Za-z0-9_]/', '', $h))), $header);

                $idxResult = array_search('gcs_result', $cleanHeader);
                $idxWilayah = array_search('kode_wilayah', $cleanHeader);

                foreach ($rows as $row) {
                    $data = str_getcsv($row, ",");
                    // Pastikan kolom gcs_result dan kode_wilayah tersedia
                    if (isset($data[$idxResult]) && trim($data[$idxResult]) == '1') {
                        $kodeFull = trim($data[$idxWilayah] ?? '');

                        if (str_starts_with($kodeFull, $kdkec)) {
                            $totalKecamatan++;
                            // Ambil 3 digit desa (misal dari 1674011001 diambil 001)
                            // Menggunakan substr dari belakang (-3) lebih aman jika panjang string tidak konsisten
                            $kodeDesa = substr($kodeFull, -3);
                            $rekapKelurahan[$kodeDesa] = ($rekapKelurahan[$kodeDesa] ?? 0) + 1;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
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
