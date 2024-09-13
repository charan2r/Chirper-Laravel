<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(): Factory|View
    {
        return view(view: 'admin.dashboard');
    }
}
