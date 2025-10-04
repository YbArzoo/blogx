<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function show(string $slug)
    {
        $blog = \App\Models\Blog::active()
            ->with(['category','operator'])
            ->where('slug', $slug)
            ->first();

        abort_if(!$blog, 404);

        $related = \App\Models\Blog::active()
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(4)
            ->get();

        return view('front.blog-show', compact('blog','related'));
    }
}
