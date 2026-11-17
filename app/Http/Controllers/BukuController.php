<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BukuController extends Controller
{
    // READ: daftar buku. with('kategori') = eager loading,
    // total 2 query (bukus + kategoris), bukan 1 + N query (N+1 problem)
    public function index(): View
    {
        return view('buku.index', [
            'bukus' => Buku::with('kategori')->orderBy('id')->get(),
        ]);
    }

    // CREATE: tampilkan form kosong
    public function create(): View
    {
        return view('buku.form', [
            'buku'      => new Buku(),
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    // CREATE: simpan data setelah validasi
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kode'        => ['required', 'max:10', 'unique:bukus,kode'],
            'judul'       => ['required', 'max:255'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
        ]);

        Buku::create($data);

        return redirect()->route('buku.index')->with('status', 'Buku ditambahkan.');
    }

    // UPDATE: tampilkan form berisi data lama (route model binding)
    public function edit(Buku $buku): View
    {
        return view('buku.form', [
            'buku'      => $buku,
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    // UPDATE: ignore id sendiri agar kode tidak dianggap duplikat dengan dirinya
    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $data = $request->validate([
            'kode'        => ['required', 'max:10', Rule::unique('bukus', 'kode')->ignore($buku->id)],
            'judul'       => ['required', 'max:255'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
        ]);

        $buku->update($data);

        return redirect()->route('buku.index')->with('status', 'Buku diperbarui.');
    }

    // DELETE
    public function destroy(Buku $buku): RedirectResponse
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('status', 'Buku dihapus.');
    }
}