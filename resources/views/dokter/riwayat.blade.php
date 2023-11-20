@extends('dokter.layouts')

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
                                            <th>Nama Dokter</th>
                                            <th>Nama Pasien</th>
                                            <th>Alamat</th>
                                            <th>Nama Obat, Kuantitas, Harga</th>
                                            <th>Total Harga</th>
                                            <th>Note</th>
                                            <th>Tanggal</th>
                                            <!-- <th style="text-align: center;">Aksi</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        </tr>
                                        @php
                                        $no = 1;
                                        @endphp

                                        @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d['name'] }}</td>
                                            <td>{{ $d['nama_pasien'] }}</td>
                                            <td>{{ $d['alamat'] }}</td>
                                            <td>
                                                @foreach ($d['obats'] as $obat)
                                                {{ $obat['nama_obat'] }}, {{ $obat['kuantitas'] }} , Rp.{{ $obat['harga'] }}<br>
                                                @endforeach
                                            </td>
                                            <td>Rp.{{ $d['total_harga'] }}</td>
                                            <td>{{ $d['note'] }}</td>
                                            <td>{{ $d['created_at'] }}</td>
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