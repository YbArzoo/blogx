<x-app-layout>
    <x-slot name="title">Manage Blogs</x-slot>

    {{-- Top toolbar: title + quick link to create --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Blogs</h1>
            <p class="text-sm text-zinc-500">Create, publish, and manage blog posts.</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}"
           class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500">
            + New Blog
        </a>
    </div>

    {{-- Filter row (ONE copy only) --}}
    <div class="mb-4">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Search title…"
                   class="w-64 rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900">
            <select name="category_id"
                    class="rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900">
                <option value="">All categories</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected((string)$cat === (string)$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="rounded-lg bg-zinc-200 px-3 py-1.5 dark:bg-zinc-800">Filter</button>
            @if($q || $cat)
                <a href="{{ route('admin.blogs.index') }}"
                   class="rounded-lg px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-xl border bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50/60 dark:bg-zinc-800/50">
                <tr class="text-left">
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Author</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $b)
                    <tr class="border-t dark:border-zinc-800">
                        <td class="px-4 py-3">{{ $b->title }}</td>
                        <td class="px-4 py-3">{{ $b->category?->name }}</td>
                        <td class="px-4 py-3">{{ $b->operator?->name }}</td>
                        <td class="px-4 py-3">{{ $b->status ? 'Published' : 'Draft' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.blogs.edit',$b) }}"
                               class="rounded-lg bg-zinc-200 px-2 py-1 text-xs dark:bg-zinc-800">Edit</a>
                            <form method="POST" action="{{ route('admin.blogs.destroy',$b) }}"
                                  class="inline-block" onsubmit="return confirm('Delete this blog?')">
                                @csrf @method('DELETE')
                                <button class="rounded-lg bg-rose-600 px-2 py-1 text-xs text-white">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination (keep query string for filters) --}}
    <div class="mt-4">{{ $blogs->withQueryString()->links() }}</div>
</x-app-layout>
