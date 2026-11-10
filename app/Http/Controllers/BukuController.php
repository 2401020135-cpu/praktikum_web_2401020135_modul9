<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil input ?cari=..., paksa jadi string, buang spasi di tepi
        $cari = trim((string) $request->query('cari', ''));

        // Kalau $cari kosong, semua buku lolos.
        // Kalau tidak, judul harus mengandung $cari (stripos = tidak peka huruf besar/kecil).
        $buku = array_values(array_filter(
            Buku::contoh(),
            fn ($item) => $cari === '' || stripos($item['judul'], $cari) !== false
        ));

        return view('buku.index', compact('buku', 'cari'));
    }

    public function show(string $kode): View
    {
        // Cari buku yang kodenya cocok persis
        foreach (Buku::contoh() as $item) {
            if ($item['kode'] === $kode) {
                return view('buku.show', ['buku' => $item]);
            }
        }

        // Tidak ditemukan -> HTTP 404
        abort(404);
    }
}