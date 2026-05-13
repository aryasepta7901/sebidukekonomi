<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Ambil Public Patch    
        $filePath = public_path('wilayah/datarekap.csv');
        $perKoseka = [];
        $totalSemua = 0;

        // 1. Cek apakah file ada di folder public/wilayah/
        if (file_exists($filePath)) {
            try {
                // 2. Buka file CSV (mode read)
                if (($handle = fopen($filePath, "r")) !== FALSE) {

                    // Lewati baris 1 (Biasanya header judul dari Google)
                    fgetcsv($handle);

                    // Ambil baris 2 (Header kolom: kode_wilayah, 1, dll)
                    $header = fgetcsv($handle);
                    $cleanHeader = array_map('trim', $header);

                    // Cari posisi kolom berdasarkan nama header baru
                    $idxId = array_search('KDWIL', $cleanHeader);
                    $idxUB = array_search('UB', $cleanHeader);
                    $idxUM = array_search('UM', $cleanHeader);
                    $idxUMK = array_search('UMK', $cleanHeader);
                    $idxTotal = array_search('Grand Total', $cleanHeader);

                    while (($data = fgetcsv($handle)) !== FALSE) {
                        if (isset($data[$idxId])) {
                            $kode = trim($data[$idxId]);
                            if (strtolower($kode) === 'grand total' || $kode == "") continue;

                            // Ambil nilai masing-masing kolom (sanitize angka)
                            $valUB    = (int) filter_var($data[$idxUB] ?? 0, FILTER_SANITIZE_NUMBER_INT);
                            $valUM    = (int) filter_var($data[$idxUM] ?? 0, FILTER_SANITIZE_NUMBER_INT);
                            $valUMK   = (int) filter_var($data[$idxUMK] ?? 0, FILTER_SANITIZE_NUMBER_INT);
                            $valTotal = (int) filter_var($data[$idxTotal] ?? 0, FILTER_SANITIZE_NUMBER_INT);

                            // Contoh: Jika ingin menjumlahkan total keseluruhan
                            $totalSemua += $valTotal;

                            // Ambil 7 digit pertama untuk kode Kecamatan
                            $kode7 = substr($kode, 0, 7);

                            // Akumulasi per KOSEKA dalam bentuk array agar detail UB/UM/UMK tersimpan
                            if (!isset($perKoseka[$kode7])) {
                                $perKoseka[$kode7] = ['ub' => 0, 'um' => 0, 'umk' => 0, 'total' => 0];
                            }

                            $perKoseka[$kode7]['ub'] += $valUB;
                            $perKoseka[$kode7]['um'] += $valUM;
                            $perKoseka[$kode7]['umk'] += $valUMK;
                            $perKoseka[$kode7]['total'] += $valTotal;
                        }
                    }
                    fclose($handle);
                }
            } catch (\Exception $e) {
                // Jika ada error saat membaca file, biarkan data kosong
            }
        }
        $totalUB = 0;
        $totalUM = 0;
        $totalUMK = 0;

        foreach ($perKoseka as $item) {
            $totalUB += $item['ub'];
            $totalUM += $item['um'];
            $totalUMK += $item['umk'];
        }
        $rekapSheets = [
            'total' => $totalSemua,
            'perKoseka' => $perKoseka
        ];

        // 2. Data List KOSEKA (Tetap sama)
        $listKoseka = [
            ['id' => '1674011', 'wilayah' => 'Lubuk Linggau Barat I', 'koseka' => 'Ade', 'korwil1' => 'Rani', 'korwil2' => 'Resa', 'nama' => 'Ade Suteja', 'jabatan' => 'KOSEKA Barat I', 'foto_wil' => 'barati.png', 'foto' => 'ade.png', 'quote' => '"Masa depanmu dimulai dari apa yang kamu pelajari hari ini."', 'deskripsi' => 'Bertanggung jawab dalam koordinasi lapangan, pengawasan pendaftaran usaha, dan menjamin kualitas data di seluruh kelurahan wilayah Lubuk Linggau Barat I.'],
            ['id' => '1674012', 'wilayah' => 'Lubuk Linggau Barat II', 'koseka' => 'Arya', 'korwil1' => 'Rani', 'korwil2' => 'Resa', 'nama' => 'M. Arya Septa Kovitra, S.Tr.Stat.', 'jabatan' => 'KOSEKA Barat II', 'foto_wil' => 'baratii.png', 'foto' => 'arya_fix.png', 'quote' => '"Talk is Cheap. Show me The Code."', 'deskripsi' => 'Memastikan integritas data sensus ekonomi di wilayah Barat II melalui pemantauan intensif dan dukungan teknis kepada para petugas lapangan.'],
            ['id' => '1674021', 'wilayah' => 'Lubuk Linggau Selatan I', 'koseka' => 'Arif', 'korwil1' => 'Nia', 'korwil2' => 'Canggih', 'nama' => 'M. Arif Hidayatullah, A.Md.T.', 'jabatan' => 'KOSEKA Selatan I', 'foto_wil' => 'selatani.png', 'foto' => 'arif.png', 'quote' => '"Fokuslah mengembangkan diri, agar tak larut dalam opini mereka yang tak peduli."', 'deskripsi' => 'Mengawal jalannya Sensus Ekonomi 2026 di wilayah Selatan I demi mewujudkan basis data ekonomi yang akurat dan terpercaya.'],
            ['id' => '1674022', 'wilayah' => 'Lubuk Linggau Selatan II', 'koseka' => 'Fathu', 'korwil1' => 'Nia', 'korwil2' => 'Canggih',  'nama' => 'M. Fathu Rahman, S.Tr.Stat.', 'jabatan' => 'KOSEKA Selatan II', 'foto_wil' => 'selatanii.png', 'foto' => 'fathur.png', 'quote' => '"Don\'t watch the clock; do what it does. Keep going!"', 'deskripsi' => 'Berkomitmen tinggi dalam mensukseskan pendataan ekonomi di wilayah Selatan II dengan koordinasi tim yang solid.'],
            ['id' => '1674031', 'wilayah' => 'Lubuk Linggau Timur I', 'koseka' => 'Novi', 'korwil1' => 'Dian', 'korwil2' => 'Rini', 'nama' => 'Novi Marlina, S.Si.', 'jabatan' => 'KOSEKA Timur I', 'foto_wil' => 'timuri.png', 'foto' => 'novi.png', 'quote' => '"Dedikasi dan ketelitian adalah kunci kualitas data yang berharga."', 'deskripsi' => 'Bertanggung jawab penuh dalam mengoordinasikan pendataan ekonomi di wilayah Timur I untuk memastikan setiap unit usaha tercatat dengan akurat.'],
            ['id' => '1674032', 'wilayah' => 'Lubuk Linggau Timur II', 'koseka' => 'Yessy', 'korwil1' => 'Dian', 'korwil2' => 'Rini', 'nama' => 'Yessy Zaliah Purnama Sari, A.Md.', 'jabatan' => 'KOSEKA Timur II', 'foto_wil' => 'timurii.png', 'foto' => 'yessy.png', 'quote' => '"Bekerja keras dalam diam, biarkan data yang berbicara."', 'deskripsi' => 'Mengawal kualitas pendaftaran usaha dan sinergi tim lapangan di wilayah Timur II guna mensukseskan Sensus Ekonomi 2026.'],
            ['id' => '1674041', 'wilayah' => 'Lubuk Linggau Utara I', 'koseka' => 'Luluk', 'korwil1' => 'Alma', 'korwil2' => 'Tamara', 'nama' => 'Luluk Indryas Mufida, S.Tr.Stat.', 'jabatan' => 'KOSEKA Utara I', 'foto_wil' => 'utarai.png', 'foto' => 'luluk.png', 'quote' => '"Kualitas data adalah cerminan integritas dalam setiap langkah pendataan."', 'deskripsi' => 'Memastikan kelancaran koordinasi dan akurasi cakupan unit usaha di wilayah Utara I demi mewujudkan basis data ekonomi yang handal dan terpercaya.'],
            ['id' => '1674042', 'wilayah' => 'Lubuk Linggau Utara II', 'koseka' => 'Raden', 'korwil1' => 'Alma', 'korwil2' => 'Tamara', 'nama' => 'Raden Mulia, S.Tr.Stat.', 'jabatan' => 'KOSEKA Utara II', 'foto_wil' => 'utaraii.png', 'foto' => 'raden.png', 'quote' => '"Sinergi lapangan yang kuat melahirkan data statistik yang tepat."', 'deskripsi' => 'Mengawasi jalannya pendaftaran usaha di wilayah Utara II dengan pendekatan strategis untuk mendukung kesuksesan sensus ekonomi yang komprehensif.'],
        ];

        return view('landingpage.index', [
            'totalUsahaAktif' => $rekapSheets['total'],
            'totalUB'         => $totalUB,   // Variabel baru
            'totalUM'         => $totalUM,   // Variabel baru
            'totalUMK'        => $totalUMK,  // Variabel baru
            'rekapPerKoseka' => $rekapSheets['perKoseka'],
            'listKoseka' => $listKoseka
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRekap()
    {
        $sheetUrl = "https://docs.google.com/spreadsheets/d/1VHTGdZYKxUew_m79vkcauEVrUnduPG8V/export?format=csv&gid=2017343805";
        $directory = public_path('wilayah');
        $filePath = $directory . '/datarekap.csv';

        try {
            // Set timeout lebih lama karena download antar server bisa lambat
            $response = Http::timeout(30)->get($sheetUrl);

            if ($response->successful()) {
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }

                // Simpan/Timpah file CSV di public path
                File::put($filePath, $response->body());

                // Hapus cache rekap_sheets_koseka jika masih ada sisa-sisa cache lama
                Cache::forget('rekap_sheets_koseka');

                return redirect('/')->with('success', 'Data rekap berhasil diperbarui dari Google Sheets!');
            }

            return "Gagal download. Status: " . $response->status();
        } catch (\Exception $e) {
            return "Terjadi kesalahan: " . $e->getMessage();
        }
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
