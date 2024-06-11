@extends('layouts.backend.app')
@section('title', 'Data Pembayaran')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush
@section('content_title', 'Pembayaran Tahun ' . $tahun)
@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('siswa.proses-bayar', $siswa->nisn) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-fw fa-money-bill"></i> Bayar
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table-bordered table-striped table">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Universe::bulanAll() as $key => $value)
                                <tr>
                                    <td>{{ $value['nama_bulan'] }}</td>
                                    <td>
                                        @if (Universe::statusPembayaranBulan($value['nama_bulan'], $tahun) == 'DIBAYAR')
                                            {{ Universe::statusPembayaranBulan($value['nama_bulan'], $tahun) }}
                                        @else
                                            {{ Universe::statusPembayaranBulan($value['nama_bulan'], $tahun) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@stop

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js">
    </script>
    <script
        src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js">
    </script>
    <script
        src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
    </script>
    <script>
        $(function() {
            $("#dataTable1").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('#dataTable2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
