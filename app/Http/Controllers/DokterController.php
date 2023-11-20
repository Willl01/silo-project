<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    public function index()
    {
        $obat = DB::table('obat')->get();

        return view('dokter.index', ['obat' => $obat]);
    }

    public function store(Request $request)
{
    $obatData = json_decode($request->input('obat_data'), true);
    $totalHarga = 0;

    // Mulai transaksi database
    DB::beginTransaction();

    try {
        foreach ($obatData as $obat) {
            // Pastikan ada kunci 'obat_id' pada setiap elemen $obat
            if (!isset($obat['obat_id'])) {
                // Kunci 'obat_id' tidak ditemukan, rollback transaksi
                DB::rollBack();
                return Redirect::back()->with('error', 'Kunci "obat_id" tidak ditemukan pada elemen obat.');
            }

            // Ambil data obat dari tabel obat
            $obatModel = Obat::find($obat['obat_id']);

            if ($obatModel) {
                // Kurangkan stok berdasarkan kuantitas
                $obatModel->stok -= $obat['kuantitas'];
                $obatModel->save();
            } else {
                // Obat tidak ditemukan, rollback transaksi
                DB::rollBack();
                return Redirect::back()->with('error', 'Obat tidak ditemukan.');
            }

            // Hitung total harga
            $totalHarga += $obat['kuantitas'] * $obat['harga'];
        }

        // Simpan resep ke database
        Resep::create([
            'id' => $request->input('id'),
            'obat_data' => json_encode($obatData), // Tetap gunakan json_encode untuk kolom 'obat_data'
            'total_harga' => $totalHarga,
            'nama_pasien' => $request->input('nama_pasien'),
            'alamat' => $request->input('alamat'),
            'umur' => $request->input('umur'),
            'berat_badan' => $request->input('berat_badan'),
            'riwayat_pasien' => $request->input('riwayat_pasien'),
            'note' => $request->input('note'),
        ]);

        // Commit transaksi
        DB::commit();

        return Redirect::back()->with('success', 'Resep berhasil dibuat');
    } catch (\Exception $e) {
        // Ada kesalahan, rollback transaksi
        DB::rollBack();
        return Redirect::back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
}