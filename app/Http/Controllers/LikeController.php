<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Blog $blog): RedirectResponse
    {
        $userId = Auth::id();
        abort_unless($userId, 403);

        $like = $blog->likes()->where('user_id', $userId)->first();
        $like ? $like->delete() : $blog->likes()->create(['user_id' => $userId]);

        return back()->with('ok', $like ? 'Unliked' : 'Liked');
    }
}
