<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // PASTIKAN 'metode_pembayaran' ADA DI DALAM SINI
    protected $fillable = [
        'kode_booking',
        'nama_pelanggan',
        'email_pelanggan', // sesuaikan dengan kolom Anda
        'no_hp',
        'paket',
        'tanggal_booking',
        'total_pembayaran',
        'status',
        'bukti_pembayaran',
        'metode_pembayaran', 
        'user_id'// <--- INI KUNCI UTAMANYA!
    ];
    
    // ... relasi atau kode lainnya ...
}