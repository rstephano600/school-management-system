<?php

namespace App\Http\Controllers\ParentUser;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('in.parent.index'); // make sure this view file exists
    }
}
