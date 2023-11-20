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
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Tanggal</th>
                                            <!-- <th style="text-align: center;">Aksi</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        </tr>
                                        @php
                                        $no = 1;
                                        @endphp

                                        @foreach($data as $o)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $o['nama_obat'] }}</td>
                                            <td>Rp.{{ $o['harga'] }}</td>
                                            <td>{{ $o['kuantitas'] }}</td>
                                            <td>{{ $o['created_at'] }}</td>
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

</section>

@endsection