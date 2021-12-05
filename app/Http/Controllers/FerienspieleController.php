<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FerienspieleController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('fsregister');
        }

        
    }
}
