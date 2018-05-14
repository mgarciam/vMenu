<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show() {
       if (Auth::Check()) {
        if (Auth::user()->isAdmin) {
            return view('dashboard.dashboard');
        } else if (Auth::user()->isCook) {
            return redirect('/orders');
        } else if (Auth::user()->isFront) {
            return redirect('/guests');
        }
       } else {
        return redirect('/');
       }
    }
}
