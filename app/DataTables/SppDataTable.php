<?php

namespace App\DataTables;

use App\Models\Spp;
use DataTables;

class SppDataTable
{
    public function data()
    {
        return DataTables::of(Spp::query())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row"><a href="javascript:void(0)" id="' . $row->id .
                    '" class="btn btn-primary btn-sm ml-2 btn-edit">Ubah</a>';
                $btn .= '<a href="javascript:void(0)" id="' . $row->id .
                    '" class="btn btn-danger btn-sm ml-2 btn-delete">Hapus</a></div>';
                return $btn;
            })
            ->editColumn('nominal', function ($row) {
                return number_format($row->nominal, 0, ',', '.');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
