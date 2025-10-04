<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        $blogs = \App\Models\Blog::active()
            ->with(['category','operator'])
            ->latest()
            ->paginate(9);

        return view('front.home', compact('blogs'));
    }
}
