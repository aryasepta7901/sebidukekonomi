<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        $targetKec = $filterGeoJSON($pathKec, 'kdkec', $kdkec);
        $targetDesa = $filterGeoJSON($pathDesa, 'kdkec', $kdkec);
        $targetSLS = $filterGeoJSON($pathSLS, 'kdkec', $kdkec);
        $targetSubSLS = $filterGeoJSON($pathSubSLS, 'kdkec', $kdkec);

        return view('landingpage.koseka_detail', compact('targetKec', 'targetDesa', 'targetSLS', 'targetSubSLS', 'kdkec'));
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
