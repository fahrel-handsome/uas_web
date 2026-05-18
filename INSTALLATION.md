# 📋 Panduan Instalasi CerdasFin

## 🖥️ Persyaratan Sistem

Sebelum memulai instalasi, pastikan Anda memiliki:

- **PHP 8.2 atau lebih tinggi**
  - Check: `php --version`
  
- **Composer** (PHP Package Manager)
  - Download: https://getcomposer.org
  - Check: `composer --version`
  
- **Node.js & NPM** (untuk asset building)
  - Download: https://nodejs.org
  - Check: `node --version` dan `npm --version`
  
- **Database** (MySQL 5.7+ atau SQLite)
  - MySQL: https://www.mysql.com
  - Atau gunakan SQLite (built-in)
  
- **Git** (optional, untuk version control)

---

## ⚡ Quick Start (Recommended untuk Windows)

Jika Anda menggunakan Windows, cukup jalankan double-click file:

```
setup.bat
```

Script ini akan otomatis melakukan semua langkah instalasi.

---

## 🔧 Manual Installation Steps

Jika Quick Start tidak berhasil atau Anda menggunakan Linux/Mac, ikuti langkah berikut:

### 1. **Extract dan Navigate ke Folder Project**

```bash
cd uas_web
```

### 2. **Install PHP Dependencies**

```bash
composer install
```

Ini akan mengunduh semua dependency Laravel yang diperlukan.

### 3. **Setup Environment File**

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

#### **Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cerdasfin
DB_USERNAME=root
DB_PASSWORD=
```

#### **Untuk SQLite (lebih mudah untuk development):**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/full/path/to/database.sqlite
```

### 4. **Generate Application Key**

```bash
php artisan key:generate
```

Ini akan membuat encryption key di file `.env`.

### 5. **Create Database**

**Jika menggunakan MySQL:**
```sql
CREATE DATABASE cerdasfin;
```

Atau gunakan MySQL Workbench/phpMyAdmin

**Jika menggunakan SQLite:**
Database akan otomatis dibuat saat migration.

### 6. **Run Database Migrations**

```bash
php artisan migrate
```

Ini akan membuat semua tabel di database.

### 7. **Seed Database dengan Sample Data**

```bash
php artisan db:seed
```

Ini akan mengisi database dengan data contoh (modules, courses, lessons, quizzes, etc).

### 8. **Install Node Dependencies**

```bash
npm install
```

### 9. **Build CSS Assets (Tailwind)**

```bash
npm run build
```

### 10. **Clear All Caches**

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 🚀 Menjalankan Aplikasi

### Opsi 1: Development Mode (Recommended)

**Terminal 1 - Start Laravel Server:**
```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

**Terminal 2 - Watch Assets (baru):**
```bash
npm run dev
```

Ini akan watch perubahan CSS dan JavaScript secara real-time.

### Opsi 2: Production Mode

```bash
npm run build
php artisan serve --env=production
```

### Opsi 3: Gunakan Valet (Mac) atau Homestead (semua platform)

Jika Anda menggunakan Laravel Valet atau Homestead, ikuti dokumentasi mereka.

---

## 👤 Login Credentials

Setelah seeding, gunakan akun test berikut:

```
Email:    john@example.com
Password: password
```

---

## 🔍 Troubleshooting

### Error: "Route [register] not defined"

**Solusi:** Pastikan Anda telah menjalankan migrations dan file routes sudah ter-update.

```bash
php artisan migrate
php artisan cache:clear
```

### Error: "No application encryption key has been specified"

**Solusi:** Generate application key:
```bash
php artisan key:generate
```

### Error: "Connection refused" / Database error

**Solusi:** 
1. Pastikan database server berjalan (MySQL/SQLite)
2. Check konfigurasi di `.env` sesuai database Anda
3. Jalankan migration: `php artisan migrate`

### Error: "npm command not found"

**Solusi:** 
1. Install Node.js dari https://nodejs.org
2. Restart terminal dan coba lagi

### CSS/JS tidak loading

**Solusi:**
```bash
npm install
npm run build
php artisan cache:clear
```

### 500 Internal Server Error

**Solusi:**
1. Check log file: `storage/logs/laravel.log`
2. Pastikan file permissions OK: `chmod -R 755 storage bootstrap/cache`
3. Clear cache: `php artisan cache:clear`

---

## 📁 Project Structure

```
uas_web/
├── app/
│   ├── Http/Controllers/      ← Controller files
│   └── Models/                ← Database models
├── database/
│   ├── migrations/            ← Database schema
│   └── seeders/               ← Sample data
├── resources/
│   ├── css/                   ← Tailwind CSS
│   ├── js/                    ← JavaScript
│   └── views/                 ← Blade templates
├── routes/
│   └── web.php                ← Route definitions
├── storage/                   ← Logs dan cache
├── .env                       ← Environment configuration
├── composer.json              ← PHP dependencies
├── package.json               ← Node dependencies
└── artisan                    ← CLI tool
```

---

## 📝 Useful Commands

| Command | Description |
|---------|-------------|
| `php artisan serve` | Start development server |
| `npm run dev` | Watch assets for development |
| `npm run build` | Build assets for production |
| `php artisan migrate` | Run database migrations |
| `php artisan db:seed` | Seed database |
| `php artisan tinker` | Interactive PHP shell |
| `php artisan cache:clear` | Clear cache |
| `php artisan route:list` | List all routes |

---

## 🔐 Security Notes

Untuk production deployment:

1. Set `APP_DEBUG=false` di `.env`
2. Set `APP_ENV=production` di `.env`
3. Use strong database password
4. Configure proper `.htaccess` or nginx config
5. Use HTTPS/SSL certificate
6. Keep dependencies updated: `composer update`

---

## 📚 Resources

- Laravel Documentation: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com
- MySQL: https://dev.mysql.com/doc
- Node.js: https://nodejs.org/docs

---

## 🆘 Need Help?

Jika Anda mengalami masalah:

1. Check `storage/logs/laravel.log` untuk error details
2. Run `php artisan config:cache` dan `php artisan cache:clear`
3. Pastikan semua dependencies terinstall dengan benar
4. Restart PHP server dan browser

---

**Selamat! Anda siap menggunakan CerdasFin! 🎉**
