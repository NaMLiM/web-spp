<!DOCTYPE html>
<html>

    <head>
        <title>GENERATE PDF</title>
    </head>

    <body>
        <table style="margin: auto; padding-left: 100px; text-align: center; height: 0;">
            <tr style="height: 0; padding:0; margin:0;">
                <td style="height: 0; padding:0; margin:0;">PEMERINTAH PROVINSI JAWA TIMUR</td>
                <td rowspan="5"><img src="{{ public_path('img/LOGO_SMK_NURUL_AMANAH.jpg') }}" alt=""
                        style="width: 128px; padding-left: 50px"></td>
            </tr>
            <tr style="height: 0; padding:0; margin:0;">
                <td style="height: 0; padding:0; margin:0;">DINAS PENDIDIKAN</td>
            </tr>
            <tr style="height: 0; padding:0; margin:0;">
                <td style="height: 0; padding:0; margin:0;"><b>SEKOLAH MENENGAH KEJURUAN NURUL AMANAH</b></td>
            </tr>
            <tr style="height: 0; padding:0; margin:0;">
                <td style="height: 0; padding:0; margin:0;">Jl. Raya Tragah No. 9 Basanah</td>
            </tr>
            <tr style="height: 0; padding:0; margin:0;">
                <td style="height: 0; padding:0; margin:0;">
                    Email: - No telepon: -
                </td>
            </tr>
        </table>
        <br>
        <b>Dari tanggal {{ \Carbon\Carbon::parse(request()->tanggal_mulai)->format('d-m-Y') }} -
            {{ \Carbon\Carbon::parse(request()->tanggal_selesai)->format('d-m-Y') }}</b><br><br>
        <table style="border-color: white" border="1" cellspacing="0" cellpadding="10" width="100%">
            <thead>
                <tr style="background-color: green">
                    <th scope="col" style="font-family: sans-serif;">No</th>
                    <th scope="col" style="font-family: sans-serif;">Nama Siswa</th>
                    <th scope="col" style="font-family: sans-serif;">NISN</th>
                    <th scope="col" style="font-family: sans-serif;">Kelas</th>
                    <th scope="col" style="font-family: sans-serif;">Tanggal Bayar</th>
                    <th scope="col" style="font-family: sans-serif;">Petugas</th>
                    <th scope="col" style="font-family: sans-serif;">Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $row)
                    <tr>
                        <th scope="row" style="font-family: sans-serif;">{{ $loop->iteration }}</th>
                        <td style="font-family: sans-serif;">{{ $row->siswa->nama_siswa }}</td>
                        <td style="font-family: sans-serif;">{{ $row->nisn }}</td>
                        <td style="font-family: sans-serif;">{{ $row->siswa->kelas->nama_kelas }}</td>
                        <td style="font-family: sans-serif;">
                            {{ \Carbon\Carbon::parse($row->tanggal_bayar)->format('d-m-Y') }}
                        </td>
                        <td style="font-family: sans-serif;">{{ $row->petugas->nama_petugas }}</td>
                        <td style="font-family: sans-serif;">{{ $row->jumlah_bayar }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6" style="font-family: sans-serif;">
                        Total
                    </td>
                    <td style="font-family: sans-serif;">
                        Rp. <b>{{ $total }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>

</html>
