<?php

namespace App\DataTables;

use App\Models\Kelas;
use DataTables;

class KelasDataTable
{
    public function data()
    {
        $data = Kelas::latest();
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
