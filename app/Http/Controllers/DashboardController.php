<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): RedirectResponse|View
    {
        if (Gate::allows('admin')) {
            return redirect()->route('admin.blogs.index');
        }

        return view('dashboard');
    }
}
