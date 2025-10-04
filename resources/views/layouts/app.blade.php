<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name','BlogX') }}</title>

    <!-- Set theme before CSS paints (no flash) -->
    <script>
    (function () {
        const saved = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const dark = saved ? saved === 'dark' : prefersDark;
        document.documentElement.classList.toggle('dark', dark);
    })();
    </script>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-full bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-900 dark:text-zinc-50">
    <header class="sticky top-0 z-40 border-b bg-white/80 backdrop-blur dark:bg-zinc-900/80">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.webp') }}" alt="BlogX" class="h-6 w-6">
                <span class="font-semibold tracking-tight">BlogX</span>
            </a>

            <!-- Right side -->
            <div class="flex items-center gap-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Home</a>

                @can('admin')
                    <a href="{{ route('admin.blogs.index') }}" class="rounded-lg px-3 py-1.5 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">Manage Blogs</a>
                    <a href="{{ route('admin.categories.index') }}" class="rounded-lg px-3 py-1.5 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">Categories</a>
                    <a href="{{ route('admin.users.index') }}" class="rounded-lg px-3 py-1.5 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">Users</a>
                @endcan

                {{-- Theme toggle --}}
                <x-theme-toggle />

                @auth
                    <!-- Profile dropdown -->
                    <div x-data="{ open:false }" class="relative">
                        <button
                            @click="open = !open"
                            @keydown.escape.window="open = false"
                            @click.outside="open = false"
                            class="flex items-center gap-2 rounded-lg px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-600 text-xs font-bold text-white">
                                {{ strtoupper(auth()->user()->name[0] ?? 'U') }}
                            </span>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-transition.origin.top.right
                            class="absolute right-0 mt-2 w-44 rounded-lg border bg-white p-1 shadow-lg dark:border-zinc-800 dark:bg-zinc-900"
                            style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block rounded px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800">Profile</a>
                            @cannot('admin')
                                <a href="{{ route('profile.favorites') }}" class="block rounded px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800">Favorites</a>
                            @endcannot
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="block w-full rounded px-3 py-2 text-left hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white hover:bg-indigo-500">Register</a>
                    @endif
                @endguest
            </div>
        </nav>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-10">
        {{ $slot }}
    </main>
</body>
</html>
