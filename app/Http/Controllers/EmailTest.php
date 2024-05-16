<?php

namespace App\Http\Controllers;

use App\Helpers\Universe;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class EmailTest extends Controller
{
    public function index()
    {
        $data = Universe::petugas()->nama_petugas;
        Mail::to('limnam87@gmail.com')->send(new InvoiceMail($data));
        return back();
    }
}
