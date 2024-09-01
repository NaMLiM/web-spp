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
                <p class="lead">Selamat datang di WEB SPPR.</p>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="row">
        @role('siswa')
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
            <div class="col-lg-12" style="background-color: white; border-radius:10px;"><canvas id="chart"></canvas>
            </div>
        </div>
    @endrole
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"
            integrity="sha512-ZwR1/gSZM3ai6vCdI+LVF1zSq/5HznD3ZSTk7kajkaj4D292NLuduDCO1c/NT8Id+jE58KYLKT7hXnbtryGmMg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

@endsection
