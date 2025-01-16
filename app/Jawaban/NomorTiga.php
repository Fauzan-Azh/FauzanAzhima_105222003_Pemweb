<?php

namespace App\Jawaban; // Namespace untuk mengorganisir kelas

use Illuminate\Support\Facades\Auth; // Untuk autentikasi
use Illuminate\Http\Request; // Untuk menangani request HTTP
use App\Models\Event; // Mengimpor model Event

class NomorTiga {

    /**
     * Mengambil semua data event milik pengguna yang sedang login.
     */
    public function getData() {
        $data = Event::where('user_id', Auth::id())->get(); // Ambil data event berdasarkan user_id
        return response()->json($data); // Kembalikan data dalam format JSON
    }

    /**
     * Mengambil data event tertentu milik pengguna yang sedang login.
     */
    public function getSelectedData(Request $request) {
        $data = Event::where('id', $request->id) // Cari event berdasarkan ID
            ->where('user_id', Auth::id()) // Pastikan event milik pengguna yang login
            ->firstOrFail(); // Jika tidak ditemukan, kembalikan 404

        return response()->json($data); // Kembalikan data dalam format JSON
    }

    /**
     * Memperbarui data event milik pengguna yang sedang login.
     */
    public function update(Request $request) {
        // Validasi input
        $request->validate([
            'event_id' => 'required|exists:events,id', // Pastikan event_id ada di database
            'name' => 'required|string|max:255', // Nama event harus diisi, berupa string, dan maksimal 255 karakter
            'start' => 'required|date', // Tanggal mulai harus diisi dan berupa format tanggal yang valid
            'end' => 'required|date|after:start', // Tanggal berakhir harus diisi, berupa format tanggal yang valid, dan setelah tanggal mulai
        ]);

        // Cari event berdasarkan ID dan user_id
        $event = Event::where('id', $request->event_id)
            ->where('user_id', Auth::id()) // Pastikan event milik pengguna yang login
            ->first();

        // Jika event ditemukan, perbarui data
        if ($event) {
            $event->name = $request->name;
            $event->start = $request->start;
            $event->end = $request->end;
            $event->save(); // Simpan perubahan ke database
            return redirect()->route('event.home')->with('berhasil', 'Event updated successfully.'); // Redirect dengan pesan sukses
        }

        // Jika event tidak ditemukan, kembalikan pesan error
        return redirect()->route('event.home')->with('error', 'Event tidak ditemukan.');
    }

    /**
     * Menghapus data event milik pengguna yang sedang login.
     */
    public function delete(Request $request) {
        // Cari event berdasarkan ID dan user_id
        $event = Event::where('id', $request->id)
                    ->where('user_id', Auth::id()) // Pastikan event milik pengguna yang login
                    ->first();

        // Jika event ditemukan, hapus data
        if ($event) {
            $event->delete(); // Hapus event dari database
            return response()->json(['success' => true]); // Kembalikan respons JSON sukses
        }

        // Jika event tidak ditemukan, kembalikan respons JSON gagal
        return response()->json(['success' => false]);
    }
}
