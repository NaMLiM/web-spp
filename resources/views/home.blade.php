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
        @endrole
    </div>
@endsection
