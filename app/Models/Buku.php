<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buku extends Model
{
    // Whitelist kolom yang boleh diisi massal (proteksi mass assignment)
    protected $fillable = ['kode', 'judul', 'kategori_id'];

    // Relasi: satu Buku milik satu Kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}