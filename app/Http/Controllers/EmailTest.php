<?php

namespace App\Http\Controllers;

use App\Helpers\Universe;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class EmailTest extends Controller
{
    public function index()
    {
        Mail::to('anamnafiul99@gmail.com')->send(new InvoiceMail());
    }
}
