@extends('layouts.backend.app')
@section('title', 'Data Pembayaran')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <style>
        .img-responsive {
            max-width: 100%;
            /* Ensure images never exceed their container width */
            height: auto;
            /* Maintain aspect ratio */
        }

        /* Adjust image size for desktop screens */
        @media (min-width: 768px) {
            .img-responsive {
                max-width: 512px;
                /* Set maximum width for desktop */
            }
        }
    </style>
@endpush
@section('content_title', 'Tambah Pembayaran')
@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">
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
                                <input required="" type="hidden" name="siswa_id" value="{{ $siswa->id }}" readonly
                                    id="siswa_id" class="form-control">
                                <input required="" type="text" name="nama_siswa" value="{{ $siswa->nama_siswa }}"
                                    readonly id="nama_siswa" class="form-control">
                                @error('nama_siswa')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input required="" type="text" name="nisn" value="{{ $siswa->nisn }}" readonly
                                    id="nisn" class="form-control">
                                @error('nisn')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input required="" type="text" name="nis" value="{{ $siswa->nis }}" readonly
                                    id="nis" class="form-control">
                                @error('nis')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="kelas">Kelas:</label>
                                <input required="" type="text" name="kelas" value="{{ $siswa->kelas->nama_kelas }}"
                                    readonly id="kelas" class="form-control">
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
                                <select required="" name="tahun_bayar" id="tahun_bayar" class="form-control select2bs4">
                                    <option disabled="" selected="">- PILIH TAHUN -</option>
                                    @foreach ($spp as $row)
                                        <option value="{{ $row->tahun }}">{{ $row->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="jumlah_bayar" id="nominal_spp_label">Nominal SPP</label>
                                <input type="" name="nominal" readonly="" id="nominal" class="form-control">
                                <input required="" type="hidden" name="jumlah_bayar" readonly="" id="jumlah_bayar"
                                    class="form-control">
                                @error('jumlah_bayar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group select2-purple">
                                <label for="bulan_bayar">Untuk Bulan</label>
                                <select required="" name="bulan_bayar[]" id="bulan_bayar" class="select2"
                                    multiple="multiple" data-dropdown-css-class="select2-purple"
                                    data-placeholder="Pilih Bulan" style="width: 100%;">
                                    @foreach (Universe::bulanAll() as $bulan)
                                        <option value="{{ $bulan['nama_bulan'] }}">{{ $bulan['nama_bulan'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <select required="" name="metode_pembayaran" id="metode_pembayaran"
                                    class="form-control select2bs4">
                                    <option disabled="" selected="">- PILIH METODE -</option>
                                    <option value="BRI">Bank BRI</option>
                                    <option value="DANA">DANA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="total_bayar">Total Bayar:</label>
                                <input required="" type="" name="total_bayar" readonly="" id="total_bayar"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        @if (Request::segment(2) == 'pembayaran-spp')
                            <button id="btn-bayar" class="btn btn-primary"><i class="fas fa-save fa-fw"></i>
                                KONFIRMASI
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i>
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
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tutorial</div>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordion">
                        <div class="card" id="briTutorial">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        ATM</button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <ol>
                                        <li>Masukkan kartu ATM dan Masukkan 6 digit PIN ATM anda
                                        </li>
                                        <li>Setelah masuk ke menu utama, pilih “Pembayaran/Pembelian”<br><img
                                                src="{{ asset('img/tutorial/ATM/1.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        <li>Lalu pilih “Pembayaran/Pembelian Lain”<br><img
                                                src="{{ asset('img/tutorial/ATM/2.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        <li>Pilih “BRIVA”<br><img src="{{ asset('img/tutorial/ATM/3.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        </li>
                                        <li>Masukkan nomor Virtual Account (VA / BRIVA) yang yang anda dapatkan dari website
                                            pembayaran SPP SMK Nurul Amanah (Nomor Virtual akan selalu berubah setiap kali
                                            melakukan pembayaran)</li>
                                        </li>
                                        <li>Anda akan diarahkan ke menu tagihan dan lakukan pembayaran dengan menekan tombol
                                            “Konfirmasi”<br><img src="{{ asset('img/tutorial/ATM/4.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        <li>Cetak struk pembayaran dari mesin ATM dan otomatis status pembayaran akan
                                            berubah menjadi “Pembayaran Berhasil” di website pembayaran SPP SMK Nurul (Jika
                                            ada kendala hubungi pihak sekolah dengan menunjukkan bukti sturk pembayaran dan
                                            informasi pembayaran)<br><img src="{{ asset('img/tutorial/ATM/5.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="card" id="brimoTutorial">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block collapsed text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Aplikasi BRIMO</button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <ol>
                                        <li>Buka aplikasi brimo lalu cari menu “BRIVA”<br><img
                                                src="{{ asset('img/tutorial/BRIMO/1.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        <li>Pilih “Tambah Transaksi Baru”<br><img
                                                src="{{ asset('img/tutorial/BRIMO/2.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        <li>Masukkan Nomor Virtual yang anda dapatkan dari website pembayaran SPP SMK Nurul
                                            Amanah (Nomor Virtual akan selalu berubah setiap kali melakukan
                                            pembayaran)<br><img src="{{ asset('img/tutorial/BRIMO/3-1.png') }}"
                                                class="img-responsive float-end ms-2 shadow"><img
                                                src="{{ asset('img/tutorial/BRIMO/3-2.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        </li>
                                        <li>Anda akan diarahkan ke menu tagihan dan lakukan pembayaran dengan menekan tombol
                                            “Konfirmasi”</li>
                                        <li>Setelah mengkonfirmasi tagihan tersebut, akan mendapatkan bukti transaksi dari
                                            aplikasi BRIMO dan otomatis akan mendapatkan konfirmasi di website pembayaran
                                            SPP SMK Nurul Amanah. Jika terdapat kendala hubungi pihak sekolah dengan
                                            menyertakan bukti transaksi dan informasi pembayaran<br><img
                                                src="{{ asset('img/tutorial/BRIMO/4-1.png') }}"
                                                class="img-responsive float-end ms-2 shadow"><img
                                                src="{{ asset('img/tutorial/BRIMO/4-2.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="card" id="danaTutorial">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block collapsed text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        DANA</button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="showcollapse" aria-labelledby="headingThree"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <ol>
                                        <li>Masukkan nomor handphone anda yang aktif menggunakan DANA dan masukkan pin DANA
                                            anda<br><img src="{{ asset('img/tutorial/DANA/1.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        <li>Selanjutnya anda akan masuk ke menu tagihan dan pastikan saldo DANA anda
                                            mencukupi, setelah itu tekan “PAY” atau “Bayar”<br><img
                                                src="{{ asset('img/tutorial/DANA/2.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        <li>Setelah membayar, anda akan mendapat bukti transaksi dan status pembayaran akan
                                            otomatis berubah (Jika ada kendala, hubungi pihak sekolah dan sertakan bukti
                                            transaksi beserta informasi pembayaran pada Aplikasi Pembayaran SPP SMK Nurul
                                            Amanah)<br><img src="{{ asset('img/tutorial/DANA/3-1.png') }}"
                                                class="img-responsive float-end ms-2 shadow"><img
                                                src="{{ asset('img/tutorial/DANA/3-2.png') }}"
                                                class="img-responsive float-end ms-2 shadow"></li>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
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
            $(document).ready(function() {
                $('#danaTutorial').hide();
                $('#briTutorial').hide();
                $('#brimoTutorial').hide();
            });
        </script>
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
            $('#metode_pembayaran').on('change', function() {
                if ($(this).val() === 'BRI') {
                    $('#briTutorial').show();
                    $('#brimoTutorial').show();
                    $('#danaTutorial').hide();
                } else {
                    $('#danaTutorial').show();
                    $('#briTutorial').hide();
                    $('#brimoTutorial').hide();
                }
            });
            $(document).on("change", "#tahun_bayar", function() {
                var tahun = $(this).val()

                $.ajax({
                    url: "/public/spp/" + tahun,
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
                                    `/public/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
                            } else {
                                if (resOrder.method == "OVO") {
                                    window.location =
                                        `/public/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
                                } else if (resOrder.method == 'SHOPEEPAY') {
                                    if (isMobile()) {
                                        window.location = resOrder.redirect_url[0].url;
                                    } else {
                                        window.location =
                                            `/public/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
                                    }
                                } else if (resOrder.method != "SHOPEEPAY") {
                                    if (!isMobile()) {
                                        window.location = resOrder.redirect_url[0].url;
                                    } else {
                                        window.location = resOrder.redirect_url[1].url;
                                    }
                                } else {
                                    window.location =
                                        `/public/siswa/pembayaran-spp/invoice/${resOrder.invoice_id}`;
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
