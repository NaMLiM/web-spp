<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function getTransactionsPerMonth()
    {
        $transactionsPerMonth = Pembayaran::last12Months()->get();
        return response()->json($transactionsPerMonth);
    }
}
