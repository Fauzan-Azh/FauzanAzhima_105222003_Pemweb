<?php

namespace App\Http\Controllers; // Namespace untuk mengorganisir controller

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani data HTTP
use App\Jawaban\NomorSatu; // Mengimpor kelas NomorSatu untuk logika autentikasi

class AuthController extends Controller {

    /**
     * Metode untuk menangani proses autentikasi (login).
     * Meneruskan request ke kelas NomorSatu.
     */
    public function auth(Request $request) {
        $nomorSatu = new NomorSatu(); // Membuat instance dari kelas NomorSatu
        return $nomorSatu->auth($request); // Memanggil metode auth dari NomorSatu
    }

    /**
     * Metode untuk menangani proses logout.
     * Meneruskan request ke kelas NomorSatu.
     */
    public function logout(Request $request) {
        $nomorSatu = new NomorSatu(); // Membuat instance dari kelas NomorSatu
        return $nomorSatu->logout($request); // Memanggil metode logout dari NomorSatu
    }
}
