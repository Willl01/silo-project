<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        $loggedInDoctor = auth()->user();

        $reseps = DB::table('resep')
            ->join('users', 'resep.id', '=', 'users.id')
            ->where('users.role', 'dokter')
            ->where('users.name', $loggedInDoctor->name)
            ->get();

        $data = [];

        foreach ($reseps as $resep) {
            // Ambil data obat dari tabel obat
            $obatData = json_decode($resep->obat_data, true);
            $obats = [];

            foreach ($obatData as $obatItem) {
                $obatId = $obatItem['obat_id'];
                $obat = DB::table('obat')->where('id_obat', $obatId)->first();

                // Pastikan obat ditemukan
                if ($obat) {
                    $obats[] = [
                        'nama_obat' => $obat->nama_obat,
                        'kuantitas' => $obatItem['kuantitas'],
                        'harga' => $obatItem['harga'],
                    ];
                }
            }

            // Jika ada obat pada resep, tambahkan ke data
            if (!empty($obats)) {
                $data[] = [
                    'name' => $resep->name,
                    'resep_id' => $resep->id,
                    'created_at' => $resep->created_at,
                    'total_harga' => $resep->total_harga,
                    'note' => $resep->note,
                    'nama_pasien' => $resep->nama_pasien,
                    'alamat' => $resep->alamat,
                    'umur' => $resep->umur,
                    'berat_badan' => $resep->berat_badan,
                    'riwayat_pasien' => $resep->riwayat_pasien,
                    'obats' => $obats,
                ];
            }
        }

        return view('dokter.riwayat', ['data' => $data]);
    }
}
