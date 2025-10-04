<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Categories</h1>
            <p class="text-sm text-zinc-500">Create and manage blog categories.</p>
        </div>
        <a href="{{ url('/dashboard') }}" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500">
            Dashboard
        </a>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="mb-6 flex flex-wrap gap-3">
        @csrf
        <input name="name" placeholder="Name" class="rounded border px-3 py-2" required>
        <select name="status" class="rounded border px-3 py-2">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <button class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-500">Create</button>
    </form>

    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50/60 dark:bg-zinc-800/50">
                <tr class="text-left">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($categories as $c)
                <tr class="border-t dark:border-zinc-800">
                    <td class="px-4 py-3">{{ $c->name }}</td>
                    <td class="px-4 py-3">{{ $c->status ? 'Active' : 'Inactive' }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <form method="POST" action="{{ route('admin.categories.update',$c) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="name" value="{{ $c->name }}">
                            <input type="hidden" name="status" value="{{ $c->status ? 0 : 1 }}">
                            <button class="rounded bg-zinc-200 px-3 py-1.5 hover:bg-zinc-300 dark:bg-zinc-800 dark:hover:bg-zinc-700">
                                Toggle
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.categories.destroy',$c) }}">
                            @csrf @method('DELETE')
                            <button class="rounded bg-red-600 px-3 py-1.5 text-white hover:bg-red-500">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
</x-app-layout>
