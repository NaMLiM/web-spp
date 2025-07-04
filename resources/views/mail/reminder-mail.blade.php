<!DOCTYPE html>
<html>

    <head>
        <title>Pengingat Pembayaran SPP</title>
    </head>

    <body>
        <h2>Halo, {{ $student->nama_siswa }}</h2>

        <p>
            Kamu belum membayar SPP untuk bulan <strong>{{ $monthName }}</strong>.
        </p>

        <p>
            Silahkan lakukan pembayaran sebelum jatuh tempo pada <strong>{{ $lastDayOfMonth }} {{ $monthName }}
                {{ now()->year }}</strong>.
        </p>

        <p>Terimakasih.</p>
    </body>

</html>
