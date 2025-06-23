<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RoleMideware;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{

public function index()
{
    return view('in.superadmin.dashboard');
}

public function listUser()
{
    return view('in.superadmin.list-users');
}

public function editUser()
{
    return view('in.superadmin.edit-users');
}

}
