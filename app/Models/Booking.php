<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // PERBAIKAN UTAMA: Hubungkan model ini ke nama tabel asli di phpMyAdmin kamu
    protected $table = 'pembayarans';

    protected $fillable = [
        'nama_pelanggan',
        'paket',
        'total_pembayaran',
        'status',
        'bukti_pembayaran',
    ];
}