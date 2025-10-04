<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class BlogController extends Controller
{
    // LIST with search + filter
    public function index()
    {
        $q   = request('q');
        $cat = request('category_id');

        $blogs = Blog::query()
            ->when($q,   fn($x) => $x->where('title', 'like', "%{$q}%"))
            ->when($cat, fn($x) => $x->where('category_id', $cat))
            ->with(['category', 'operator'])
            ->latest()
            ->paginate(12);

        $categories = BlogCategory::active()->orderBy('name')->get();

        return view('admin.blogs.index', compact('blogs', 'categories', 'q', 'cat'));
    }

    // CREATE form
    public function create()
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    // STORE new blog
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:blog_categories,id'],
            'description' => ['required', 'string'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'      => ['required', 'in:0,1'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbs', 'public');
        }

        $data['operator_id'] = Auth::id();
        
        // generate unique slug for this title
        $data['slug'] = Str::slug($data['title']);
        $data['slug'] = Blog::where('slug', $data['slug'])->exists()
            ? $data['slug'].'-'.uniqid()
            : $data['slug'];

        Blog::create($data);


        return redirect()->route('admin.blogs.index')->with('ok', 'Blog created.');
    }

    // EDIT form
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    // UPDATE existing blog
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:blog_categories,id'],
            'description' => ['required', 'string'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'      => ['required', 'in:0,1'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbs', 'public');
        }

        if ($request->boolean('regenerate_slug')) {
            $slug = Str::slug($data['title']);
            $data['slug'] = Blog::where('id', '!=', $blog->id)
                                ->where('slug', $slug)
                                ->exists()
                ? $slug.'-'.uniqid()
                : $slug;
        }
        

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('ok', 'Blog updated.');
    }

    // DELETE blog
    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return back()->with('ok', 'Blog deleted.');
    }
}
