@extends('admin.layouts')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Formulir Stok In</h6>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0 mx-auto">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0 mx-auto">
                <label for="pilihObat">Pilih Obat:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="namaobat" name="namaobat" placeholder="Cari Obat" required readonly>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#obatModal">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0 mx-auto">
                <label for="namaObat">Nama Obat:</label>
                <input type="text" class="form-control" id="namaObat" name="namaObat" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0 mx-auto">
                <label for="inisialStok">Inisial Stok:</label>
                <input type="number" class="form-control" id="inisialStok" name="inisialStok" readonly>
            </div>
        </div>
        <form action="stokin/tambah" method="post">
            @csrf
            <input type="hidden" name="id_obat" id="id_obat">
            <div class="form-group row">
                <div class="col-sm-4 mb-3 mb-sm-0 mx-auto">
                    <label for="kuantitas">Kuantitas:</label>
                    <input type="number" class="form-control" id="kuantitas" name="kuantitas" required>
                </div>
            </div>
            <div class="form-group row ">
                <div class="col-sm-4 mb-3 mb-sm-0 mx-auto ">
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary" onclick="validateForm()">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Search Obat -->
    <div class="modal fade" id="obatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" style="background-color: white;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Sediaan</th>
                                    <th>Dosis</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp

                                @foreach($obat as $o)
                                @if($o->stok <= 0 || $o->stok < 100) <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $o->nama_obat}}</td>
                                        <td>{{ $o->sediaan}}</td>
                                        <td>{{ $o->dosis}}</td>
                                        <td>{{ $o->satuan}}</td>
                                        <td>{{ $o->stok}}</td>
                                        <td>Rp.{{ $o->harga }}</td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-info btn-sm" onclick="pilihObat('{{ $o->id_obat }}', '{{ $o->nama_obat }}', '{{ $o->sediaan }}', '{{ $o->dosis }}', '{{ $o->satuan }}', '{{ $o->stok }}', '{{ $o->harga }}')" data-dismiss="modal">
                                                Pilih
                                            </button>
                                        </td>
                                        </tr>
                                        @endif
                                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>Pilih Obat terlebih dahulu.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeErrorModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pilihObat(id_obat, namaObat, sediaan, dosis, satuan, stok, harga) {
            console.log(id_obat);
            // Isi nilai ke input atau elemen lainnya sesuai kebutuhan
            $('#id_obat').val(id_obat);
            $('#namaobat').val(namaObat);
            $('#namaObat').val(namaObat);
            $('#sediaan').val(sediaan);
            $('#dosis').val(dosis);
            $('#satuan').val(satuan);
            $('#inisialStok').val(stok);
            $('#harga').val(harga);
        }

        function validateForm() {
            var idObat = $('#id_obat').val();

            if (!idObat) {
                // Tampilkan modal kesalahan jika obat belum dipilih
                $('#errorModal').modal('show');
                return false; // Batalkan pengiriman formulir
            }

            // Obat telah dipilih, lanjutkan dengan pengiriman formulir
            return true;
        }

        function closeErrorModal() {
            $('#errorModal').modal('hide');
        }
    </script>
</div>

@endsection