<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <title>Export PDF Hasil Kuesioner</title>
</head>

<body>
    <h3 style="text-align: center;">Hasil Kuesioner - {{ $periode }} Bulan Tahun {{ $tahun }}</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Masyarakat</th>
                <th>Nilai Rata-Rata</th>
                <th>Kategori Hasil</th>
                <th>Tanggal Isi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->masyarakat->nama ?? '-' }}</td>
                    <td>{{ $item->nilai_rata_rata }}</td>
                    <td>{{ $item->kategori_hasil }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_isi)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
