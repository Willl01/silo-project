<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obat = DB::table('obat')->get();

        return view('admin.obat.index', ['obat' => $obat]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data input
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'deskripsi_obat' => 'required',
            'gambar_obat' => 'required|mimes:jpeg,png,jpg|max:5000',
            'sediaan' => 'required',
            'dosis' => 'required',
            'satuan' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'tanggal_exp' => 'required'

        ], [
            'gambar_obat.max' => 'Ukuran gambar tidak boleh melebihi 5Mb.',
        ]);

        // cek validasi
        if ($validator->fails()) {
            return redirect('admin/obat/create')
                ->withErrors($validator)
                ->withInput();
        }

        $requestData = $request->all();
        $filename = time() . $request->file('gambar_obat')->getClientOriginalName();
        $path = $request->file('gambar_obat')->storeAs('images', $filename, 'public');
        $requestData["gambar_obat"] = '/storage/' . $path;

        Obat::create($requestData);

        // kembalikan ke halaman daftar obat
        return redirect('admin/obat')
            ->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $obat = DB::table('obat')->where('id_obat', $id)->first();
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validasi data input
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'deskripsi_obat' => 'required',
            'sediaan' => 'required',
            'dosis' => 'required',
            'satuan' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'tanggal_exp' => 'required'

        ], [
            'gambar_obat.max' => 'Ukuran gambar tidak boleh melebihi 5Mb.',
        ]);

        // cek validasi
        if ($validator->fails()) {
            return redirect('admin/obat/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $obat = Obat::findOrFail($id);
        $requestData = $request->all();

        // cek apakah ada gambar yang diupload
        if ($request->hasFile('gambar_obat')) {
            $filename = time() . $request->file('gambar_obat')->getClientOriginalName();
            $path = $request->file('gambar_obat')->storeAs('images', $filename, 'public');
            $requestData["gambar_obat"] = '/storage/' . $path;

            // hapus gambar lama
            Storage::disk('public')->delete(str_replace('/storage/', '', $obat->gambar_obat));
        } else {
            // jika tidak ada gambar yang diupload, gunakan gambar lama
            $requestData["gambar_obat"] = $obat->gambar_obat;
        }

        $obat->update($requestData);

        // kembalikan ke halaman daftar obat
        return redirect('admin/obat')
            ->with('success', 'Obat berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $obat = Obat::find($id);

        // hapus gambar dari penyimpanan
        if ($obat->gambar_obat) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $obat->gambar_obat));
        }

        $obat->delete();

        return redirect('admin/obat')->with('status', 'Data Obat Berhasil Dihapus!');
    }
}
