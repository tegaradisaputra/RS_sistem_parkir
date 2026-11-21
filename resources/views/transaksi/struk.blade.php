<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @media print{
            button {
                display: none
            }
        }
    </style>
</head>
<body>
    <h1>Struk parkir</h1>

    <p>Plat Nomor: {{ $transaksi->kendaraan->plat_nomor }}</p>
    <p>Waktu Masuk: {{ $transaksi->waktu_masuk }}</p>
    <p>Waktu Keluar: {{ $transaksi->waktu_keluar }}</p>
    <p>Durasi Jam: {{ $transaksi->durasi_jam }} jam </p>
    <p>Total Biaya: {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</p>

    <button onclick="window.print()">Cetak</button>
</body>
</html>