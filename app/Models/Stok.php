<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stok';
    protected $primaryKey = 'id_obat';
    protected $fillable = ['nama_obat','deskripsi_obat','gambar_obat','sediaan', 'dosis', 'satuan', 'stok', 'harga'];
}
