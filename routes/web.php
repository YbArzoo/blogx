<?php

use Illuminate\Support\Facades\Route;

// Front controllers
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\BlogController as FrontBlogController;

// Auth / profile / interactions
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Blog;
use App\Models\BlogFavorite;
use App\Models\BlogLike;
use App\Models\BlogComment;




// Admin controllers
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
     FRONT
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');                 // __invoke()
Route::get('/blog/{slug}', [FrontBlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
| Admins are redirected to the admin blogs list.
*/
Route::get('/dashboard', function () {
    // Admins still go straight to the admin panel
    if (Auth::check() && Auth::user()->is_admin && (int) Auth::user()->status === 1) {
        return redirect()->route('admin.blogs.index');
    }

    $user = Auth::user();

    $stats = [
        'favorites' => BlogFavorite::where('user_id', $user->id)->count(),
        'likes'     => BlogLike::where('user_id', $user->id)->count(),
        'comments'  => BlogComment::where('user_id', $user->id)->count(),
    ];

    // Up to 5 most recent saved blogs (with category)
    $recent = Blog::whereIn(
        'id',
        BlogFavorite::where('user_id', $user->id)
            ->latest('id')
            ->limit(5)
            ->pluck('blog_id')
    )->with('category')->get();

    return view('user.dashboard', compact('user', 'stats', 'recent'));
})->middleware(['auth', 'verified'])->name('dashboard');



/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // interactions
    Route::post('/blog/{blog}/like',     [LikeController::class,     'toggle'])->name('blog.like');
    Route::post('/blog/{blog}/favorite', [FavoriteController::class, 'toggle'])->name('blog.favorite');
    Route::post('/blog/{blog}/comment',  [CommentController::class,  'store'])->name('blog.comment.store');
    Route::delete('/comment/{comment}',  [CommentController::class,  'destroy'])->name('comment.destroy');

    // favorites page
    Route::get('/profile/favorites', [FavoriteController::class, 'index'])->name('profile.favorites');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('blogs',       AdminBlogController::class);
    Route::resource('categories',  AdminCategoryController::class);
    Route::resource('users',       AdminUserController::class)->only(['index','store','update','destroy']);

    // comment moderation (simple)
    Route::post('comments/{comment}/status', function (\App\Models\BlogComment $comment) {
        $comment->update(['status' => request('status') ? 1 : 0]);
        return back()->with('ok','Comment status updated.');
    })->name('comments.status');

    Route::delete('comments/{comment}', function (\App\Models\BlogComment $comment) {
        $comment->delete();
        return back()->with('ok','Comment deleted.');
    })->name('comments.destroy');
});

require __DIR__.'/auth.php';
