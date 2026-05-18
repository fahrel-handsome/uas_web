# CerdasFin - Platform Literasi Keuangan

Platform pembelajaran literasi keuangan berbasis Laravel dengan fitur kursus, kuis, forum diskusi, dan alat finansial interaktif.

## 🌟 Fitur Utama

### 1. **Modul Terstruktur**
- Modul pembelajaran yang terorganisir dengan baik
- Kursus dengan materi lengkap dan terstruktur
- Pelajaran interaktif dengan video pembelajaran

### 2. **Kuis & Assessment**
- Kuis interaktif untuk setiap kursus
- Sistem penilaian otomatis
- Pelacakan hasil pembelajaran

### 3. **Forum Diskusi**
- Komunitas diskusi aktif
- Berbagi pengalaman dan pengetahuan
- Tanya jawab dengan sesama pengguna

### 4. **Alat Finansial Interaktif**
- Kalkulator Hipotik (Mortgage Calculator)
- Kalkulator Tabungan (Savings Calculator)
- Kalkulator Investasi (Investment Calculator)
- Perencana Anggaran (Budget Planner)

### 5. **Gamifikasi & Sertifikat**
- Sistem poin dan badge
- Ranking pengguna
- Sertifikat digital untuk setiap kursus yang diselesaikan
- Analitik dan tracking kemajuan

### 6. **Dashboard Pengguna**
- Ringkasan kemajuan pembelajaran
- Statistik poin dan badge
- Kursus yang sedang berjalan
- Riwayat kuis

## 🚀 Instalasi & Setup

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- Database (MySQL/SQLite)

### Langkah-langkah Instalasi

1. **Clone atau ekstrak project**
```bash
cd uas_web
```

2. **Install dependencies PHP**
```bash
composer install
```

3. **Install dependencies JavaScript**
```bash
npm install
```

4. **Setup file environment**
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cerdasfin
DB_USERNAME=root
DB_PASSWORD=
```

5. **Generate Application Key**
```bash
php artisan key:generate
```

6. **Jalankan Migrasi Database**
```bash
php artisan migrate
```

7. **Jalankan Seeder (Isi data contoh)**
```bash
php artisan db:seed
```

8. **Build Assets (Tailwind CSS)**
```bash
npm run build
```

## 🏃 Menjalankan Aplikasi

### Development Mode (Recommended)

Buka terminal dan jalankan perintah berikut di folder project:

```bash
npm run dev
```

Kemudian di terminal lain, jalankan:

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

### Production Mode

```bash
npm run build
php artisan serve --env=production
```

## 👤 Akun Test

Setelah seeding, gunakan akun berikut untuk login:
- **Email:** john@example.com
- **Password:** password

## 📚 Struktur Project

```
uas_web/
├── app/
│   ├── Http/
│   │   └── Controllers/     # Controller untuk setiap fitur
│   └── Models/              # Model database (User, Course, Quiz, dll)
├── database/
│   ├── migrations/          # File migrasi database
│   └── seeders/             # File seeder untuk data contoh
├── resources/
│   ├── css/                 # CSS Tailwind
│   ├── js/                  # JavaScript
│   └── views/               # Template Blade PHP
│       ├── courses/         # View untuk kursus
│       ├── quizzes/         # View untuk kuis
│       ├── forum/           # View untuk forum
│       ├── certificates/    # View untuk sertifikat
│       └── tools/           # View untuk alat finansial
├── routes/
│   └── web.php              # Routing aplikasi
└── public/                  # Asset publik
```

## 🎯 Fitur-Fitur Lengkap

### Halaman Publik
- **Beranda**: Tampilan utama dengan overview modul dan kursus populer
- **Daftar Kursus**: Semua kursus yang tersedia dengan filter
- **Forum**: Tempat diskusi komunitas

### Halaman Pengguna (Autentikasi)
- **Dashboard**: Ringkasan kemajuan dan statistik
- **Pembelajaran**: Pelajaran dengan video, konten, dan status penyelesaian
- **Kuis**: Ujian interaktif dengan penilaian otomatis
- **Sertifikat**: Koleksi sertifikat digital yang telah diraih
- **Profil**: Manajemen profil pengguna

### Alat Finansial
- **Mortgage Calculator**: Hitung cicilan dan bunga pinjaman rumah
- **Savings Calculator**: Proyeksikan pertumbuhan tabungan
- **Investment Calculator**: Simulasi hasil investasi
- **Budget Planner**: Kelola anggaran dengan metode 50/30/20

## 📊 Database

Aplikasi menggunakan struktur database berikut:

- `users`: Tabel pengguna
- `modules`: Modul pembelajaran
- `courses`: Kursus dalam modul
- `lessons`: Pelajaran dalam kursus
- `quizzes`: Kuis untuk kursus
- `questions`: Pertanyaan dalam kuis
- `user_quiz_answers`: Jawaban pengguna untuk kuis
- `forum_categories`: Kategori forum
- `forum_posts`: Postingan di forum
- `forum_comments`: Komentar pada postingan
- `certificates`: Sertifikat pengguna
- `user_progress`: Kemajuan pengguna dalam kursus
- `user_points`: Poin dan badge pengguna

## 🎨 Styling

Aplikasi menggunakan **Tailwind CSS 4** untuk styling yang modern dan responsif.

Build CSS untuk production:
```bash
npm run build
```

Watch CSS untuk development:
```bash
npm run dev
```

## 🔐 Keamanan

- Authentication menggunakan Laravel built-in
- Password hashing dengan bcrypt
- CSRF protection
- Authorization checks di controller
- SQL injection protection melalui ORM

## 📝 Catatan Penting

1. **Email Verification**: Tidak diaktifkan dalam versi ini, bisa diaktifkan di model User
2. **Akses Forum**: Pengguna harus login untuk membuat topik dan komentar
3. **Sertifikat**: Hanya diberikan setelah menyelesaikan semua quiz dengan nilai lulus
4. **Gamifikasi**: Poin diberikan otomatis saat menyelesaikan pelajaran dan quiz

## 🚀 Deployment

Untuk deployment ke server:

1. Upload project ke server
2. Setup domain dan SSL
3. Jalankan:
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
php artisan db:seed --force
php artisan cache:clear
```

4. Setup proper file permissions dan .env

## 📞 Support & Kontribusi

Jika ada pertanyaan atau saran, silakan hubungi tim development atau buat issue di repository.

## 📄 Lisensi

Project ini dilisensikan under MIT License.

---

**CerdasFin** - Literasi Keuangan Untuk Indonesia 🇮🇩
