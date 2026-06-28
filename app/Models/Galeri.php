<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // Mengizinkan Laravel untuk menyimpan data ke dalam kolom ini
    protected $fillable = ['kategori', 'foto'];
}