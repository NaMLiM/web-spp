<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;

class EmailTest extends Controller
{
    public function index()
    {
        $invoice = Invoice::findOrFail(89);
        Mail::to('anamnafiul99@gmail.com')->send(new InvoiceMail($invoice));
    }
}
