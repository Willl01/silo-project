<!DOCTYPE html>
<html>
<head>
    <title>Print Resep</title>
</head>
<body>
    <h1>Riwayat Resep</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Resep ID</th>
                <th>Created At</th>
                <th>Total Harga</th>
                <th>Note</th>
                <th>Obat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $resep)
                <tr>
                    <td>{{ $resep['resep_id'] }}</td>
                    <td>{{ $resep['created_at'] }}</td>
                    <td>{{ $resep['total_harga'] }}</td>
                    <td>{{ $resep['note'] }}</td>
                    <td>
                        <ul>
                            @foreach($resep['obats'] as $obat)
                                <li>{{ $obat['nama_obat'] }} - Kuantitas: {{ $obat['kuantitas'] }} - Harga: {{ $obat['harga'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
