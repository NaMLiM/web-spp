<?php

namespace App\DataTables;

use App\Models\Petugas;
use DataTables;

class PetugasDataTable
{
    public function data()
    {
        $data = Petugas::latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row"><a href="javascript:void(0)" id="' . $row->id .
                    '" class="btn btn-primary btn-sm ml-2 btn-edit">Ubah</a>';
                $btn .= '<a href="javascript:void(0)" id="' . $row->id .
                    '" class="btn btn-danger btn-sm ml-2 btn-delete">Hapus</a></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
