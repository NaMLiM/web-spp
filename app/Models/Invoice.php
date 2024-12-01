<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable = ['invoice', 'siswa_id', 'jumlah_bayar', 'metode_pembayaran', 'nomer_pembayaran', 'bulan_bayar', 'tahun_baya', 'log', 'status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
