<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class LandingPageController extends Controller
{
    public function design1(): View
    {
        return view('welcome');
    }

    public function design2(): View
    {
        return view('landing.design2');
    }

    public function design3(): View
    {
        return view('landing.design3');
    }

    public function design4(): View
    {
        return view('landing.design4');
    }
}
