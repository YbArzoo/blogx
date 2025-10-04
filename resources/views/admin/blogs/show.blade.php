<h3 class="mt-8 mb-2 text-lg font-semibold">Comments</h3>

@if($blog->comments()->count())
    <div class="space-y-3">
        @foreach($blog->comments()->latest()->get() as $c)
            <div class="rounded-lg border p-3 text-sm dark:border-zinc-800">
                <div class="mb-1 text-zinc-500">
                    {{ $c->user?->name ?? 'User #'.$c->user_id }} • {{ $c->created_at->diffForHumans() }}
                    <span class="ml-2 inline rounded bg-zinc-200 px-2 py-0.5 text-xs dark:bg-zinc-800">
                        {{ $c->status ? 'Approved' : 'Hidden' }}
                    </span>
                </div>
                <div class="mb-2">{{ $c->body }}</div>
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('admin.comments.status',$c) }}">
                        @csrf
                        <input type="hidden" name="status" value="{{ $c->status ? 0 : 1 }}">
                        <button class="rounded-lg bg-amber-500 px-2 py-1 text-xs text-white">
                            {{ $c->status ? 'Hide' : 'Approve' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.comments.destroy',$c) }}"
                          onsubmit="return confirm('Delete this comment?')">
                        @csrf @method('DELETE')
                        <button class="rounded-lg bg-rose-600 px-2 py-1 text-xs text-white">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="rounded-lg border p-4 text-sm text-zinc-500 dark:border-zinc-800">
        No comments yet.
    </div>
@endif
