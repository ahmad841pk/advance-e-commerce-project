<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function hindi()
    {
        session()->get('language');
        session()->forget('language');
        session()->put('language','hindi');
        return redirect()->back();

    }// End method

    public function english()
    {
        session()->get('language');
        session()->forget('language');
        session()->put('language','english');
        return redirect()->back();

    }// End method
}
