<?php

namespace App\DataTables;

use App\Models\Kelas;
use Yajra\DataTables\Facades\DataTables;

class KelasPembayaranDataTable
{
    public function data()
    {
        $data = Kelas::latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row"><a href="' . route('pembayaran.index', $row->id) . '" id="' . $row->id .
                    '" class="btn btn-primary btn-sm ml-2 btn-edit">Pilih</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
