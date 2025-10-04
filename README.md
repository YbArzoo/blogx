# BlogX

A Laravel + Tailwind blog app with an admin panel, categories, likes, favorites, comments, and a global dark/light mode toggle.

---

## Features

- Public blog with categories and post detail pages  
- Auth via Laravel Breeze (login, register, profile, password update)  
- Users can **like**, **favorite**, and **comment** on posts  
- Admin panel for **Blogs**, **Categories**, **Users** + simple comment moderation  
- Dark/Light mode toggle (persists in `localStorage`)  
- Clean Tailwind UI (responsive)

---

## Quick Start (Local)

> **You need two terminals** running at the same time (one for PHP/Laravel, one for Vite).

### 1) Backend (Terminal A)

```bash
# clone
git clone https://github.com/<your-username>/blogx.git
cd blogx

# install dependencies
composer install

# env & app key
cp .env.example .env
php artisan key:generate

# set database in .env (edit these as needed)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=blogx
# DB_USERNAME=root
# DB_PASSWORD=your_password

# migrate & storage symlink
php artisan migrate
php artisan storage:link

# run the app
php artisan serve   # http://127.0.0.1:8000
