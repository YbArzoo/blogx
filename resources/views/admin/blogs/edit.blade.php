<x-app-layout>
    <x-slot name="title">Edit Blog</x-slot>

    <form method="POST" action="{{ route('admin.blogs.update',$blog) }}" enctype="multipart/form-data"
          class="mx-auto max-w-2xl space-y-4">
        @csrf @method('PUT')

        <input name="title" value="{{ old('title',$blog->title) }}" class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">

        <select name="category_id" class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">
            @foreach($category as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>

            @endforeach
        </select>

        <textarea name="description" rows="8"
                  class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">{{ old('description',$blog->description) }}</textarea>

        @php
            $thumb  = $blog->thumbnail;
            $exists = $thumb && \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb);
            $imgUrl = $exists ? asset('storage/'.$thumb) : asset('images/placeholder.webp');
        @endphp

        <div>
            <div class="mb-2 text-sm text-zinc-500">Current thumbnail</div>
            <img src="{{ $imgUrl }}" class="mb-2 h-32 w-full rounded-lg object-cover" alt="">
            <input type="file" name="thumbnail" class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">
        </div>

        <select name="status" class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">
            <option value="1" @selected(old('status',$blog->status)==1)>Published</option>
            <option value="0" @selected(old('status',$blog->status)==0)>Draft</option>
        </select>

        <div class="flex gap-2">
            <a href="{{ route('admin.blogs.index') }}" class="rounded-lg px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800">Back</a>
            <button class="rounded-lg bg-indigo-600 px-3 py-2 text-white">Save</button>
        </div>
    </form>
</x-app-layout>
