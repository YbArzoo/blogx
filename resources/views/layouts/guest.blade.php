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
    <!-- Header -->
    <header class="border-b border-zinc-200/60 bg-white/50 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/50">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.webp') }}" alt="BlogX" class="h-6 w-6">
                <span class="font-semibold tracking-tight">BlogX</span>
            </a>

            <nav class="flex items-center gap-3">
                {{-- Theme toggle (component) --}}
                <x-theme-toggle />

                {{-- Auth actions --}}
                <a href="{{ route('login') }}" class="rounded-lg px-3 py-1.5 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-sm text-white hover:bg-indigo-500">
                        Register
                    </a>
                @endif
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-10">
        {{ $slot }}
    </main>

    <footer class="border-t py-10">
        <div class="mx-auto max-w-6xl px-4 text-sm text-zinc-500">
            <div class="flex items-center justify-between">
                <p>© {{ date('Y') }} BlogX. All rights reserved.</p>
                <p class="opacity-80">Built with Laravel & Tailwind</p>
            </div>
        </div>
    </footer>
</body>
</html>
