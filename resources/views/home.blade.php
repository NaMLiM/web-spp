@extends('layouts.backend.app')
@section('title', 'Home')
@section('content_title', 'Home')
@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-lg">
            <div class="jumbotron">
                @role('admin|petugas')
                    <h1 class="display-4">Halo, {{ Universe::petugas()->nama_petugas }}!</h1>
                @endrole

                @role('siswa')
                    <h1 class="display-4">Halo, {{ Universe::siswa()->nama_siswa }}!</h1>
                @endrole
                <p class="lead">Selamat datang di WEB Pembayaran SPP SMK NURUL AMANAH.</p>
                <hr class="my-4">
            </div>
        </div>
    </div>
    @role('siswa')
        <div class="row">
            <div class="col-lg-6">
                <div class="card p-2">
                    <a href="/public/siswa/pembayaran-spp" class="card-block stretched-link">
                        <div class="card-body">Pembayaran</div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card p-2">
                    <a href="/public/siswa/history-pembayaran" class="card-block stretched-link">
                        <div class="card-body">Riwayat Pembayaran</div>
                    </a>
                </div>
            </div>
        </div>
    @endrole
    @role('admin')
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_siswa }}</h3>

                        <p>Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('siswa.index') }}" class="small-box-footer">Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $total_kelas }}</h3>

                        <p>Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <a href="{{ route('kelas.index') }}" class="small-box-footer">Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_petugas }}</h3>

                        <p>Petugas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('petugas.index') }}" class="small-box-footer">Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total_admin }}</h3>

                        <p>Admin</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-secret"></i>
                    </div>
                    <a href="{{ route('admin-list.index') }}" class="small-box-footer">Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-3">
                <div class="card p-2">
                    <a href="/public/admin/siswa" class="card-block stretched-link">
                        <div class="card-body">Siswa</div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-2">
                    <a href="/public/admin/pembayaran-spp" class="card-block stretched-link">
                        <div class="card-body">Pembayaran</div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-2">
                    <a href="/public/admin/kelas" class="card-block stretched-link">
                        <div class="card-body">Kelas</div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-2">
                    <a href="/public/pembayaran/status-pembayaran" class="card-block stretched-link">
                        <div class="card-body">Data Pembayaran</div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-2">
                    <a href="/public/pembayaran/history-pembayaran" class="card-block stretched-link">
                        <div class="card-body">Riwayat Pembayaran</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" style="background-color: white; border-radius:10px;">
                <canvas id="chart"></canvas>
            </div>
            <div class="col-lg-6" style="background-color: white; border-radius:10px;">
                <canvas id="canvas"></canvas>
            </div>
        </div>
        @push('js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"
                integrity="sha512-ZwR1/gSZM3ai6vCdI+LVF1zSq/5HznD3ZSTk7kajkaj4D292NLuduDCO1c/NT8Id+jE58KYLKT7hXnbtryGmMg=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Siswa Laki-laki", "Siswa Perempuan"],
                        datasets: [{
                            label: 'Siswa',
                            data: [
                                {!! $siswa_laki_laki !!},
                                {!! $siswa_perempuan !!},
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>
            <script>
                var chart = document.getElementById('chart').getContext('2d');
                $(document).ready(function() {
                    $.ajax({
                        url: '{{ route('data') }}',
                        success: function(data) {
                            var myChart = new Chart(chart, {
                                type: 'bar', // Replace with your desired chart type
                                data: {
                                    labels: data.map(function(item) {
                                        var monthNames = ["January", "February", "March",
                                            "April", "May", "June", "July", "August",
                                            "September", "October", "November", "December"
                                        ];
                                        return monthNames[item.month - 1];
                                    }),
                                    datasets: [{
                                        label: 'Transaksi',
                                        data: data.map(function(item) {
                                            return item.total;
                                        }),
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            ticks: {
                                                stepSize: 1, // Set the step size to 1 for integer values
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    });
                });
            </script>
        @endpush
    @endrole

@endsection
