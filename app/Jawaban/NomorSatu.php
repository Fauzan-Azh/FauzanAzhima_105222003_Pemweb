<?php

namespace App\Jawaban; // Namespace untuk mengorganisir kelas

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk autentikasi
use Illuminate\Support\Facades\Validator; // Untuk validasi data

class NomorSatu {

    /**
     * Metode untuk menangani proses autentikasi.
     */
    public function auth(Request $request) {
        // Validasi input username dan password
        $validator = Validator::make($request->all(), [
            'username' => 'required|string', // Username harus diisi dan berupa string
            'password' => 'required|string|min:8', // Password harus diisi, berupa string, dan minimal 8 karakter
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek apakah input username adalah email atau username biasa
        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Coba melakukan autentikasi
        if (Auth::attempt([$field => $request->username, 'password' => $request->password])) {
            return redirect()->route('event.home'); // Jika berhasil, redirect ke halaman home
        } else {
            return redirect()->back()
                ->with('error', 'Email/Username atau password salah.') // Jika gagal, kembalikan pesan error
                ->withInput();
        }
    }

    /**
     * Metode untuk menangani proses logout.
     */
    public function logout(Request $request) {
        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Invalidasi session
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect()->route('event.home'); // Redirect ke halaman home setelah logout
    }
}
