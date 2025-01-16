<?php

namespace App\Jawaban; // Namespace untuk mengorganisir kelas ini

use Illuminate\Support\Facades\Auth; // Mengimpor fasilitas autentikasi
use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani data HTTP
use App\Models\Event; // Mengimpor model Event untuk interaksi dengan database
use Illuminate\Support\Facades\Validator; // Mengimpor Validator untuk validasi data

class NomorDua {

    /**
     * Metode untuk menangani pengiriman data event.
     *
     * @param Request $request Data yang dikirim dari form.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman tertentu dengan pesan.
     */
    public function submit(Request $request) {

        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Nama event harus diisi, berupa string, dan maksimal 255 karakter
            'start' => 'required|date', // Tanggal mulai harus diisi dan berupa format tanggal yang valid
            'end' => 'required|date|after_or_equal:start', // Tanggal berakhir harus diisi, berupa format tanggal yang valid, dan setelah atau sama dengan tanggal mulai
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error dan input yang sudah diisi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat instance baru dari model Event
        $event = new Event();
        $event->name = $request->input('name'); // Mengisi nama event dari request
        $event->start = $request->input('start'); // Mengisi tanggal mulai dari request
        $event->end = $request->input('end'); // Mengisi tanggal berakhir dari request
        $event->user_id = Auth::id(); // Mengisi user_id dengan ID pengguna yang sedang login
        $event->save(); // Menyimpan data event ke database

        // Redirect ke halaman 'event.home' dengan pesan sukses
        return redirect()->route('event.home')->with('success', 'Event berhasil disimpan!');
    }
}
