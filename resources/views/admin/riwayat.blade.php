@extends('admin.layouts')

@section('content')
<section>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

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
                                        <tr style="text-align: center;">
                                            <th>No</th>
                                            <th>Nama Dokter</th>
                                            <th>Nama Pasien</th>
                                            <th>Nama Obat, Kuantitas, Harga</th>
                                            <th>Total Harga</th>
                                            <th>Note</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        @php
                                        $no = 1;
                                        @endphp

                                        @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d['name'] }}</td>
                                            <td>{{ $d['nama_pasien'] }}</td>
                                            <td>
                                                @if (isset($d['obats']) && is_array($d['obats']))
                                                @foreach ($d['obats'] as $obat)
                                                {{ $obat['nama_obat'] }}, {{ $obat['kuantitas'] }} , Rp.{{ $obat['harga'] }}<br>
                                                @endforeach
                                                @endif
                                            </td>
                                            <td>Rp.{{ $d['total_harga'] }}</td>
                                            <td>{{ $d['note'] }}</td>
                                            <td>{{ $d['created_at'] }}</td>
                                            <td style="text-align: center;"><button onclick="printNota('{{ $d['resep_id'] }}')" style="margin: auto; padding: 8px 16px;  border: none; border-radius: 5px; cursor: pointer;"><i class="fas fa-print"></i> Print</button></td>
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

<script>
    var resepData = @json($data);

    function printNota(resepId) {
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Resep Dokter</title>');

        // Add styles for better print appearance
        printWindow.document.write('<style>body{font-family: Arial, sans-serif; text-align: center;}</style>');

        printWindow.document.write('</head><body>');

        // Find the data for the specified resep_id
        var selectedData = resepData.find(function(item) {
            return item.resep_id == resepId;
        });

        if (selectedData) {
            printWindow.document.write('<div style="margin: auto; width: 50%; text-align: center;">');
            printWindow.document.write('<h3>Puskesmas Karang Joang</h3>');
            printWindow.document.write('<p>Jl. Soekarno Hatta No.23, Karang Joang</p>');
            printWindow.document.write('<hr>');

            // Creating a table for better organization
            printWindow.document.write('<table style="margin: auto; text-align: left;">');

            printWindow.document.write('<tr><td>Tanggal:</td><td>' + selectedData.created_at + '</td></tr>');
            printWindow.document.write('<tr><td>Dokter:</td><td>' + selectedData.name + '</td></tr>');
            printWindow.document.write('<tr><td>Apoteker:</td><td>{{ Auth::user()->name }}</td></tr>');
            printWindow.document.write('<tr><td>Nama Pasien:</td><td>' + selectedData.nama_pasien + '</td></tr>');
            printWindow.document.write('<tr><td>Alamat:</td><td>' + selectedData.alamat + '</td></tr>');

            printWindow.document.write('</table>');
            printWindow.document.write('<hr>');


            // Create a table for medication details
            printWindow.document.write('<table style="width: 100%; border-collapse: seperate;  ">');
            printWindow.document.write('<tr><th>No.</th><th>Nama Obat</th><th>Kuantitas</th><th>Harga</th><th>Total Harga</th></tr>');

            var no = 1;

            if (selectedData.obats && Array.isArray(selectedData.obats)) {
                selectedData.obats.forEach(function(obat) {
                    printWindow.document.write('<tr><td style="text-align: center;">' + no++ + '</td><td style="text-align: center;">' + obat.nama_obat + '</td><td style="text-align: center;">' + obat.kuantitas + '</td><td style="text-align: center;">Rp.' + obat.harga + '</td><td style="text-align: center;">Rp.' + (obat.harga * obat.kuantitas) + '</td></tr>');
                });
            }

            printWindow.document.write('</table>');

            printWindow.document.write('<p>Total: Rp.' + selectedData.total_harga + '</p>');
            printWindow.document.write('<p>Note: ' + selectedData.note + '</p>');
            printWindow.document.write('<hr>');
            printWindow.document.write('<p>~~Terima Kasih~~</p>');
            printWindow.document.write('<p>Semoga Lekas Sembuh</p>');
            printWindow.document.write('</div>');
        } else {
            // Handle case where resep_id is not found
            printWindow.document.write('<p>Data not found for resep_id: ' + resepId + '</p>');
        }

        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>


@endsection