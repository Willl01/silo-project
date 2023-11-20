@extends('admin.layouts')

@section('content')
<section>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-12">
            <div class="infinity2-container">
                <div class="py-1">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" style="background-color: white;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Obat</th>
                                            <th>Gambar Obat</th>
                                            <th>Sediaan</th>
                                            <th>Dosis</th>
                                            <th>satuan</th>
                                            <th>Stok</th>
                                            <th>Deskripsi</th>
                                            <th>Harga</th>
                                            <th>Tanggal Expired</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        </tr>
                                        @php
                                        $no = 1;
                                        @endphp

                                        @foreach($obat as $o)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $o->nama_obat}}</td>
                                            <td>
                                                <div class="gallery-item">
                                                    <a href="{{ $o->gambar_obat }}" class="gallery-lightbox" data-gall="gallery-item">
                                                        <img src="{{ $o->gambar_obat }}" width="70" height="70" alt="gambar_obat">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $o->sediaan}}</td>
                                            <td>{{ $o->dosis}}</td>
                                            <td>{{ $o->satuan}}</td>
                                            <td>{{ $o->stok}}</td>
                                            <td>
                                                <button class="btn-lihat-detail" data-deskripsi="{{ $o->deskripsi_obat }}">
                                                    <i class="fa fa-eye"></i> Lihat Detail
                                                </button>
                                            </td>
                                            <td>Rp.{{ $o->harga }}</td>
                                            <td>{{ $o->tanggal_exp }}</td>
                                            <td style="text-align: center;">
                                                <a href="{{ route('obat.edit', $o->id_obat) }}" class="bi bi-pencil-square"></a>
                                                |
                                                <a href="#" class="bi bi-trash border-0 text-danger" data-toggle="modal" data-target="#deleteModal{{$o->id_obat}}"></a>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{$o->id_obat}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" data-backdrop="false">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah ingin menghapus data ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <a href="/obat/delete/{{ $o->id_obat}}" class="btn btn-danger">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Detail Obat</h3>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnLihatDetail = document.querySelectorAll('.btn-lihat-detail');
            const modal = document.getElementById('myModal');
            const modalContent = document.getElementById('modalContent');
            const closeBtn = document.querySelector('.close');

            btnLihatDetail.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const deskripsi = this.getAttribute('data-deskripsi');
                    modalContent.innerHTML = deskripsi;
                    modal.style.display = 'block';
                });
            });

            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            height: 30%;
            text-align: justify;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</section>


@endsection