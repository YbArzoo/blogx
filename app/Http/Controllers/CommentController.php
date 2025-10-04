<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // POST /blog/{blog}/comment
    public function store(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        BlogComment::create([
            'blog_id' => $blog->id,
            'user_id' => Auth::id(),
            'body'    => $data['body'],
            // set to 1 if you don't want moderation; 0 if you want admin to approve
            'status'  => 1,
        ]);

        return back()->with('ok', 'Comment posted.');
    }

    // DELETE /comment/{comment}
    public function destroy(BlogComment $comment)
    {
        // Allow owner or admin
        if ($comment->user_id !== Auth::id() && !Auth::user()?->is_admin) {
            abort(403);
        }

        $comment->delete();

        return back()->with('ok', 'Comment deleted.');
    }
}
