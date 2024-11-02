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
                    '" class="btn btn-primary btn-sm ml-2 btn-edit">Edit</a>';
                $btn .= '<a href="javascript:void(0)" id="' . $row->id .
                    '" class="btn btn-danger btn-sm ml-2 btn-delete">Hapus</a></div>';
                return $btn;
            })
            ->editColumn('nomimal', function ($row) {
                return number_format($row->nomimal, 2, ',', '.');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
