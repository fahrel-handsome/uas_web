Tentu, ini adalah versi yang jauh lebih mendalam, mencakup struktur *folder*, konvensi *coding* Laravel (Service-Repository Pattern), aturan *database*, dan alur logika bisnis secara detail.

Semua ini sudah disiapkan dalam satu blok *markdown* penuh agar siap kamu *copy-paste* langsung ke *repository* CerdasFin.

```markdown
# CerdasFin - Agent Guide & Technical Specification

**Project Lead:** Fahrel
**Tech Stack:** Laravel 11+, PHP 8.2+, MySQL, Tailwind CSS, Chart.js/ApexCharts.

---

## 1. Non-Negotiable Rules

- **Klarifikasi Sebelum Implementasi:** Jika *requirement* terkait logika edukasi atau perhitungan skor simulasi terasa ambigu, diskusikan sebelum menulis kode.
- [cite_start]**Kesederhanaan UI/UX:** Mayoritas target pengguna berasal dari masyarakat bawah dan pedesaan dengan pemahaman keuangan dan teknologi yang terbatas[cite: 5, 9, 55]. Antarmuka harus sangat intuitif, *font* mudah dibaca, dan *copywriting* tidak menggunakan jargon teknis keuangan yang rumit.
- [cite_start]**Integritas Alur Belajar Berjenjang:** Konsep utama CerdasFin adalah "Belajar Langkah demi Langkah yang Terukur"[cite: 27]. [cite_start]Pengguna **wajib** mengikuti urutan yang terkunci secara sistematis: Mengerjakan *Pre-Test* -> Membaca materi & menonton video edukasi -> Mengerjakan *Post-Test*[cite: 33, 34, 35, 36, 44, 45, 46, 47]. Jangan buat jalur pintas (*bypass*) untuk melewati alur ini.
- [cite_start]**Posisikan Diri Sebagai Kontributor:** Ikuti arsitektur yang sudah ditetapkan (Repository Pattern & Service Layer)[cite: 102]. Jangan menginisiasi *library* eksternal yang tidak diperlukan tanpa diskusi.

---

## 2. Source of Truth

[cite_start]CerdasFin dibangun untuk menekan tingginya angka korban pinjol ilegal (2.263 entitas diblokir sepanjang 2025) [cite: 3] [cite_start]dan judi *online* (potensi kerugian mencapai Rp 9 triliun pada tahun 2025)[cite: 4].

Prioritas pengambilan keputusan kode:
1. [cite_start]Integritas data pengukuran (*Pre-Test* dan *Post-Test*)[cite: 11, 37].
2. [cite_start]Keamanan dan otorisasi *Role-Based Access Control* (User, Admin, Mentor)[cite: 58].
3. [cite_start]Performa aplikasi (Gunakan *Queue* untuk proses berat)[cite: 104].

---

## 3. Architecture & Directory Structure (Laravel)

[cite_start]Proyek ini menerapkan **Service-Repository Pattern** untuk memisahkan *business logic* dari *controller* dan *database query*[cite: 102].

```text
cerdasfin/
|- app/
|  |- Http/
|  |  |- Controllers/
|  |  |  |- Admin/          <- Controller khusus dashboard admin (Statistik, User Mgt)
|  |  |  |- User/           <- Controller untuk modul, quiz, simulasi
|  |  |  `- Auth/           <- Laravel Breeze/Jetstream Auth controllers
|  |  |- Requests/          <- Form Requests untuk validasi ketat
|  |  `- Middleware/        <- CheckRole, CheckModuleProgress
|  |- Models/               <- Eloquent Models (User, Module, Quiz, UserScore, dll)
|  |- Repositories/         <- Layer abstraksi query database
|  |  |- Contracts/         <- Interfaces (Misal: ModuleRepositoryInterface)
|  |  `- Eloquent/          <- Implementasi (Misal: ModuleRepository)
|  |- Services/             <- Layer Business Logic murni
|  |  |- GamificationService.php <- Hitung poin, update level
|  |  |- QuizScoringService.php  <- Hitung nilai Pre-Test & Post-Test
|  |  |- CertificateService.php  <- Generate PDF sertifikat
|  |  `- SimulationService.php   <- Kalkulator bunga pinjol, investasi
|  `- Jobs/                 <- Async Tasks (GenerateSertifikatJob, SendReminderJob)
|- resources/
|  |- views/
|  |  |- admin/             <- Blade templates Admin Panel
|  |  |- user/              <- Blade templates Dashboard & Modul User
|  |  `- components/        <- Shared UI (Cards, Modals, Data Tables)
|- routes/
|  `- web.php               <- Routing yang dikelompokkan berdasarkan Role

```

---

## 4. Backend Coding Conventions

### 4.1 Controllers

