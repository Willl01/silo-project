@extends('admin.layouts')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Obat</h6>
    </div>
    <div class="card-body">
        <form action="/admin/obat/{{ $obat->id_obat }}" enctype="multipart/form-data" method="post">
            @method('put')
            @csrf
            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <input type="text" class="form-control " name="nama_obat" placeholder="Nama Obat" value="{{ $obat->nama_obat }}">
                    @error('nama_obat')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <label for="gambar_menu">Gambar Obat</label>
                    <input type="file" name="gambar_obat" class="form-control" id="file">
                    @error('gambar_obat')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <textarea rows="3" name="deskripsi_obat" class="form-control" placeholder="Deskripsi Obat">{{ $obat->deskripsi_obat }}</textarea>
                    @error('deskripsi_obat')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <select class="form-control " name="sediaan" placeholder="Bentuk Sediaan">
                        <option value="" selected disabled>Sediaan Obat</option>
                        <option value="Tablet" {{ $obat->sediaan == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="Kapsul" {{ $obat->sediaan == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                        <option value="Syrup" {{ $obat->sediaan == 'Syrup' ? 'selected' : '' }}>Syrup</option>
                        <option value="Ampul" {{ $obat->sediaan == 'Ampul' ? 'selected' : '' }}>Ampul</option>
                        <option value="Flask" {{ $obat->sediaan == 'Flask' ? 'selected' : '' }}>Flask</option>

                    </select>
                    @error('sediaan')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="text" class="form-control " name="dosis" placeholder="Dosis Obat" value="{{ $obat->dosis }}">
                    @error('dosis')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <select class="form-control " name="satuan" placeholder="satuan">
                        <option value="" selected disabled>Satuan</option>
                        <option value="g" {{ $obat->satuan == 'g' ? 'selected' : '' }}>g</option>
                        <option value="mg" {{ $obat->satuan == 'mg' ? 'selected' : '' }}>mg</option>
                        <option value="mcg" {{ $obat->satuan == 'mcg' ? 'selected' : '' }}>mcg</option>
                        <option value="IU" {{ $obat->satuan == 'IU' ? 'selected' : '' }}>IU</option>
                        <option value="ml" {{ $obat->satuan == 'ml' ? 'selected' : '' }}>ml</option>

                    </select>
                    @error('satuan')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-hashtag fa-fw"></i></div>
                        </div>
                        <input type="text" class="form-control " name="stok" placeholder="Jumlah Stok Obat" value="{{ $obat->stok }}">
                    </div>
                    @error('stok')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill-wave fa-fw"></i></div>
                        </div>
                        <input type="text" name="harga_display" class="form-control" id="harga_display" placeholder="Rp. 18,000" value="{{ $obat->harga }}">
                        <input type="hidden" name="harga" id="harga" value="{{ $obat->harga }}">
                    </div>
                    @error('harga')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-calendar fa-fw"></i></div>
                        </div>
                        <input type="date" class="form-control " name="tanggal_exp" value="{{ $obat->tanggal_exp }}">
                    </div>
                    @error('tanggal_exp')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <script>
                var displayInput = document.getElementById('harga_display');
                var hiddenInput = document.getElementById('harga');

                displayInput.addEventListener('focus', function() {
                    // Hapus format "Rp." dan tanda baca ribuan saat input mendapatkan fokus
                    displayInput.value = displayInput.value.replace(/^Rp.\s?/, "").replace(/\./g, "");
                });

                displayInput.addEventListener('blur', function() {
                    var formattedHarga = displayInput.value.trim();

                    // Hapus semua karakter kecuali angka
                    var harga = formattedHarga.replace(/\D/g, "");

                    // Format angka dengan ribuan menggunakan fungsi toLocaleString()
                    var displayValue = "Rp. " + parseInt(harga).toLocaleString();

                    // Tampilkan format "Rp. 18,000" di input tampilan
                    displayInput.value = displayValue;

                    // Simpan nilai asli (tanpa format "Rp.") di input tersembunyi
                    hiddenInput.value = harga;
                });

                // Submit form
                var form = document.querySelector('form');
                form.addEventListener('submit', function(event) {
                    // Mengganti nilai input tampilan dengan nilai asli (tanpa format "Rp.") sebelum mengirimkan form
                    displayInput.value = hiddenInput.value;
                });
            </script>
            <button type="reset" class="btn btn-danger">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection