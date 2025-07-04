<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\SiswaBelumBayarExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{

    public function showExportForm()
    {
        return view('pembayaran.laporan-belumbayar'); // We will create this view next
    }
    /**
     * Handle the export request for students with unpaid fees.
     */
    public function exportSiswaBelumBayar(Request $request)
    {
        // 1. Validate the input
        $validated = $request->validate([
            'periode' => 'required|date_format:Y-m',
        ]);

        // 2. Parse the validated month and year
        $carbonDate = Carbon::createFromFormat('Y-m', $validated['periode']);
        $month = $carbonDate->month;
        $year = $carbonDate->year;

        // 3. Generate a dynamic filename
        $monthName = $carbonDate->locale('id')->format('F');
        $fileName = "laporan_belum_bayar_{$monthName}_{$year}.xlsx";

        // 4. Trigger the download, passing the year and month to the export class
        return Excel::download(new SiswaBelumBayarExport($year, $month), $fileName);
    }
}
