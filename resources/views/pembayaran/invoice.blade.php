@extends('layouts.backend.app')
@section('title', 'Data Pembayaran')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@section('content_title', 'Informasi Pembayaran')
@section('content')
    <x-alert></x-alert>
    <div class="content-body" style="height: auto;">
        <div class="mb-2 px-3 pt-3">
            @if (session('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ session('error') }}</li>
                    </ul>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($data->status == 'PAID')
                <div class="alert alert-success">
                    <b>Terima kasih telah Melakukan Pembayaran SPP</b><br> Semoga sukses dan sehat selalu.
                </div>
            @elseif($data->status == 'FAILED')
                <div class="alert alert-danger">
                    <b>Pembayaran Gagal / Dibatalkan</b><br> Silahkan Coba Lagi.
                </div>
            @else
                <div class="alert alert-info">
                    <b>Pembayaran.</b><br> Segera lakukan pembayaran sesuai dengan kode bayar
                    /
                    nomor VA yang tercantum. Pastikan nominal pembayaran juga sesuai dengan total bayar.
                </div>
                @if ($data->metode_pembayaran == 'QRIS' || $data->metode_pembayaran == 'SHOPEEPAY')
                    <div id="qris-payment">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-sm-6 mb-3">
                                <center style="background-color:white; border-radius:20px;" class="p-3">
                                    {{ $qr_code1 }}</center>
                                <center><span class="badge bg-danger mt-3 text-center">QRIS 1</span>
                                </center>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-sm-6 mb-3">
                                <center style="background-color:white; border-radius:20px;" class="p-3">
                                    {{ $qr_code2 }}</center>
                                <center><span class="badge bg-danger mt-3 text-center">QRIS 2</span>
                                </center>
                            </div>
                        </div>

                    </div>
                @endif
            @endif
            <div class="row mt-3">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card bg-card mb-3">
                        <div class="card-body">
                            <div>
                                <span class="d-block">Tanggal Pembuatan Invoice</span>
                                <b class="">{{ $data->created_at }}</b>
                            </div>
                            <div>
                                <span class="d-block">Batas Waktu Pembayaran</span>
                                <b class="">{{ Carbon\Carbon::parse($data->created_at)->addHour() }}</b>
                            </div>
                            <div class="mt-2">
                                <span class="d-block">Nomor Pesanan</span>
                                <b class="">{{ $data->invoice }}</b>
                            </div>
                            <div class="mt-2">
                                <span class="d-block">Metode Pembayaran</span>
                                <b class="text-info">{{ $data->metode_pembayaran }}</b>
                            </div>
                            @if (!empty($data->nomer_pembayaran) && ($data->metode_pembayaran != 'QRIS' && $data->metode_pembayaran != 'SHOPEEPAY'))
                                <div class="mt-2">
                                    <span class="d-block">Kode Bayar / Nomor VA</span>
                                    <b class="text-danger">{{ $data->nomer_pembayaran }}</b>
                                </div>
                            @endif
                            <div class="mt-2">
                                <span class="d-block">Jumlah Pembayaran</span>
                                <b class="">Rp. {{ number_format($data->jumlah_bayar, 2, '.', ',') }}</b>
                            </div>
                            <div class="mt-2">
                                <span class="d-block">Status Pembayaran</span>
                                @if ($data->status == 'Belum Lunas')
                                    <b class="text-warning" id="status-pembayaran">Menunggu Pembayaran</b>
                                @elseif($data->status == 'Pending')
                                    <b class="text-info" id="status-pembayaran">Sedang Diproses</b>
                                @elseif($data->status == 'Gagal')
                                    <b class="text-danger" id="status-pembayaran">Pembayaran Batal</b>
                                @elseif($data->status == 'PAID')
                                    <b class="text-success" id="status-pembayaran">Pembayaran Berhasil</b>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <table class="table-clear">
                                <tbody>
                                    <tr>
                                        <td class="left">
                                            <strong>Total Pembayaran :</strong>
                                        </td>
                                        <td class="right text-right">
                                            Rp.
                                            <span>
                                                {{ number_format($data->jumlah_bayar, 0, ',', '.') }},-
                                            </span>
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Pembayaran Bermasalah ?</h4>
                        <p>Hubungi admin agar dilakukan pengecekan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <!-- Select2 -->
    <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/js/select2.full.min.js"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        var pembelian = document.getElementById("status-pembayaran").innerHTML;
        if (pembelian == "Menunggu Pembayaran") {
            setTimeout(() => {
                document.location.reload();
            }, 5000);
        }

        function rupiah(number) {
            var formatter = new Intl.NumberFormat('ID', {
                style: 'currency',
                currency: 'idr',
            })

            return formatter.format(number)
        }

        $(document).on("change", "#tahun_bayar", function() {
            var tahun = $(this).val()

            $.ajax({
                url: "/spp/" + tahun,
                method: "GET",
                success: function(response) {
                    $("#nominal_spp_label").html(`Nominal SPP Tahun ` + tahun + ':')
                    $("#nominal").val(response.nominal_rupiah)
                    $("#jumlah_bayar").val(response.data.nominal)
                }
            })
        })

        $(document).on("change", "#bulan_bayar", function() {
            var bulan = $(this).val()
            var total_bulan = bulan.length
            var total_bayar = $("#jumlah_bayar").val()
            var hasil_bayar = (total_bulan * total_bayar)

            var formatter = new Intl.NumberFormat('ID', {
                style: 'currency',
                currency: 'idr',
            })

            $("#total_bayar").val(formatter.format(hasil_bayar))
        })
    </script>
@endpush
