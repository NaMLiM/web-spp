<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;

class EmailTest extends Controller
{
    public function index()
    {
        $invoice = Invoice::where('invoice', 'SPP2004950')->where('status', 'Belum Lunas')->first();
        dd($invoice->siswa->user->email);
        Mail::to('limnam0512@gmail.com')->send(new InvoiceMail($invoice));
    }
}
