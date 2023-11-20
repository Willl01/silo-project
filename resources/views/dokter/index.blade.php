@extends('dokter.layouts')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Resep Dokter</h6>
    </div>
    <div class="card-body">
        <div class="form-row">
            <!-- Form untuk memilih obat -->
            <div class="col-sm-6 mb-3">
                <label for="obat_id">Pilih Obat</label>
                <select class="form-control" name="obat_id" id="obat_id">
                    <option value="" selected disabled>Pilih Obat</option>
                    @foreach($obat as $item)
                    @php
                    $stockStatus = $item->stok > 0 ? 'Sufficient' : 'Out of Stock';
                    $stockClass = $item->stok > 0 ? 'text' : 'text-danger';
                    @endphp
                    <option value="{{ $item->id_obat }}" data-stock="{{ $item->stok }}" data-harga="{{ $item->harga }}">
                        {{ $item->nama_obat }}
                    </option>
                    @endforeach
                </select>
                @error('obat_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Form untuk memasukkan kuantitas -->
            <div class="col-sm-4 mb-3">
                <label for="kuantitas">Kuantitas</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-secondary btn-number" data-type="minus" data-field="kuantitas">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <input type="number" name="kuantitas" class="form-control input-number" value="0" min="0" max="100">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="kuantitas">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Tombol untuk menambahkan obat ke daftar -->
            <div class="col-sm-2 mb-3" style="display: flex; align-items: flex-end;">
                <button type="button" class="btn btn-success" id="tambahObat">Tambah Obat</button>
            </div>
        </div>

        <!-- Tabel Daftar Obat -->
        <form action="/" method="post">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered" id="tabelDaftarObat" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Kuantitas</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="daftarObat">
                        <!-- Tempat obat yang ditambahkan akan ditampilkan di sini -->
                    </tbody>
                </table>
            </div>
            <div class="form-group row">
                <label for="nama_pasien" class="col-sm-2 col-form-label">Nama Pasien</label>
                <div class="col-sm-4">
                    <input type="text" name="nama_pasien" class="form-control @error('nama_pasien') is-invalid @enderror" id="nama_pasien" placeholder="Nama Pasien" value="{{ old('nama_pasien') }}">
                    @error('nama_pasien')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-4">
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat" value="{{ old('alamat') }}">
                    @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="umur" class="col-sm-2 col-form-label">Umur</label>
                <div class="col-sm-4">
                    <input type="text" name="umur" class="form-control" id="umur" placeholder="Umur" value="{{ old('umur') }}">
                    @error('umur')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <label for="berat_badan" class="col-sm-2 col-form-label">Berat Badan</label>
                <div class="col-sm-4">
                    <input type="text" name="berat_badan" class="form-control" id="berat_badan" placeholder="Berat Badan" value="{{ old('berat_badan') }}">
                    @error('berat_badan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <textarea rows="2" name="riwayat_pasien" class="form-control" placeholder="Riwayat Pasien">{{ old('riwayat_pasien') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <textarea rows="3" name="note" class="form-control" placeholder="Catatan Dokter">{{ old('note') }}</textarea>
                </div>
            </div>
            <!-- Total Harga -->
            <div class="col-sm-12 mb-3">
                <h5>Total Harga: <span id="totalHarga">0</span></h5>
                <input type="hidden" name="total_harga" id="totalHargaInput" value="">

            </div>
            <input type="hidden" name="obat_data" id="obatDataInput" value="">

            <div class="col-sm-12 mb-3">
                <button type="submit" class="btn btn-primary" id="buatResep">Buat Resep</button>
            </div>
        </form>
        <!-- Modal Edit Obat -->
        <div class="modal fade" id="modalEditObat" tabindex="-1" role="dialog" aria-labelledby="modalEditObatLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditObatLabel">Edit Obat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulir Edit Obat -->
                        <form id="formEditObat">
                            <div class="form-group">
                                <label for="editNamaObat">Nama Obat</label>
                                <input type="text" class="form-control" id="editNamaObat" name="editNamaObat" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="editKuantitas">Kuantitas</label>
                                <input type="number" class="form-control" id="editKuantitas" name="editKuantitas" required>
                            </div>
                            <div class="form-group">
                                <!-- Tambahkan elemen formulir sesuai dengan atribut yang ingin Anda edit -->
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha384-mC2/BkgiXcLU+YzMjQwkce6ic+FLiI19YXH1BdKGx9k7GUz4vmAaiHPtF/2c1RzM" crossorigin="anonymous" />
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function() {
                var obatData = [];
                var obatSelect = $('#obat_id');
                var tabelDaftarObat = $('#tabelDaftarObat');
                var totalHargaSpan = $('#totalHarga');

                obatSelect.select2({
                    placeholder: 'Cari atau pilih obat',
                    allowClear: true,
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                    templateResult: function(data) {
                        if (!data.id) {
                            return data.text;
                        }
                        var stockStatus = $(data.element).data('stock') > 0 ? 'Sufficient' : 'Out of Stock';
                        var stockClass = $(data.element).data('stock') > 0 ? 'text' : 'text-danger';
                        return $('<div><strong>' + data.text + '</strong> - Stok: ' + $(data.element).data('stock') + ' (' + stockStatus + ')</div>').addClass(stockClass);
                    },
                    templateSelection: function(data) {
                        return data.text;
                    }
                });

                // Menangani perubahan nilai
                obatSelect.on('change', function() {
                    var selectedOption = $(this).find(':selected');
                    var stockStatus = selectedOption.data('stock') > 0 ? 'Sufficient' : 'Out of Stock';
                    var stockClass = selectedOption.data('stock') > 0 ? 'text' : 'text-danger';
                    var selectedText = selectedOption.text();

                    // Mengganti nilai input dengan hasil pemilihan
                    // $(this).next().find('.select2-selection__rendered').html('<strong>' + selectedText + '</strong> - Stok: ' + selectedOption.data('stock') + ' (' + stockStatus + ')');
                });

                // Menangani tombol plus dan minus untuk kuantitas
                $('.btn-number').click(function(e) {
                    e.preventDefault();

                    var fieldName = $(this).attr('data-field');
                    var type = $(this).attr('data-type');
                    var input = $("input[name='" + fieldName + "']");
                    var currentVal = parseInt(input.val());

                    if (!isNaN(currentVal)) {
                        if (type === 'minus') {
                            var minValue = input.attr('min');
                            if (!minValue) minValue = 0;
                            if (currentVal > minValue) {
                                input.val(currentVal - 1).change().val(0);
                            }
                            if (parseInt(input.val()) === minValue) {
                                input.val(0);
                            }

                        } else if (type === 'plus') {
                            var maxValue = input.attr('max');
                            if (!maxValue) maxValue = 100;
                            if (currentVal < maxValue) {
                                input.val(currentVal + 1).change();
                            }
                            if (parseInt(input.val()) === maxValue) {
                                $(this).attr('disabled', true);
                            }
                        }
                    } else {
                        input.val(0);
                    }
                });

                $('.input-number').focusin(function() {
                    $(this).data('oldValue', $(this).val());
                });

                $('.input-number').change(function() {
                    var minValue = parseInt($(this).attr('min'));
                    var maxValue = parseInt($(this).attr('max'));
                    var valueCurrent = parseInt($(this).val());

                    if (!minValue) minValue = 1;
                    if (!maxValue) maxValue = 100;
                    if (!valueCurrent) valueCurrent = 0;

                    if (valueCurrent < minValue) {
                        $(this).val(minValue);
                    }
                    if (valueCurrent > maxValue) {
                        $(this).val(maxValue);
                    }
                });

                // Menambahkan obat ke daftar
                $('#tambahObat').on('click', function() {
                    var obatOption = obatSelect.find(':selected');

                    // Memastikan obat telah dipilih sebelum menambahkannya ke daftar
                    if (!obatOption.val()) {
                        alert('Pilih obat terlebih dahulu.');
                        return;
                    }

                    // Memeriksa stok obat
                    var stokObat = obatOption.data('stock');

                    var obatText = obatOption.text();
                    var obatId = obatOption.val();
                    var kuantitas = $('[name="kuantitas"]').val();
                    var harga = obatOption.data('harga');

                    // Membuat elemen baru untuk obat yang ditambahkan
                    var obatBaru = $('<tr>' +
                        '<td></td>' +
                        '<td>' + obatText + '</td>' +
                        '<td class="kuantitas">' + kuantitas + '</td>' +
                        '<td class="harga">' + harga + '</td>' +
                        '<td class="totalHarga">' + (kuantitas * harga) + '</td>' +
                        '<td>' +
                        '<button type="button" class="btn btn-warning btn-sm btn-edit" data-toggle="modal" data-target="#modalEditObat">Edit</button> ' +
                        '<button type="button" class="btn btn-danger btn-sm btn-delete">Delete</button>' +
                        '</td>' +
                        '</tr>');

                    // Menambahkan data ke elemen obat
                    obatBaru.data('obat-id', obatId);
                    obatBaru.data('kuantitas', kuantitas);
                    obatBaru.data('harga', harga);

                    // Menambahkan obat ke daftar
                    tabelDaftarObat.find('tbody').append(obatBaru);

                    // Menambahkan data obat ke dalam array obatData
                    obatData.push({
                        obat_id: obatId,
                        kuantitas: kuantitas,
                        harga: harga
                    });

                    // Mengosongkan input pilihan obat dan kuantitas
                    obatSelect.val(null).trigger('change');
                    $('[name="kuantitas"]').val(1);

                    // Menghitung total harga
                    hitungTotalHarga();
                    updateNomor();
                    $('#obatDataInput').val(JSON.stringify(obatData));
                    var id = "{{ Auth::user()->id }}";
                    obatBaru.append('<input type="hidden" name="id" value="' + id + '">');
                });

                // Menangani penghapusan obat dari daftar
                tabelDaftarObat.on('click', '.btn-delete', function() {
                    $(this).closest('tr').remove();
                    // Menghitung ulang total harga setelah menghapus obat
                    hitungTotalHarga();
                    updateNomor();
                    $('#obatDataInput').val(JSON.stringify(obatData));

                });

                // Menangani tombol edit pada setiap baris tabel
                tabelDaftarObat.on('click', '.btn-edit', function() {
                    var obatBaru = $(this).closest('tr');
                    var obatId = obatBaru.data('obat-id');
                    var kuantitas = obatBaru.data('kuantitas');
                    var harga = obatBaru.data('harga');

                    // Mengisi nilai formulir edit pada modal
                    var namaObat = obatBaru.find('td:nth-child(2)').text().trim(); // Menggunakan trim untuk membersihkan spasi tambahan
                    $('#editNamaObat').val(namaObat);
                    $('#editKuantitas').val(kuantitas);

                    // Menangani informasi obat yang sedang diedit
                    $('#modalEditObat').data('edited-obat', obatBaru);

                    // Menampilkan modal edit
                    $('#modalEditObat').modal('show');
                    $('.modal-backdrop').remove();

                });

                // Menangani submit formulir edit
                $('#formEditObat').submit(function(event) {
                    event.preventDefault();

                    // Ambil nilai dari formulir edit
                    var editedNamaObat = $('#editNamaObat').val();
                    var editedKuantitas = $('#editKuantitas').val();

                    // Dapatkan informasi obat yang sedang diedit
                    var obatBaru = $('#modalEditObat').data('edited-obat');

                    // Lakukan pembaruan nilai pada tabel
                    obatBaru.find('td:nth-child(2)').text(editedNamaObat);
                    obatBaru.find('td:nth-child(3)').text(editedKuantitas);
                    obatBaru.data('kuantitas', editedKuantitas);

                    // Perbarui data obat di dalam array obatData
                    var obatId = obatBaru.data('obat-id');
                    var obatIndex = obatData.findIndex(item => item.obat_id === obatId);
                    if (obatIndex !== -1) {
                        obatData[obatIndex].kuantitas = editedKuantitas;
                    }
                    // Hitung ulang total harga setelah mengedit obat
                    hitungTotalHarga();
                    updateNomor();
                    $('#obatDataInput').val(JSON.stringify(obatData));

                    // Sembunyikan modal edit
                    $('#modalEditObat').modal('hide');

                    // Sembunyikan backdrop secara manual
                    $('.modal-backdrop').remove();
                });

                // Fungsi untuk menghitung total harga
                function hitungTotalHarga() {
                    var totalHarga = 0;
                    tabelDaftarObat.find('tbody tr').each(function(index) {
                        var kuantitas = $(this).data('kuantitas');
                        var harga = $(this).data('harga');
                        var total = kuantitas * harga;
                        totalHarga += total;
                        $(this).find('.totalHarga').text(total);
                    });

                    // Menampilkan total harga pada span totalHarga
                    totalHargaSpan.text(totalHarga);
                }

                // Fungsi untuk mengupdate nomor pada tabel
                function updateNomor() {
                    tabelDaftarObat.find('tbody tr').each(function(index) {
                        $(this).find('td:first').text(index + 1);
                    });
                }

                function hitungTotalHarga() {
                    var totalHarga = 0;
                    tabelDaftarObat.find('tbody tr').each(function(index) {
                        var kuantitas = $(this).data('kuantitas');
                        var harga = $(this).data('harga');
                        var total = kuantitas * harga;
                        totalHarga += total;
                        $(this).find('.totalHarga').text(total);
                    });

                    // Menampilkan total harga pada span totalHarga
                    totalHargaSpan.text(totalHarga);

                    // Mengatur nilai input hidden totalHargaInput
                    $('#totalHargaInput').val(totalHarga);
                }
            });
        </script>
    </div>
</div>
@endsection