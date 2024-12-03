<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $siswa_laki_laki = DB::table('siswa')->where('jenis_kelamin', 'Laki-laki')->count();
            $siswa_perempuan = DB::table('siswa')->where('jenis_kelamin', 'Perempuan')->count();
            return view('home', [
                'total_siswa' => DB::table('siswa')->count(),
                'total_kelas' => DB::table('kelas')->count(),
                'total_admin' => DB::table('model_has_roles')->where('role_id', 1)->count(),
                'total_petugas' => DB::table('petugas')->count(),
                'siswa_laki_laki' => $siswa_laki_laki,
                'siswa_perempuan' => $siswa_perempuan,
            ]);
        }

        return view('home');
    }
    public function getTransactionsPerMonth()
    {
        $transactionsPerMonth = Pembayaran::last12Months()->get();
        return response()->json($transactionsPerMonth);
    }
}
