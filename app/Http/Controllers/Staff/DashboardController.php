<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('in.staff.index'); // ✅ create this blade view
    }
}
