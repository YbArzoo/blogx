<x-guest-layout>
    <div class="mx-auto max-w-3xl text-center">
    <img
        src="{{ asset('images/logo.webp') }}"
        alt="BlogX"
        class="mx-auto mb-4 h-10 w-10 rounded-md ring-1 ring-indigo-600/20"
    />

        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Latest Blogs</h1>
        <p class="mt-2 text-zinc-600 dark:text-zinc-400">Fresh posts from our authors. Browse by category and discover more.</p>
    </div>

    @if($blogs->count())
        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($blogs as $b)
                <a href="{{ route('blog.show',$b->slug) }}"
                   class="group rounded-2xl border bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                    @if($b->thumbnail)
                        <img src="{{ $b->thumbnail ? asset('storage/'.$b->thumbnail) : asset('images/placeholder.jpg') }}"alt=""
                            class="mb-3 aspect-[16/9] w-full rounded-xl object-cover">
                    @endif
                    <div class="mb-2 flex items-center gap-2 text-xs text-zinc-500">
                        <span class="rounded-full bg-indigo-600/10 px-2 py-0.5 font-medium text-indigo-700 dark:text-indigo-300">
                            {{ $b->category?->name ?? 'Uncategorized' }}
                        </span>
                        <span>•</span>
                        <span>{{ $b->operator?->name ?? 'Unknown' }}</span>
                    </div>
                    <h3 class="line-clamp-2 text-lg font-semibold leading-snug transition group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                        {{ $b->title }}
                    </h3>
                    <p class="mt-2 line-clamp-2 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ \Illuminate\Support\Str::limit(strip_tags($b->description), 120) }}
                    </p>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $blogs->onEachSide(1)->links() }}
        </div>
    @else
        <div class="mt-10 text-center text-zinc-600 dark:text-zinc-400">No blogs yet.</div>
    @endif
</x-guest-layout>
