@extends('layouts.backend.app')
@section('title', 'Data Pembayaran')
@push('css')
    <!-- Select2 -->
    <link href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"
        rel="stylesheet">
    <link type="text/css" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/sweetalert2/sweetalert2.min.css"
        rel="stylesheet">
@endpush
@section('content_title', 'Tambah Pembayaran')
@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-danger btn-sm" href="{{ url()->previous() }}">
                        <i class="fas fa-window-close fa-fw"></i>
                        BATALKAN
                    </a>
                </div>
                <div class="card-body">
                    @if (Request::segment(2) == 'pembayaran-spp')
                    @else
                        <form method="POST" action="{{ route('pembayaran.proses-bayar', $siswa->nisn) }}">
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa</label>
                                <input class="form-control" id="siswa_id" name="siswa_id" type="hidden"
                                    value="{{ $siswa->id }}" required="" readonly>
                                <input class="form-control" id="nama_siswa" name="nama_siswa" type="text"
                                    value="{{ $siswa->nama_siswa }}" required="" readonly>
                                @error('nama_siswa')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input class="form-control" id="nisn" name="nisn" type="text"
                                    value="{{ $siswa->nisn }}" required="" readonly>
                                @error('nisn')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input class="form-control" id="nis" name="nis" type="text"
                                    value="{{ $siswa->nis }}" required="" readonly>
                                @error('nis')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="kelas">Kelas:</label>
                                <input class="form-control" id="kelas" name="kelas" type="text"
                                    value="{{ $siswa->kelas->nama_kelas }}" required="" readonly>
                                @error('kelas')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="tahun_bayar">Untuk Tahun</label>
                                <select class="form-control select2bs4" id="tahun_bayar" name="tahun_bayar" required="">
                                    <option disabled="" selected="">- PILIH TAHUN -</option>
                                    @foreach ($spp as $row)
                                        <option value="{{ $row->tahun }}">{{ $row->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label id="nominal_spp_label" for="jumlah_bayar">Nominal SPP</label>
                                <input class="form-control" id="nominal" name="nominal" type="" readonly="">
                                <input class="form-control" id="jumlah_bayar" name="jumlah_bayar" type="hidden"
                                    required="" readonly="">
                                @error('jumlah_bayar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group select2-purple">
                                <label for="bulan_bayar">Untuk Bulan</label>
                                <select class="select2" id="bulan_bayar" name="bulan_bayar[]"
                                    data-dropdown-css-class="select2-purple" data-placeholder="Pilih Bulan"
                                    style="width: 100%;" required="" multiple="multiple">
                                    @foreach (Universe::bulanAll() as $bulan)
                                        <option value="{{ $bulan['nama_bulan'] }}">{{ $bulan['nama_bulan'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="total_bayar">Total Bayar:</label>
                                <input class="form-control" id="total_bayar" name="total_bayar" type=""
                                    required="" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        @if (Request::segment(2) == 'pembayaran-spp')
                            <button class="btn btn-primary" id="btn-bayar"><i class="fas fa-save fa-fw"></i>
                                KONFIRMASI
                            </button>
                        @else
                            <button class="btn btn-primary" type="submit"><i class="fas fa-save fa-fw"></i>
                                KONFIRMASI
                            </button>
                        @endif
                    </div>
                    @if (Request::segment(2) == 'pembayaran-spp')
                    @else
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <!-- Select2 -->
    <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript"
        src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

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
                    $("#nominal_spp_label").html(`Nominal SPP Tahun ` + tahun)
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
    <script>
        function isMobile() {
            const userAgent = navigator.userAgent || navigator.vendor || window.opera;
            // Deteksi perangkat Android
            if (/android|iPad|iPhone|iPod/i.test(userAgent)) {
                return true;
            }
            return false;
        }
        $("#btn-bayar").on("click", function() {
            var nisn = $("#nisn").val();
            var jumlah = $("#jumlah_bayar").val();
            var siswa_id = $("#siswa_id").val();
            var bulan_bayar = $("#bulan_bayar").val();
            var tahun_bayar = $("#tahun_bayar").val();
            var metode_pembayaran = $("#metode_pembayaran").val();
            $.ajax({
                url: "{{ route('siswa.proses-bayar', $siswa->nisn) }}",
                dataType: "JSON",
                type: "POST",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'nisn': nisn,
                    'jumlah_bayar': jumlah,
                    'siswa_id': siswa_id,
                    'metode_pembayaran': metode_pembayaran,
                    'tahun_bayar': tahun_bayar,
                    'bulan_bayar': bulan_bayar
                },
                success: function(resOrder) {
                    if (resOrder.status) {
                        if (!resOrder.redirect_url) {
                            window.location =
                                `/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
                        } else {
                            if (resOrder.method == "OVO") {
                                window.location =
                                    `/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
                            } else if (resOrder.method == 'SHOPEEPAY') {
                                if (isMobile()) {
                                    window.location = resOrder.redirect_url[0].url;
                                } else {
                                    window.location =
                                        `/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
                                }
                            } else if (resOrder.method != "SHOPEEPAY") {
                                if (!isMobile()) {
                                    window.location = resOrder.redirect_url[0].url;
                                } else {
                                    window.location = resOrder.redirect_url[1].url;
                                }
                            } else {
                                window.location =
                                    `/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
                            }
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sudah Lunas.',
                            text: 'Anda Sudah Melunasi Pembayaran Bulan Yang Diinput!'
                        });
                    }
                }
            });
        });
    </script>
@endpush
