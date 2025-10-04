<!-- resources/views/components/theme-toggle.blade.php -->
<div x-data="{ dark: document.documentElement.classList.contains('dark') }"
     x-init="
       // stay in sync if another tab changes it
       window.addEventListener('storage', (e) => {
         if (e.key === 'theme') {
           const on = e.newValue === 'dark';
           dark = on;
           document.documentElement.classList.toggle('dark', on);
         }
       });
     ">
  <button
    @click="
      dark = !dark;
      document.documentElement.classList.toggle('dark', dark);
      localStorage.setItem('theme', dark ? 'dark' : 'light');
    "
    class="rounded-lg p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800"
    aria-label="Toggle theme">
    <!-- Sun -->
    <svg x-show="!dark" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 15a5 5 0 100-10 5 5 0 000 10zm0 3a1 1 0 011 1v0a1 1 0 11-2 0v0a1 1 0 011-1zm0-17a1 1 0 011-1v0a1 1 0 110 2v0a1 1 0 01-1-1zM3.22 4.64a1 1 0 011.42-1.42l.01.01a1 1 0 11-1.43 1.41zm12.14 12.14a1 1 0 001.42-1.42l-.01-.01a1 1 0 10-1.41 1.43zM3 10a1 1 0 011-1H4a1 1 0 110 2h0a1 1 0 01-1-1zm12 0a1 1 0 011-1h0a1 1 0 110 2h0a1 1 0 01-1-1zM4.64 16.78a1 1 0 001.42 0l.01-.01a1 1 0 10-1.43-1.41l0 .01a1 1 0 000 1.41zm10.72-12.14a1 1 0 001.42-1.42l-.01-.01a1 1 0 10-1.41 1.43z"/>
    </svg>
    <!-- Moon -->
    <svg x-show="dark" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
      <path d="M17.293 13.293A8 8 0 016.707 2.707 8 8 0 1017.293 13.293z"/>
    </svg>
  </button>
</div>
