<?php

namespace App\Http\Controllers\Academicmaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('in.academicmaster.index'); // make sure this view file exists
    }
}
