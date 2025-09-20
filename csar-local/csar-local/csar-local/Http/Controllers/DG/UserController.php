<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('dg.users.index');
    }
}
