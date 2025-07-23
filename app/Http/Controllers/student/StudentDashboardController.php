<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RoleMideware;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        return view('in.student.index'); // ✅ ensure this blade file exists
    }
}   
