<x-guest-layout>
    <article class="mx-auto max-w-3xl">
        @php
            $thumb  = $blog->thumbnail;
            $exists = $thumb && \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb);
            $imgUrl = $exists ? asset('storage/'.$thumb) : asset('images/placeholder.webp'); // or .jpg if that's what you saved
        @endphp

        <img src="{{ $imgUrl }}" alt="" class="mb-6 w-full rounded-2xl object-cover">


        

        <div class="mb-3 flex flex-wrap items-center gap-2 text-sm text-zinc-500">
            <span class="rounded-full bg-indigo-600/10 px-2 py-0.5 font-medium text-indigo-700 dark:text-indigo-300">
                {{ $blog->category?->name ?? 'Uncategorized' }}
            </span>
            <span>•</span>
            <span>{{ $blog->operator?->name ?? 'Unknown' }}</span>
            <span>•</span>
            <time datetime="{{ $blog->created_at->toDateString() }}">{{ $blog->created_at->format('d M Y') }}</time>
        </div>

        @auth
            @php
                $liked = $blog->likedBy(auth()->id());
                $saved = $blog->favoritedBy(auth()->id());
            @endphp
            <div class="mt-3 mb-1 flex gap-3">
                <form method="POST" action="{{ route('blog.like',$blog) }}">
                    @csrf
                    <button class="rounded-lg px-3 py-1.5 text-sm {{ $liked ? 'bg-pink-600 text-white' : 'bg-zinc-200 dark:bg-zinc-800' }}">
                        {{ $liked ? '♥ Liked' : '♡ Like' }} ({{ $blog->likes()->count() }})
                    </button>
                </form>

                <form method="POST" action="{{ route('blog.favorite',$blog) }}">
                    @csrf
                    <button class="rounded-lg px-3 py-1.5 text-sm {{ $saved ? 'bg-amber-500 text-white' : 'bg-zinc-200 dark:bg-zinc-800' }}">
                        {{ $saved ? 'Saved' : 'Save' }}
                    </button>
                </form>
            </div>
        @endauth

        <h1 class="mb-4 text-3xl font-extrabold tracking-tight">{{ $blog->title }}</h1>

        <div class="prose prose-zinc max-w-none dark:prose-invert">
            {!! nl2br(e($blog->description)) !!}
        </div>
    </article>


    <div class="mx-auto mt-10 max-w-3xl">
        <h3 class="mb-4 text-lg font-semibold">Comments</h3>

        @php
            $comments = $blog->approvedComments()->with('user')->latest()->get();
        @endphp

        @if($comments->count())
            <ul class="space-y-4">
                @foreach($comments as $c)
                    <li class="rounded-xl border bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="mb-2 text-sm text-zinc-500">
                            <span class="font-medium text-zinc-700 dark:text-zinc-200">{{ $c->user?->name ?? 'User' }}</span>
                            <span class="mx-2">•</span>
                            <time datetime="{{ $c->created_at->toDateTimeString() }}">{{ $c->created_at->diffForHumans() }}</time>
                        </div>
                        <div class="whitespace-pre-line text-sm">{{ $c->body }}</div>

                        @auth
                            @if(auth()->id() === $c->user_id || auth()->user()->can('admin'))
                                <form method="POST" action="{{ route('comment.destroy',$c) }}" class="mt-3">
                                    @csrf @method('DELETE')
                                    <button class="rounded-lg bg-rose-600 px-2 py-1 text-xs text-white">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-zinc-500">No comments yet. Be the first to comment!</p>
        @endif

        <div class="mt-6 rounded-xl border bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            @auth
                <form method="POST" action="{{ route('blog.comment.store',$blog) }}" class="space-y-3">
                    @csrf
                    <textarea name="body" rows="4" placeholder="Write a comment…"
                            class="w-full rounded-lg border px-3 py-2 dark:border-zinc-800 dark:bg-zinc-900">{{ old('body') }}</textarea>
                    @error('body') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror

                    <button class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white">Post comment</button>
                </form>
            @else
                <div class="text-sm">
                    <a class="text-indigo-600 hover:underline dark:text-indigo-400" href="{{ route('login') }}">Log in</a>
                    to leave a comment.
                </div>
            @endauth
        </div>
    </div>



    @if($related->count())
        <div class="mx-auto mt-10 max-w-3xl">
            <h3 class="mb-3 text-lg font-semibold">Related</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach($related as $r)
                    <a href="{{ route('blog.show',$r->slug) }}"
                       class="rounded-xl border bg-white p-4 shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="mb-1 text-xs text-zinc-500">{{ $r->category?->name }}</div>
                        <div class="line-clamp-2 font-medium">{{ $r->title }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-guest-layout>
