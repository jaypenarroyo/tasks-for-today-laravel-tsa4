<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Public static About page identifying the developer.
     */
    public function about(): View
    {
        return view('about');
    }
}
