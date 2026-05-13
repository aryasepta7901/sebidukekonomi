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

        // Fungsi Helper untuk filter GeoJSON (Tetap sama)
        $filterGeoJSON = function ($path, $key, $value) {
            if (!File::exists($path)) return ['type' => 'FeatureCollection', 'features' => []];
            $data = json_decode(File::get($path), true);
            $data['features'] = array_filter($data['features'], function ($feature) use ($key, $value) {
                $shortKec = substr($value, -3);
                return ($feature['properties'][$key] ?? null) == $shortKec;
            });
            $data['features'] = array_values($data['features']);
            return $data;
        };

        $filePath = public_path('wilayah/datarekap.csv');
        $rekapKelurahan = [];
        $totalKecamatan = ['ub' => 0, 'um' => 0, 'umk' => 0, 'total' => 0];

        if (file_exists($filePath)) {
            try {
                if (($handle = fopen($filePath, "r")) !== FALSE) {
                    fgetcsv($handle); // Lewati baris 1

                    $header = fgetcsv($handle); // Ambil header baris 2
                    $cleanHeader = array_map(fn($h) => trim($h), $header);

                    // --- 1. SESUAIKAN INDEX DENGAN HEADER BARU ---
                    $idxId    = array_search('KDWIL', $cleanHeader);
                    $idxUB    = array_search('UB', $cleanHeader);
                    $idxUM    = array_search('UM', $cleanHeader);
                    $idxUMK   = array_search('UMK', $cleanHeader);
                    $idxTotal = array_search('Grand Total', $cleanHeader);

                    // Ganti bagian loop while di Controller Anda dengan ini:

                    while (($data = fgetcsv($handle)) !== FALSE) {
                        if (isset($data[$idxId])) {
                            $kodeFull = trim($data[$idxId]);

                            // Ambil nilai kategori
                            $valUB    = (int) filter_var($data[$idxUB] ?? 0, FILTER_SANITIZE_NUMBER_INT);
                            $valUM    = (int) filter_var($data[$idxUM] ?? 0, FILTER_SANITIZE_NUMBER_INT);
                            $valUMK   = (int) filter_var($data[$idxUMK] ?? 0, FILTER_SANITIZE_NUMBER_INT);
                            $valTotal = (int) filter_var($data[$idxTotal] ?? 0, FILTER_SANITIZE_NUMBER_INT);

                            if ($valTotal <= 0) continue;

                            // Pastikan baris ini milik kecamatan yang sedang dibuka
                            if (str_starts_with($kodeFull, $kdkec)) {

                                // JIKA BARIS ADALAH KELURAHAN (Panjang kode >= 10, misal 1674010001)
                                if (strlen($kodeFull) >= 10) {
                                    $kodeDesa = substr($kodeFull, 7, 3); // Ambil 3 digit terakhir desa

                                    if (!isset($rekapKelurahan[$kodeDesa])) {
                                        $rekapKelurahan[$kodeDesa] = ['ub' => 0, 'um' => 0, 'umk' => 0, 'total' => 0];
                                    }

                                    // Tambahkan ke rekap kelurahan
                                    $rekapKelurahan[$kodeDesa]['ub']    += $valUB;
                                    $rekapKelurahan[$kodeDesa]['um']    += $valUM;
                                    $rekapKelurahan[$kodeDesa]['umk']   += $valUMK;
                                    $rekapKelurahan[$kodeDesa]['total'] += $valTotal;

                                    // OTOMATIS Tambahkan ke total kecamatan (Akumulasi)
                                    $totalKecamatan['ub']    += $valUB;
                                    $totalKecamatan['um']    += $valUM;
                                    $totalKecamatan['umk']   += $valUMK;
                                    $totalKecamatan['total'] += $valTotal;
                                }
                                // JIKA BARIS ADALAH KECAMATAN ITU SENDIRI (Hanya jika Anda ingin double check)
                                elseif ($kodeFull === $kdkec) {
                                    // Biarkan kosong jika sudah diakumulasi dari kelurahan agar tidak double count
                                    // Atau gunakan ini jika kelurahan tidak diakumulasi manual
                                }
                            }
                        }
                    }
                    fclose($handle);
                }
            } catch (\Exception $e) {
                // Log::error($e->getMessage());
            }
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
