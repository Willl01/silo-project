<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokOutController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel resep
        $resep = DB::table('resep')->get();

        $data = [];

        foreach ($resep as $item) {
            $jsonData = json_decode($item->obat_data, true);

            // Pastikan $jsonData adalah array dan tidak kosong
            if (is_array($jsonData) && !empty($jsonData)) {
                foreach ($jsonData as $obatData) {
                    // Akses nilai yang diinginkan dari setiap array JSON
                    $obatId = $obatData['obat_id'];
                    $namaObat = DB::table('obat')->where('id_obat', $obatId)->value('nama_obat');
                    $harga = $obatData['harga'];
                    $kuantitas = $obatData['kuantitas'];
                    $created_at = $item->created_at;

                    // Simpan data dalam bentuk array baru
                    $data[] = [
                        'nama_obat' => $namaObat,
                        'harga' => $harga,
                        'kuantitas' => $kuantitas,
                        'created_at' => $created_at,
                    ];
                }
            }
        }
        return view('admin.stok.out', ['data' => $data]);
    }
}
