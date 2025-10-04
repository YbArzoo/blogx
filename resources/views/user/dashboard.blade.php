<x-app-layout>
    <x-slot name="title">Your Dashboard</x-slot>

    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }} 👋</h1>
            <p class="text-sm text-zinc-500">Here’s a quick overview.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('home') }}" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500">Browse blogs</a>
            <a href="{{ route('profile.favorites') }}" class="rounded-lg bg-amber-500 px-3 py-2 text-sm font-medium text-white hover:bg-amber-400">★ Favorites</a>
            <a href="{{ route('profile.edit') }}" class="rounded-lg bg-zinc-200 px-3 py-2 text-sm font-medium hover:bg-zinc-300 dark:bg-zinc-800 dark:hover:bg-zinc-700">Edit profile</a>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="text-sm text-zinc-500">Favorites</div>
            <div class="mt-1 text-2xl font-semibold">{{ $stats['favorites'] ?? 0 }}</div>
        </div>
        <div class="rounded-xl border bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="text-sm text-zinc-500">Likes</div>
            <div class="mt-1 text-2xl font-semibold">{{ $stats['likes'] ?? 0 }}</div>
        </div>
        <div class="rounded-xl border bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="text-sm text-zinc-500">Comments</div>
            <div class="mt-1 text-2xl font-semibold">{{ $stats['comments'] ?? 0 }}</div>
        </div>
    </div>

    <div class="rounded-2xl border bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Recently saved</h2>
            <a class="text-sm text-indigo-600 hover:underline dark:text-indigo-400" href="{{ route('profile.favorites') }}">View all</a>
        </div>

        @if(($recent ?? collect())->isEmpty())
            <div class="rounded-lg border border-dashed p-6 text-center text-sm text-zinc-500 dark:border-zinc-800">
                You haven’t saved any posts yet.
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($recent as $b)
                    <a href="{{ route('blog.show', $b->slug) }}" class="rounded-xl border p-4 transition hover:shadow-sm dark:border-zinc-800">
                        <div class="mb-1 text-xs text-zinc-500">{{ $b->category?->name ?? 'Uncategorized' }}</div>
                        <div class="line-clamp-2 font-medium">{{ $b->title }}</div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
