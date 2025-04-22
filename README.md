# Laravel JobBoard

A full-stack job posting platform built with Laravel 12, Breeze, and MySQL.

### 🚀 Live Demo

🔗 **[JobBoard Live Site](https://laravel-jobboard-production.up.railway.app/job-posts)**  

---

## 🚀 Features

- User roles: **poster** and **viewer**
- Posters can create, edit, delete job posts
- Viewers can mark themselves as "interested"
- Each job shows interested users (for posters)
- Clean UI using **Laravel Breeze** + **Tailwind CSS**
- Adminer and MySQL included via Docker for database access
- Basic access control using Laravel Policy

---

## 🧰 Tech Stack

- PHP 8.2+, Laravel 12+
- MySQL (via Docker)
- Tailwind CSS (via Vite)
- Laravel Breeze (for auth scaffolding)
- Blade templates
- Adminer (for DB browsing)

---

## ⚙️ Setup Instructions

### 1. Clone and Install Dependencies

```bash
git clone https://github.com/LAMSTREAM/Laravel-JobBoard.git
cd Laravel-JobBoard
composer install
npm install
```

### 2. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` to configure your DB:  
(Make sure the fields correspond to each other)
```
DB_CONNECTION=mysql
DB_HOST=mysql       # If using Docker
DB_PORT=3306
DB_DATABASE=jobboard
DB_USERNAME=laravel
DB_PASSWORD=laravelpassword

# MySQL Environment Variables for Docker Compose
MYSQL_PORT=3306
MYSQL_DATABASE=jobboard
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_USER=laravel
MYSQL_PASSWORD=laravelpassword
```

---

### 3. Run Database in Docker

```bash
docker-compose up -d
```

Includes MySQL + Adminer (http://localhost:8080)

---

### 4. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

Seeder includes:
- Posters & Viewers
- JobPosts
- Interested user pivot table data

---

### 5. Run the Frontend Dev Server

```bash
npm run dev
```

> For production: `npm run build`

---

### 6. Launch the App

```bash
php artisan serve
```
Visit: http://127.0.0.1:8000

---

## 🧪 Development Tips

- Toggle interest via AJAX (no page reload)
- Sorting supported by query param: `?sort=asc|desc`
- Layout: fully responsive using Tailwind

---

## 📁 Directory Structure (Core Parts)

- `app/Models/JobPost.php` - Job post logic
- `app/Http/Controllers/JobPostController.php` - core logic
- `resources/views/job_posts/` - all Blade views
- `database/seeders/` - data seeding
- `routes/web.php` - route definitions

---

## 🔐 Roles & Access

- **Authenticated users only** can access job posts
- **Posters** can manage their own job posts
- **Viewers** can mark interest

---

## 🎨 Customization

- Replace favicon in `public/favicon.ico`
- Update site name via `.env > APP_NAME`
- Modify layout in `resources/views/layouts/app.blade.php`
