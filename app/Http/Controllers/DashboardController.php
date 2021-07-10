<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    function index()
    {
        $user = Auth::user()->username;
        return Inertia::render('Welcome',['usernames'=>$user]);
    }
}
