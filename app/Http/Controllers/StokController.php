<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StokController extends Controller
{
    public function index()
    {
        $obat = DB::table('obat')->get();

        return view('admin.stok.in', ['obat' => $obat]);
    }

    public function tambahStok(Request $request)
    {
        // Validasi form jika diperlukan
        $request->validate([
            'id_obat' => 'required',
            'kuantitas' => 'required|numeric|min:1',
        ]);

        // Dapatkan obat berdasarkan ID
        $obat = Obat::find($request->id_obat);

        // Ambil data dari formulir
        $id_obat = $request->input('id_obat');
        $kuantitas = $request->input('kuantitas');

        // Simpan ke dalam tabel stok
        $stok = new Stok();
        $stok->id_obat = $id_obat;
        $stok->kuantitas = $kuantitas;
        $stok->save();

        // Periksa apakah obat ditemukan
        if ($obat) {
            // Tambahkan kuantitas ke stok
            $obat->stok += $request->kuantitas;

            // Simpan perubahan
            $obat->save();

            return redirect()->back()->with('success', 'Stok berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Obat tidak ditemukan');
        }
    }
}
