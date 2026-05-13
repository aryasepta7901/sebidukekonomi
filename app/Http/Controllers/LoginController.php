<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Mengarahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        $query = http_build_query([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'access_type' => 'offline',
            'prompt' => 'select_account' // Memaksa user pilih akun jika punya banyak email
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    // Menangani kembalian dari Google
    public function handleGoogleCallback(Request $request)
    {
        $code = $request->get('code');

        // Cek apakah ada kode dari Google
        if (!$code) {
            return redirect('/login')->with('error', 'Login dibatalkan atau terjadi kesalahan.');
        }

        // 1. Tukar Code dengan Token
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code'          => $code,
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri'  => env('GOOGLE_REDIRECT_URI'),
            'grant_type'    => 'authorization_code',
        ]);

        $tokenData = $response->json();

        // Validasi apakah token berhasil didapat
        if (!isset($tokenData['access_token'])) {
            return redirect('/login')->with('error', 'Gagal autentikasi dengan Google.');
        }

        // 2. Ambil Profil User dari API Google
        $userData = Http::withToken($tokenData['access_token'])
            ->get('https://www.googleapis.com/oauth2/v3/userinfo')
            ->json();

        // 3. Cari User berdasarkan email atau buat baru jika belum ada
        $user = User::where('email', $userData['email'])->first();

        if (!$user) {
            // Pendaftaran otomatis untuk user baru (Default: wait)
            $user = User::create([
                'name'     => $userData['name'],
                'email'    => $userData['email'],
                'password' => bcrypt('SebidukEkonomi1674'), // Password default untuk login manual
                'role'     => 'wait',
                'wil_tugas' => [],
            ]);
        }

        // 4. Proses Login
        Auth::login($user);
        $request->session()->regenerate();

        // 5. Logika Pengalihan (Redirect) Berdasarkan Role
        // Menggunakan fresh() untuk memastikan data role paling update dari DB
        if ($user->fresh()->role === 'wait') {
            return redirect('/waiting-approval');
        }

        // Jika sudah di-approve, arahkan ke Dashboard
        // Menggunakan redirect() biasa lebih aman daripada intended() untuk kasus role-based
        return redirect('/backend');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
