@extends('layouts.backend.app')
@section('title', 'Laporan')
@section('content_title', 'Laporan')
@section('content')
    <x-alert></x-alert>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Laporan Pembayaran</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.belum_bayar.export') }}">
                        @csrf
                        <div class="form-group">
                            <label for="periode">Periode (Bulan dan Tahun):</label>
                            <input id="periode" name="periode" type="month">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger btn-sm" type="submit">
                                <i class="fas fa-print fa-fw"></i> Export
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
