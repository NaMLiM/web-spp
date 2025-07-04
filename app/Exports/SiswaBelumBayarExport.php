<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaBelumBayarExport implements FromCollection, WithHeadings, WithMapping
{

    protected $month;
    protected int $year;

    public function __construct(int $year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Siswa::with(['user', 'kelas'])
            ->whereDoesntHave('pembayaran', function ($query) {
                $query->where('bulan_bayar', $this->month)
                    ->where('tahun_bayar', $this->year);
            })->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // These are the column headers for your Excel file
        return [
            'Nama Siswa',
            'Kelas',
            'Email',
            'No. Telepon',
        ];
    }

    /**
     * @var Siswa $siswa
     * @return array
     */
    public function map($siswa): array
    {
        // This maps the data to the columns in the order of the headings
        return [
            $siswa->nama_siswa,
            $siswa->kelas->nama_kelas ?? 'N/A', // Safely access class name
            $siswa->user->email ?? 'N/A',      // Safely access user email
            $siswa->no_telepon,
        ];
    }
}
