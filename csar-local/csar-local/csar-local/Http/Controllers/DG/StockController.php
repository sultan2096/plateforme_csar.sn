<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        return view('dg.stocks.index');
    }
}
