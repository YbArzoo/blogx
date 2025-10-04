<x-app-layout>
    <x-slot name="title">New Blog</x-slot>

    <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data"
          class="mx-auto max-w-2xl space-y-4">
        @csrf

        <input name="title" value="{{ old('title') }}" placeholder="Title"
               class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">
        @error('title') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror

        <select name="category_id" class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror

        <textarea name="description" rows="8" placeholder="Description"
                  class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">{{ old('description') }}</textarea>
        @error('description') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror

        <input type="file" name="thumbnail"
               class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">
        @error('thumbnail') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror

        <select name="status" class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">
            <option value="1" @selected(old('status',1)==1)>Published</option>
            <option value="0" @selected(old('status',1)==0)>Draft</option>
        </select>
        @error('status') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror

        <div class="flex gap-2">
            <a href="{{ route('admin.blogs.index') }}" class="rounded-lg px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800">Cancel</a>
            <button class="rounded-lg bg-indigo-600 px-3 py-2 text-white">Create</button>
        </div>
    </form>
</x-app-layout>
