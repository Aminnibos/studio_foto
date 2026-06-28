<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * FUNGSI: Memproses data dari form login
     */
    public function login(Request $request)
    {
        // 1. Validasi inputan form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba mencocokkan data dengan database
        if (Auth::attempt($credentials, $request->remember)) {
            
            // Regenerasi session untuk keamanan dari serangan peretasan
            $request->session()->regenerate();

            // 3. LOGIKA SPLIT ROLE: Cek apakah dia admin atau pelanggan
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // Jika bukan admin (berarti customer), lempar ke halaman depan user
            return redirect()->intended('/dashboard-studio');
        }

        // Jika gagal login, kembalikan ke form dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * FUNGSI: Mengeluarkan pengguna dari sistem (Logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus sisa sesi dan token keamanan pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembalikan ke halaman form login
        return redirect('/');
    }

    /**
     * FUNGSI: Memproses pendaftaran akun baru
     */
    public function register(Request $request)
    {
        // 1. Validasi inputan form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'required|string|max:15', 
            'password' => 'required|string|min:8|confirmed', 
        ]);

        // 2. Simpan data ke tabel users
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            // Password wajib di-hash agar aman dan bisa login
            'password' => Hash::make($request->password), 
            // Tetapkan role default sebagai pelanggan/user
            'role' => 'user', 
        ]);

        // 3. Arahkan kembali ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}