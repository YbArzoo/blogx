# BlogX

A Laravel + Tailwind blog app with an admin panel, categories, likes, favorites, comments, and a global dark/light mode toggle.



## Features

* Public blog with categories and post detail pages
* Auth via Laravel Breeze (login, register, profile, password update)
* Users can **like**, **favorite**, and **comment** on posts
* Admin panel for **Blogs**, **Categories**, **Users**, plus simple comment moderation
* Dark/Light mode toggle (persists in `localStorage`)
* Clean Tailwind UI (responsive)



## Requirements

* PHP 8.2+
* Composer
* Node.js 18+ and npm
* MySQL 8+ (or compatible)


## Getting Started (Local)

You will run **two terminals** at the same time: one for the PHP server, one for the Vite dev server.

### 1) Backend (Terminal A)

1. Clone the repository and enter the folder

   * `git clone https://github.com/YbArzoo/blogx.git`
   * `cd blogx`
2. Install PHP dependencies

   * `composer install`
3. Copy the environment file and generate the app key

   * `cp .env.example .env`
   * `php artisan key:generate`
4. Configure your database in `.env`

   * `DB_CONNECTION=mysql`
   * `DB_HOST=127.0.0.1`
   * `DB_PORT=3306`
   * `DB_DATABASE=blogx`
   * `DB_USERNAME=your_mysql_user`
   * `DB_PASSWORD=your_mysql_password`
5. Migrate and create the storage symlink

   * `php artisan migrate`
   * `php artisan storage:link`
6. Start the Laravel server (keep it running)

   * `php artisan serve` → open `http://127.0.0.1:8000`

### 2) Frontend (Terminal B)

1. Install Node dependencies

   * `npm install`
2. Start the Vite dev server (keep it running)

   * `npm run dev`
3. Use the app at `http://127.0.0.1:8000`

**Tip:** If you prefer one terminal, tools like Laravel Herd/Valet/Sail can run PHP automatically. The Vite dev server (`npm run dev`) still needs to run during development to rebuild CSS/JS.



## Demo Accounts

If your DB is empty, you can register from the UI. For review, use these:

### User

* Email: `user@gmail.com`
* Password: `user1234`

### Admin

* Email: `admin@admin.com`
* Password: `admin1234`

If the admin account isn’t marked as admin after registration, set it manually in your DB by updating the `users` table so that `is_admin = 1` and `status = 1` for the admin email.


## App Map

* **Home:** `/`
* **Post detail:** `/blog/{slug}`
* **Auth:** `/login`, `/register`
* **Profile:** `/profile` (edit info & password)
* **Favorites:** `/profile/favorites`

### Admin (requires `is_admin = 1` and `status = 1`)

* **Blogs:** `/admin/blogs`
* **Categories:** `/admin/categories`
* **Users:** `/admin/users`
* **Comment status:** POST `/admin/comments/{comment}/status`



## Dark / Light Mode

* Toggle button is in the navbar on all pages (guest and authenticated layouts).
* Preference is saved in `localStorage` as `theme = 'dark' | 'light'`.
* Tailwind uses `darkMode: 'class'` and applies the `dark` class before CSS paints to avoid flashes.



## File Storage

* Uploaded blog thumbnails are stored on the `public` disk under `storage/app/public/thumbs`.
* The public symlink is created via `php artisan storage:link`, so images are served from `/storage/...`.


## Production Build

* Build assets: `npm run build` (outputs to `public/build`)
* Point your web server (Nginx/Apache) to the project’s `public` directory.
* Ensure environment variables and file permissions for `storage` and `bootstrap/cache` are correct.


## Troubleshooting

* **No styles / blank UI** → Make sure `npm run dev` is running (Terminal B).
* **Admin returns 403** → Confirm your user has `is_admin = 1` and `status = 1`.
* **Images missing** → Run `php artisan storage:link`.
* **Vite port conflict** → Stop other dev servers or change the Vite port in `vite.config.js`.
* **Config cache weirdness** → Run `php artisan optimize:clear`.
* **Dark mode text unreadable in profile** → Ensure Tailwind classes include `dark:*` where needed (already patched).

