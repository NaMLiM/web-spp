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
                    <form method="POST" action="{{ route('pembayaran.print-pdf') }}">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input class="form-control" id="tanggal_mulai" name="tanggal_mulai" type="date"
                                required="">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input class="form-control" id="tanggal_selesai" name="tanggal_selesai" type="date"
                                required="">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger btn-sm" type="submit">
                                <i class="fas fa-print fa-fw"></i> PRINT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on("click", "#preview", function() {
            var tanggal_mulai = $("#tanggal_mulai").val()
            var tanggal_selesai = $("#tanggal_selesai").val()

            $.ajax({
                url: "/pembayaran/laporan/preview-pdf",
                method: "GET",
                data: {
                    tanggal_mulai: tanggal_mulai,
                    tanggal_selesai: tanggal_selesai,
                },
                success: function() {
                    window.open('/pembayaran/laporan/preview-pdf')
                }
            })
        })
    </script>
@endpush
