<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;
    protected $table = 'resep';
    protected $primaryKey = 'id_resep';
    protected $fillable = ['id','obat_data','total_harga', 'note', 'nama_pasien', 'alamat', 'umur', 'berat_badan', 'riwayat_pasien'];
}
