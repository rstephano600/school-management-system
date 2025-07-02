<?php


namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('in.teacher.index'); // or any blade view you created
    }
}
