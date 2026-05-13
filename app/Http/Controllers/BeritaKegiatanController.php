<?php

namespace App\Http\Controllers;

use App\Models\BeritaKegiatan;
use App\Models\JenisLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaKegiatanController extends Controller
{
    public function index()
    {
        $data = BeritaKegiatan::with(['user', 'jenisLaporan'])->latest()->get();
        return view('berita.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'id_jenis_laporan' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi tiap file foto
            'link_pdf.*' => 'mimes:pdf|max:10000', // Validasi tiap file PDF
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->id(); // Ambil ID user yang login

        // Handle Upload Banyak Gambar
        if ($request->hasFile('gambar')) {
            $images = [];
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('berita/images', 'public');
                $images[] = $path;
            }
            $input['gambar'] = $images; // Tersimpan sebagai array di DB (karena casting)
        }

        // Handle Upload Banyak PDF
        if ($request->hasFile('link_pdf')) {
            $pdfs = [];
            foreach ($request->file('link_pdf') as $file) {
                $path = $file->store('berita/documents', 'public');
                $pdfs[] = $path;
            }
            $input['link_pdf'] = $pdfs;
        }

        BeritaKegiatan::create($input);

        return redirect()->back()->with('success', 'Laporan SE2026 berhasil dikirim!');
    }
}
