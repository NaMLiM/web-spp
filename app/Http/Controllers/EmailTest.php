<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;

class EmailTest extends Controller
{
    public function index()
    {
        $invoice = Invoice::where('invoice', 'SPP1109281')->where('status', 'Belum Lunas')->first();
        Mail::to('anamnafiul99@gmail.com')->send(new InvoiceMail($invoice));
    }
}
