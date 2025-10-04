<x-app-layout>
    <x-slot name="title">My Favorites</x-slot>

    <h1 class="mb-4 text-2xl font-bold">Saved articles</h1>

    @if($blogs->count())
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($blogs as $b)
                <a href="{{ route('blog.show', $b->slug) }}"
                   class="rounded-xl border p-4 hover:shadow dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="text-xs text-zinc-500">{{ $b->category?->name }}</div>
                    <div class="mt-1 font-medium">{{ $b->title }}</div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">{{ $blogs->links() }}</div>
    @else
        <p class="text-zinc-500">No favorites yet.</p>
    @endif
</x-app-layout>
