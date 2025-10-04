<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogFavorite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // GET /profile/favorites
    public function index()
    {
        $ids = BlogFavorite::where('user_id', Auth::id())->pluck('blog_id');

        $blogs = Blog::whereIn('id', $ids)
            ->with(['category','operator'])
            ->latest()
            ->paginate(12);

        return view('user.favorites', compact('blogs'));
    }

    // POST /blog/{blog}/favorite
    public function toggle(Blog $blog): RedirectResponse
    {
        $fav = BlogFavorite::where('user_id', Auth::id())
            ->where('blog_id', $blog->id)
            ->first();

        if ($fav) {
            $fav->delete();
            $msg = 'Removed from favorites.';
        } else {
            BlogFavorite::create([
                'user_id' => Auth::id(),
                'blog_id' => $blog->id,
            ]);
            $msg = 'Saved to favorites.';
        }

        return back()->with('ok', $msg);
    }
}