* *Controller* harus **kurus** (*thin controller*). Hanya bertugas menerima *request*, memanggil *Service Layer*, dan mengembalikan *response*/*view*.
* Gunakan Form Request Classes (`app/Http/Requests`) untuk semua validasi *input* data.
* Autorisasi dilakukan via *Middleware*, *Gates*, atau *Policies* bawaan Laravel. Jangan lakukan cek *role* manual menggunakan `if` di dalam *controller*.



### 4.2 Service Layer & Repository

* Semua logika perhitungan bisnis (seperti pengecekan apakah skor *post-test* meningkat dari *pre-test*, atau kalkulasi simulasi finansial ) wajib berada di `app/Services/`.


* Semua *query database* yang kompleks wajib diekstraksi ke `app/Repositories/`.
* Jangan pernah memanggil `Model::where(...)` secara langsung di dalam *Controller*. Akses data via *Repository*, manipulasi logika via *Service*.

### 4.3 Database & Migrations

* Gunakan konvensi penamaan standar Laravel (tabel jamak/ *plural*, model tunggal/ *singular*).
* Setiap *model* utama harus mengimplementasikan `SoftDeletes` untuk menjaga integritas data statistik laporan admin (misal, jika *user* dihapus, data skornya untuk laporan dampak  tidak hilang).


* *Foreign keys* wajib menggunakan `constrained()->cascadeOnDelete()` atau `restrictOnDelete()` sesuai kebutuhan domain.

---

## 5. Domain Rules & Core Logic

### 5.1 Modul Pembelajaran Berjenjang

Modul mencakup: Dasar Literasi, Pinjol Ilegal, Judi Online, dan Keuangan Sehat.

* Status Modul Pengguna dalam *database*: `LOCKED`, `PRE_TEST_DONE`, `LEARNING`, `POST_TEST_DONE`, `COMPLETED`.
* *Guard* Logika: Jika `status !== 'PRE_TEST_DONE'`, *view* Materi/Video tidak boleh diakses (kembalikan `403 Forbidden` atau *redirect* ke *Pre-test*).

### 5.2 Pengukuran Dampak (Pre & Post Test)

* Sistem wajib mencatat `score_pre_test` dan `score_post_test` pada tabel pivot `user_module_progress`.
* Peningkatan pengetahuan *user* (Δ *Score*) dihitung di *Service Layer* dan divisualisasikan menggunakan Chart.js atau ApexCharts di *Dashboard User* dan *Admin Panel*.



### 5.3 Gamifikasi & Sertifikasi

* 
**Gamifikasi:** Pengguna mendapat poin berdasarkan: penyelesaian modul, aktivitas harian (*streak*), dan partisipasi forum diskusi.


* **Sertifikasi:** Ketika `status === 'COMPLETED'`, sistem melakukan *dispatch job* `GenerateSertifikatJob` ke antrean (*Queue*) agar PDF digenerate di *background* dan tidak memblokir respon UI. Sertifikat wajib memuat nama pengguna, skor, dan tanggal penyelesaian.



### 5.4 Simulasi Finansial & Awareness

* Algoritma `SimulationService` harus realistis, menggambarkan kasus finansial masyarakat.


* 
**Simulasi Bunga Pinjol:** Harus menunjukkan efek bunga majemuk harian/denda yang mencekik.


* 
**Simulasi Investasi:** Harus menggunakan *return rate* investasi aman (misal: emas atau deposito bank resmi).


* 
**Anti Judol:** Harus menampilkan probabilitas kerugian matematis algoritma judi *online* untuk edukasi interaktif.



---

## 6. Frontend & Visual Conventions

* Semua *styling* menggunakan framework CSS yang dipilih (misal: Tailwind CSS).


* 
*Dashboard Admin* memerlukan grafik komprehensif (Chart.js / ApexCharts) untuk memantau aktivitas *user* dan perkembangan literasi.


* Responsivitas *Mobile* adalah prioritas utama (Mobile-First Design), mengingat audiens utama di pedesaan lebih dominan mengakses melalui *smartphone*.



---

## 7. Workflow Checklists (Before Committing)

### Backend / Logic

* [ ] Apakah *query DB* diletakkan di *Repository*?
* [ ] Apakah perhitungan poin/skor sudah dipisah ke *Service Layer*?
* [ ] Apakah *endpoint* dibatasi *Middleware* / *Role* dengan benar? (Admin vs User vs Mentor) .


* [ ] Apakah *job* berat (PDF Sertifikat, Kirim Email Notifikasi Reminder) sudah dimasukkan ke *Queue*?.



### Frontend / UI

* [ ] Apakah bahasa dan istilah yang digunakan mudah dipahami orang awam?
* [ ] Apakah UI ter-render sempurna di ukuran layar *mobile*?
* [ ] Apakah grafik *Pre-Test* & *Post-Test* merender data yang akurat dari *database*?.


* [ ] Apakah tombol lewati (*skip*) disembunyikan di halaman materi jika pengguna belum mengerjakan *Pre-Test*?.



```

```