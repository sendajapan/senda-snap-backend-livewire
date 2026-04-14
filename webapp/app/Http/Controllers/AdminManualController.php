<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AdminManualController extends Controller
{
    public function index(): View
    {
        return view('admin-manual');
    }
}
