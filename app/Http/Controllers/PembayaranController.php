<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Petugas;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use PDF;
use App\DataTables\KelasPembayaranDataTable;

class PembayaranController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Siswa::with(['kelas'])->latest();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 $btn = '<div class="row"><a href="' . route('pembayaran.bayar', $row->nisn) . '"class="btn btn-primary btn-sm ml-2">
    //                 <i class="fas fa-money-check"></i> BAYAR
    //                 </a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('pembayaran.index');
    // }
    public function index(Request $request, $kelas)
    {
        if ($request->ajax()) {
            $data = Siswa::with(['kelas'])->where('kelas_id', $kelas)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row"><a href="' . route('pembayaran.bayar', $row->nisn) . '"class="btn btn-primary btn-sm ml-2">
                    <i class="fas fa-money-check"></i> BAYAR
                    </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pembayaran.index')->with('kelas', $kelas);
    }
    public function kelas(Request $request, KelasPembayaranDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }

        return view('admin.kelas-pembayaran.index');
    }

    public function bayar($nisn)
    {
        $siswa = Siswa::with(['kelas'])
            ->where('nisn', $nisn)
            ->first();

        $spp = Spp::all();

        return view('pembayaran.bayar', compact('siswa', 'spp'));
    }
    public function bayarSiswa($nisn)
    {
        $siswa = Siswa::with(['kelas'])
            ->where('nisn', $nisn)
            ->first();

        $spp = Spp::all();

        return view('pembayaran.siswa-bayar', compact('siswa', 'spp'));
    }
    public function spp($tahun)
    {
        $spp = Spp::where('tahun', $tahun)
            ->first();

        return response()->json([
            'data' => $spp,
            'nominal_rupiah' => 'Rp ' . number_format($spp->nominal, 0, 2, '.'),
        ]);
    }

    public function prosesBayar(Request $request)
    {
        $request->validate([
            'jumlah_bayar' => 'required',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong!'
        ]);

        $petugas = Petugas::where('user_id', Auth::user()->id)
            ->first();
        $pembayaran = Pembayaran::whereIn('bulan_bayar', $request->bulan_bayar)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->where('siswa_id', $request->siswa_id)
            ->pluck('bulan_bayar')
            ->toArray();

        if (!$pembayaran) {
            DB::transaction(function () use ($request, $petugas) {
                foreach ($request->bulan_bayar as $bulan) {
                    Pembayaran::create([
                        'kode_pembayaran' => 'SPPR' . Str::upper(Str::random(5)),
                        'petugas_id' => $petugas->id,
                        'siswa_id' => $request->siswa_id,
                        'nisn' => $request->nisn,
                        'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                        'tahun_bayar' => $request->tahun_bayar,
                        'bulan_bayar' => $bulan,
                        'jumlah_bayar' => $request->jumlah_bayar,
                    ]);
                }
            });
            return redirect()->route('pembayaran.history-pembayaran')
                ->with('success', 'Pembayaran berhasil disimpan!');
        } else {
            return back()
                ->with('error', 'Siswa Dengan Nama : ' . $request->nama_siswa . ' , NISN : ' .
                    $request->nisn . ' Sudah Membayar Spp di bulan yang diinput (' .
                    implode(',', $pembayaran) . ")" . ' , di Tahun : ' . $request->tahun_bayar . ' , Pembayaran Dibatalkan');
        }
    }

    public function prosesBayarSiswa(Request $request)
    {
        $xendit = new XenditController();
        $request->validate([
            'jumlah_bayar' => 'required',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong!'
        ]);

        $pembayaran = Pembayaran::whereIn('bulan_bayar', $request->bulan_bayar)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->where('siswa_id', $request->siswa_id)
            ->exists();

        if (!$pembayaran) {
            $unik = date('Hs');
            $kode_unik = substr(str_shuffle(1234567890), 0, 3);
            $invoiceId = 'SPP' . $unik . $kode_unik;
            $totalBayar = 0;
            foreach ($request->bulan_bayar as $bulan) {
                $totalBayar += $request->jumlah_bayar;
            }
            $createInvoice = $xendit->createPembayaran($invoiceId, $totalBayar, $request->metode_pembayaran, Auth::user()->email);
            if ($createInvoice['success'] == true) {
                $invoice = new Invoice();
                $invoice->invoice = $invoiceId;
                $invoice->siswa_id = $request->siswa_id;
                $invoice->nisn = $request->nisn;
                $invoice->jumlah_bayar = $createInvoice['amount'];
                $invoice->metode_pembayaran = $request->metode_pembayaran;
                $invoice->bulan_bayar = serialize($request->bulan_bayar);
                $invoice->tahun_bayar = $request->tahun_bayar;
                $invoice->status = 'Belum Lunas';
                if (isset($createInvoice['payment_number'])) {
                    $invoice->nomer_pembayaran = $createInvoice['payment_number'];
                }
                $invoice->log = json_encode($createInvoice);
                $invoice->saveQuietly();
                if (isset($createInvoice['actions'])) {
                    $redirect = $createInvoice['actions'];
                }
                return response()->json([
                    'status' => true,
                    'invoice_id' => $invoiceId,
                    'method' => $request->metode_pembayaran,
                    'redirect_url' => isset($redirect) ? $redirect : null
                ]);
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function invoice($invoice)
    {
        $data = Invoice::where('invoice', $invoice)->first();
        return view('pembayaran.invoice', compact('data'));
    }

    public function statusPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Siswa::with(['kelas'])
                ->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row"><a href="' . route('pembayaran.status-pembayaran.show', $row->nisn) .
                        '"class="btn btn-primary btn-sm">DETAIL</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pembayaran.status-pembayaran');
    }

    public function statusPembayaranShow(Siswa $siswa)
    {
        $spp = Spp::all();
        return view('pembayaran.status-pembayaran-tahun', compact('siswa', 'spp'));
    }

    public function statusPembayaranShowStatus($nisn, $tahun)
    {
        $siswa = Siswa::where('nisn', $nisn)
            ->first();

        $spp = Spp::where('tahun', $tahun)
            ->first();

        $pembayaran = Pembayaran::with(['siswa'])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_bayar', $spp->tahun)
            ->get();

        return view('pembayaran.status-pembayaran-show', compact('siswa', 'spp', 'pembayaran'));
    }

    public function historyPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Pembayaran::with(['petugas', 'siswa' => function ($query) {
                $query->with('kelas');
            }])
                ->latest()->get();
            if (auth()->user()->hasRole('admin')) {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="row"><a href="' . route('pembayaran.history-pembayaran.print', $row->id) . '"class="btn btn-danger btn-sm ml-2" target="_blank">
                <i class="fas fa-print fa-fw"></i></a>';
                        return $btn;
                    })
                    ->make(true);
            } else {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
        }

        return view('pembayaran.history-pembayaran');
    }

    public function printHistoryPembayaran($id)
    {
        $data['pembayaran'] = Pembayaran::with(['petugas', 'siswa'])
            ->where('id', $id)
            ->first();

        $pdf = PDF::loadView('pembayaran.history-pembayaran-preview', $data);
        return $pdf->stream();
    }

    public function laporan()
    {
        return view('pembayaran.laporan');
    }

    public function printPdf(Request $request)
    {
        $tanggal = $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        $data['pembayaran'] = Pembayaran::with(['petugas', 'siswa'])
            ->whereBetween('tanggal_bayar', $tanggal)->get();
        $data['total'] = Pembayaran::whereBetween('tanggal_bayar', $tanggal)->sum('jumlah_bayar');

        if ($data['pembayaran']->count() > 0) {
            $pdf = PDF::loadView('pembayaran.laporan-preview', $data);
            return $pdf->download('pembayaran-spp-' .
                Carbon::parse($request->tanggal_mulai)->format('d-m-Y') . '-' .
                Carbon::parse($request->tanggal_selesai)->format('d-m-Y') .
                Str::random(9) . '.pdf');
        } else {
            return back()->with('error', 'Data pembayaran spp tanggal ' .
                Carbon::parse($request->tanggal_mulai)->format('d-m-Y') . ' sampai dengan ' .
                Carbon::parse($request->tanggal_selesai)->format('d-m-Y') . ' Tidak Tersedia');
        }
    }
}
