<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SPP</title>

        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
            rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/fontawesome-free/css/all.min.css"
            rel="stylesheet">
        <!-- Theme style -->
        <link href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/dist/css/adminlte.min.css" rel="stylesheet">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <x-alert></x-alert>
                        <div class="content-body" style="height: auto;">
                            <div class="mb-2 px-3 pt-3">

                                <div class="alert alert-info">
                                    <p><b>Terimakasih.</b> Telah Melakukan Pembayaran SPP <br>
                                        Berikut adalah Invoice Pembayaran Anda
                                    </p>
                                </div>
                                @if ($data->metode_pembayaran == 'QRIS' || $data->metode_pembayaran == 'SHOPEEPAY')
                                    <div id="qris-payment">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-6 col-sm-6 mb-3">
                                                <center class="p-3"
                                                    style="background-color:white; border-radius:20px;">
                                                    {{ $qr_code1 }}</center>
                                                <center><span class="badge bg-danger mt-3 text-center">QRIS 1</span>
                                                </center>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 col-sm-6 mb-3">
                                                <center class="p-3"
                                                    style="background-color:white; border-radius:20px;">
                                                    {{ $qr_code2 }}</center>
                                                <center><span class="badge bg-danger mt-3 text-center">QRIS 2</span>
                                                </center>
                                            </div>
                                        </div>

                                    </div>
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
                                                    <b
                                                        class="">{{ Carbon\Carbon::parse($data->created_at)->addHour() }}</b>
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
                                                    <b class="">Rp.
                                                        {{ number_format($data->jumlah_bayar, 2, '.', ',') }}</b>
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
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- overlayScrollbars -->
        <script
            src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
        </script>
        <!-- AdminLTE App -->
        <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/dist/js/adminlte.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
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
    </body>

</html>
