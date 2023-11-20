<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $obats = DB::table('obat')->get();
        $users = DB::table('users')->where('role', 'dokter')->get();
        $messages = [];
        $jumlahObat = Obat::count();
        $jumlahriwayat = Resep::count();
        $obatHabis = 0;
        $obatMenipis = 0;

        foreach ($obats as $obat) {
            if ($obat->stok <= 0) {
                // Tambahkan notifikasi bahwa stok obat habis
                $messages[] = "Stok obat {$obat->nama_obat} habis.";
                $obatHabis++;

            } elseif ($obat->stok < 5) {
                // Tambahkan notifikasi bahwa stok obat menipis
                $messages[] = "Stok obat {$obat->nama_obat} menipis. Sisa {$obat->stok} stok.";
                $obatMenipis++;

            }
        }

        return view('admin.index', ['messages' => $messages, 'jumlahObat' => $jumlahObat, 'jumlahriwayat' => $jumlahriwayat
                                    , 'obatHabis' => $obatHabis, 'obatMenipis' => $obatMenipis, 'users' =>$users]);
    }
}
