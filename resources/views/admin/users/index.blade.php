<x-app-layout>
    <x-slot name="title">Users</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Search name or email"
                   class="w-64 rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900">
            <button class="rounded-lg bg-zinc-200 px-3 py-1.5 dark:bg-zinc-800">Search</button>
        </form>

        <!-- Create -->
        <details class="rounded-xl border p-3 dark:border-zinc-800">
            <summary class="cursor-pointer font-medium">Create User</summary>
            <form method="POST" action="{{ route('admin.users.store') }}" class="mt-3 grid grid-cols-2 gap-3">
                @csrf
                <input name="name" class="rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900" placeholder="Name" required>
                <input name="email" type="email" class="rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900" placeholder="Email" required>
                <input name="password" type="password" class="rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900" placeholder="Password" required>
                <select name="is_admin" class="rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900">
                    <option value="0">General</option>
                    <option value="1">Admin</option>
                </select>
                <select name="status" class="rounded-lg border px-3 py-1.5 dark:border-zinc-800 dark:bg-zinc-900">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <button class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white">Create</button>
            </form>
        </details>
    </div>

    <div class="overflow-x-auto rounded-xl border dark:border-zinc-800">
        <table class="w-full text-sm">
            <thead class="bg-zinc-100 dark:bg-zinc-900/40">
                <tr>
                    <th class="px-3 py-2 text-left">Name</th>
                    <th class="px-3 py-2 text-left">Email</th>
                    <th class="px-3 py-2">Role</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $u)
                <tr class="border-t dark:border-zinc-800">
                    <td class="px-3 py-2">{{ $u->name }}</td>
                    <td class="px-3 py-2">{{ $u->email }}</td>
                    <td class="px-3 py-2 text-center">{{ $u->is_admin ? 'Admin' : 'General' }}</td>
                    <td class="px-3 py-2 text-center">{{ $u->status ? 'Active' : 'Inactive' }}</td>
                    <td class="px-3 py-2 text-right">
                        <details class="inline-block">
                            <summary class="cursor-pointer rounded-lg bg-zinc-200 px-2 py-1 text-xs dark:bg-zinc-800">Edit</summary>
                            <form method="POST" action="{{ route('admin.users.update',$u) }}" class="mt-2 grid grid-cols-2 gap-2">
                                @csrf @method('PUT')
                                <input name="name" value="{{ $u->name }}" class="rounded-lg border px-2 py-1 dark:border-zinc-800 dark:bg-zinc-900">
                                <input name="email" value="{{ $u->email }}" class="rounded-lg border px-2 py-1 dark:border-zinc-800 dark:bg-zinc-900">
                                <input name="password" placeholder="(leave empty to keep)" class="rounded-lg border px-2 py-1 dark:border-zinc-800 dark:bg-zinc-900">
                                <select name="is_admin" class="rounded-lg border px-2 py-1 dark:border-zinc-800 dark:bg-zinc-900">
                                    <option value="0" @selected(!$u->is_admin)>General</option>
                                    <option value="1" @selected($u->is_admin)>Admin</option>
                                </select>
                                <select name="status" class="rounded-lg border px-2 py-1 dark:border-zinc-800 dark:bg-zinc-900">
                                    <option value="1" @selected($u->status==1)>Active</option>
                                    <option value="0" @selected($u->status==0)>Inactive</option>
                                </select>
                                <button class="col-span-2 rounded-lg bg-indigo-600 px-2 py-1 text-white">Save</button>
                            </form>
                        </details>

                        @if(auth()->id() !== $u->id)
                        <form method="POST" action="{{ route('admin.users.destroy',$u) }}" class="inline-block"
                              onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button class="rounded-lg bg-rose-600 px-2 py-1 text-xs text-white">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->withQueryString()->links() }}</div>
</x-app-layout>
