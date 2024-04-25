<?php

namespace App\Http\Controllers;

use App\Helpers\Universe;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailTest extends Controller
{
    public function index()
    {
        $data = Universe::petugas()->nama_petugas;
        Mail::to('limnam87@gmail.com')->queue(new InvoiceMail($data));
        return back();
    }
}
