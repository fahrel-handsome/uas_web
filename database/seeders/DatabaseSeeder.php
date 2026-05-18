<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Module;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\ForumCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ─── Admin User ────────────────────────────────────────
        $admin = User::firstOrCreate(['email' => 'admin@cerdasfin.id'], [
            'name'     => 'Admin CerdasFin',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);
        $admin->ensureUserPointsExist();

        // ─── Test User ─────────────────────────────────────────
        $user = User::firstOrCreate(['email' => 'test@cerdasfin.id'], [
            'name'     => 'Fahrel Santoso',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);
        $user->ensureUserPointsExist();
        $user->userPoints()->update(['total_points' => 350, 'rank' => 3, 'badge' => 'Intermediate']);

        // ═══════════════════════════════════════════════════════
        // 4 MODUL UTAMA CERDASFIN
        // ═══════════════════════════════════════════════════════

        // MODULE 1 — Dasar Literasi Keuangan
        $m1 = Module::firstOrCreate(['slug' => 'dasar-literasi-keuangan'], [
            'title'        => 'Dasar Literasi Keuangan',
            'description'  => 'Pahami konsep dasar keuangan: menabung, anggaran 50/30/20, dan fondasi finansial yang kuat untuk masa depan.',
            'icon'         => '💰',
            'order'        => 1,
            'is_published' => true,
        ]);

        $c1 = Course::firstOrCreate(['slug' => 'pengantar-literasi-keuangan'], [
            'module_id'        => $m1->id,
            'title'            => 'Pengantar Literasi Keuangan',
            'description'      => 'Mulai perjalananmu menuju keuangan sehat dengan memahami konsep dasar keuangan personal.',
            'duration_minutes' => 60,
            'order'            => 1,
            'is_published'     => true,
        ]);

        $this->createLessons($c1->id, [
            ['Apa itu Literasi Keuangan?', '<p>Literasi keuangan adalah pengetahuan dan keterampilan untuk mengelola sumber daya keuangan secara efektif.</p><ul><li>Memahami pendapatan dan pengeluaran</li><li>Menabung dan berinvestasi</li><li>Menghindari hutang bermasalah</li><li>Merencanakan masa depan finansial</li></ul>', null, 15],
            ['Pilar Literasi Keuangan', '<p><strong>4 Pilar Utama:</strong></p><p><strong>1. Saving</strong> — Menabung minimal 20% dari penghasilan.</p><p><strong>2. Spending</strong> — Belanja cerdas, bedakan kebutuhan vs keinginan.</p><p><strong>3. Borrowing</strong> — Pinjam hanya dari lembaga OJK resmi.</p><p><strong>4. Investing</strong> — Investasi aman sesuai profil risiko.</p>', null, 20],
            ['Metode Anggaran 50/30/20', '<p>Alokasikan penghasilan bulananmu:</p><ul><li><strong>50%</strong> untuk Kebutuhan (makanan, tempat tinggal, transportasi)</li><li><strong>30%</strong> untuk Keinginan (hiburan, hobi)</li><li><strong>20%</strong> untuk Tabungan & Investasi</li></ul>', 'https://www.youtube.com/embed/sVKQn2I4HDM', 25],
        ]);

        $q1pre = Quiz::firstOrCreate(['slug' => 'm1-pre-test'], [
            'course_id'    => $c1->id,
            'type'         => 'pre_test',
            'title'        => 'Pre-Test: Dasar Literasi Keuangan',
            'description'  => 'Ukur pengetahuan awalmu tentang literasi keuangan.',
            'passing_score' => 0,
            'order'        => 0,
            'is_published' => true,
        ]);
        $this->createQuestions($q1pre->id, $this->preTestM1Questions());

        $q1 = Quiz::firstOrCreate(['slug' => 'quiz-pengantar-literasi-keuangan'], [
            'course_id'    => $c1->id,
            'type'         => 'regular',
            'title'        => 'Quiz: Pengantar Literasi Keuangan',
            'description'  => 'Uji pemahamanmu tentang dasar literasi keuangan.',
            'passing_score' => 70,
            'order'        => 1,
            'is_published' => true,
        ]);
        $this->createQuestions($q1->id, $this->quizM1Questions());

        $q1post = Quiz::firstOrCreate(['slug' => 'm1-post-test'], [
            'course_id'    => $c1->id,
            'type'         => 'post_test',
            'title'        => 'Post-Test: Dasar Literasi Keuangan',
            'description'  => 'Tunjukkan seberapa banyak yang telah kamu pelajari!',
            'passing_score' => 70,
            'order'        => 99,
            'is_published' => true,
        ]);
        $this->createQuestions($q1post->id, $this->postTestM1Questions());

        // MODULE 2 — Bahaya Pinjol Ilegal
        $m2 = Module::firstOrCreate(['slug' => 'bahaya-pinjol-ilegal'], [
            'title'        => 'Bahaya Pinjol Ilegal',
            'description'  => 'Kenali ciri-ciri pinjol ilegal, dampak bunga majemuk yang mencekik, dan cara melaporkannya ke OJK.',
            'icon'         => '🚫',
            'order'        => 2,
            'is_published' => true,
        ]);

        $c2 = Course::firstOrCreate(['slug' => 'mengenali-pinjol-ilegal'], [
            'module_id'        => $m2->id,
            'title'            => 'Mengenali & Menghindari Pinjol Ilegal',
            'description'      => 'Kenali tanda bahaya pinjol ilegal dan cara melindungi diri.',
            'duration_minutes' => 45,
            'order'            => 1,
            'is_published'     => true,
        ]);

        $this->createLessons($c2->id, [
            ['Apa itu Pinjol Ilegal?', '<p>Pinjol ilegal adalah layanan pinjaman online yang tidak terdaftar/berizin di OJK.</p><p><strong>Ciri-ciri Pinjol Ilegal:</strong></p><ul><li>Tidak ada izin OJK</li><li>Bunga harian >0.4% (lebih dari 0.4% per hari = ilegal)</li><li>Mengakses seluruh kontak HP</li><li>Penagihan dengan ancaman dan kekerasan</li><li>Tidak memiliki kantor fisik yang jelas</li></ul>', null, 20],
            ['Dampak Bunga Majemuk Pinjol', '<p>Bunga majemuk pinjol ilegal sangat berbahaya:</p><p>Contoh: Pinjam Rp 1 Juta, bunga 1%/hari:</p><ul><li>Setelah 30 hari → Rp 1.348.000</li><li>Setelah 60 hari → Rp 1.817.000</li><li>Setelah 90 hari → Rp 2.450.000</li></ul><p>Hutang bisa 2.5x lipat hanya dalam 3 bulan!</p>', null, 15],
            ['Cara Lapor & Alternatif Aman', '<p><strong>Cara Lapor Pinjol Ilegal:</strong></p><ul><li>Hubungi OJK di 157</li><li>Email: konsumen@ojk.go.id</li><li>Website: www.ojk.go.id</li></ul><p><strong>Alternatif Pinjaman Aman:</strong></p><ul><li>Bank dengan KUR (bunga ~6%/tahun)</li><li>Koperasi simpan pinjam resmi</li><li>Pinjol OJK (cek di: ojk.go.id)</li></ul>', null, 10],
        ]);

        $q2pre = Quiz::firstOrCreate(['slug' => 'm2-pre-test'], [
            'course_id'    => $c2->id, 'type' => 'pre_test',
            'title'        => 'Pre-Test: Bahaya Pinjol Ilegal',
            'description'  => 'Seberapa banyak yang kamu tahu tentang pinjol ilegal?',
            'passing_score' => 0, 'order' => 0, 'is_published' => true,
        ]);
        $this->createQuestions($q2pre->id, $this->preTestM2Questions());

        $q2 = Quiz::firstOrCreate(['slug' => 'quiz-pinjol-ilegal'], [
            'course_id'    => $c2->id, 'type' => 'regular',
            'title'        => 'Quiz: Bahaya Pinjol Ilegal',
            'description'  => 'Uji pemahamanmu tentang pinjol ilegal.',
            'passing_score' => 70, 'order' => 1, 'is_published' => true,
        ]);
        $this->createQuestions($q2->id, $this->quizM2Questions());

        $q2post = Quiz::firstOrCreate(['slug' => 'm2-post-test'], [
            'course_id'    => $c2->id, 'type' => 'post_test',
            'title'        => 'Post-Test: Bahaya Pinjol Ilegal',
            'description'  => 'Tunjukkan pemahamanmu tentang pinjol ilegal!',
            'passing_score' => 70, 'order' => 99, 'is_published' => true,
        ]);
        $this->createQuestions($q2post->id, $this->quizM2Questions());

        // MODULE 3 — Bahaya Judi Online
        $m3 = Module::firstOrCreate(['slug' => 'bahaya-judi-online'], [
            'title'        => 'Bahaya Judi Online',
            'description'  => 'Pahami matematika kekalahan judi online, dampak psikologis, dan strategi keluar dari kecanduan.',
            'icon'         => '🎰',
            'order'        => 3,
            'is_published' => true,
        ]);

        $c3 = Course::firstOrCreate(['slug' => 'memahami-bahaya-judi-online'], [
            'module_id'        => $m3->id,
            'title'            => 'Memahami & Menghindari Judi Online',
            'description'      => 'Kenali dampak negatif judi online dan cara melindungi diri.',
            'duration_minutes' => 50,
            'order'            => 1,
            'is_published'     => true,
        ]);

        $this->createLessons($c3->id, [
            ['Matematika Kekalahan Judi Online', '<p>Judi online dirancang agar pemain selalu kalah dalam jangka panjang:</p><ul><li><strong>House Edge Slot:</strong> 5-15% (platform ambil 5-15 sen dari setiap Rp 1.000 taruhan)</li><li><strong>Rake Poker:</strong> 2-10% dari setiap pot</li><li><strong>Margin Bola:</strong> 3-8% dari setiap taruhan</li></ul><p>Dengan house edge 10%, jika kamu taruhan Rp 100.000/hari × 365 hari = kerugian ekspektasi Rp 3.65 juta/tahun.</p>', null, 25],
            ['Dampak Psikologis & Sosial', '<p><strong>Dampak Kecanduan Judi Online:</strong></p><ul><li>Gangguan keuangan parah (kebangkrutan)</li><li>Masalah kesehatan mental (depresi, kecemasan)</li><li>Keretakan hubungan keluarga</li><li>Penurunan performa kerja/akademik</li><li>Potensi tindak pidana (mencuri untuk judi)</li></ul><p>Indonesia kerugian Rp 9 Triliun/tahun akibat judi online.</p>', null, 20],
            ['Cara Keluar dari Kecanduan Judol', '<p><strong>Langkah Pemulihan:</strong></p><ol><li>Akui masalah dan minta bantuan</li><li>Blokir semua akses platform judi</li><li>Hubungi Kemenkominfo: 159 (blokir situs judi)</li><li>Konsultasi psikolog/konselor adiksi</li><li>Ganti dengan aktivitas positif</li></ol><p><strong>Hotline Bantuan:</strong> Yayasan Pulih: (021) 788-42580</p>', null, 15],
        ]);

        $q3pre = Quiz::firstOrCreate(['slug' => 'm3-pre-test'], [
            'course_id' => $c3->id, 'type' => 'pre_test',
            'title' => 'Pre-Test: Bahaya Judi Online',
            'description' => 'Seberapa banyak yang kamu tahu tentang judi online?',
            'passing_score' => 0, 'order' => 0, 'is_published' => true,
        ]);
        $this->createQuestions($q3pre->id, $this->preTestM3Questions());

        $q3 = Quiz::firstOrCreate(['slug' => 'quiz-judi-online'], [
            'course_id' => $c3->id, 'type' => 'regular',
            'title' => 'Quiz: Bahaya Judi Online',
            'passing_score' => 70, 'order' => 1, 'is_published' => true,
        ]);
        $this->createQuestions($q3->id, $this->preTestM3Questions());

        $q3post = Quiz::firstOrCreate(['slug' => 'm3-post-test'], [
            'course_id' => $c3->id, 'type' => 'post_test',
            'title' => 'Post-Test: Bahaya Judi Online',
            'passing_score' => 70, 'order' => 99, 'is_published' => true,
        ]);
        $this->createQuestions($q3post->id, $this->preTestM3Questions());

        // MODULE 4 — Pengelolaan Keuangan Sehat
        $m4 = Module::firstOrCreate(['slug' => 'pengelolaan-keuangan-sehat'], [
            'title'        => 'Pengelolaan Keuangan Sehat',
            'description'  => 'Investasi aman (emas, deposito), dana darurat, dan perencanaan finansial jangka panjang.',
            'icon'         => '📈',
            'order'        => 4,
            'is_published' => true,
        ]);

        $c4 = Course::firstOrCreate(['slug' => 'investasi-aman-pemula'], [
            'module_id'        => $m4->id,
            'title'            => 'Investasi Aman untuk Pemula',
            'description'      => 'Pelajari cara berinvestasi dengan aman: emas, deposito, dan reksa dana.',
            'duration_minutes' => 60,
            'order'            => 1,
            'is_published'     => true,
        ]);

        $this->createLessons($c4->id, [
            ['Dana Darurat: Pondasi Finansial', '<p>Dana darurat adalah tabungan khusus untuk keadaan tak terduga.</p><p><strong>Berapa yang ideal?</strong></p><ul><li>Karyawan/pegawai: 3-6x pengeluaran bulanan</li><li>Wirausaha: 6-12x pengeluaran bulanan</li></ul><p>Simpan di rekening terpisah yang mudah diakses tapi tidak menggoda untuk dipakai.</p>', null, 20],
            ['Investasi Aman: Emas & Deposito', '<p><strong>Emas (Logam Mulia):</strong></p><ul><li>Stabil jangka panjang, anti-inflasi</li><li>Mulai dari Rp 50.000 (Pegadaian Digital)</li><li>Return ~5-10%/tahun historis</li></ul><p><strong>Deposito Bank:</strong></p><ul><li>Bunga tetap, aman dijamin LPS hingga Rp 2 Miliar</li><li>Return ~4-6%/tahun</li><li>Tenor 1-24 bulan</li></ul>', 'https://www.youtube.com/embed/ph1PwPkOhEs', 25],
            ['Reksa Dana untuk Pemula', '<p>Reksa dana adalah kumpulan dana yang dikelola manajer investasi profesional.</p><p><strong>Jenis reksa dana:</strong></p><ul><li><strong>Pasar Uang</strong>: risiko rendah, return ~4-6%/tahun</li><li><strong>Pendapatan Tetap</strong>: risiko sedang, return ~6-9%/tahun</li><li><strong>Saham</strong>: risiko tinggi, return ~10-15%/tahun</li></ul><p>Mulai dari Rp 10.000 via Bibit, Bareksa, atau Tokopedia.</p>', null, 20],
        ]);

        $q4pre = Quiz::firstOrCreate(['slug' => 'm4-pre-test'], [
            'course_id' => $c4->id, 'type' => 'pre_test',
            'title' => 'Pre-Test: Pengelolaan Keuangan Sehat',
            'passing_score' => 0, 'order' => 0, 'is_published' => true,
        ]);
        $this->createQuestions($q4pre->id, $this->preTestM4Questions());

        $q4 = Quiz::firstOrCreate(['slug' => 'quiz-keuangan-sehat'], [
            'course_id' => $c4->id, 'type' => 'regular',
            'title' => 'Quiz: Pengelolaan Keuangan Sehat',
            'passing_score' => 70, 'order' => 1, 'is_published' => true,
        ]);
        $this->createQuestions($q4->id, $this->preTestM4Questions());

        $q4post = Quiz::firstOrCreate(['slug' => 'm4-post-test'], [
            'course_id' => $c4->id, 'type' => 'post_test',
            'title' => 'Post-Test: Pengelolaan Keuangan Sehat',
            'passing_score' => 70, 'order' => 99, 'is_published' => true,
        ]);
        $this->createQuestions($q4post->id, $this->preTestM4Questions());

        // ─── Forum Categories ───────────────────────────────────
        $forums = [
            ['Diskusi Umum', 'diskusi-umum', 'Diskusi bebas tentang keuangan pribadi dan literasi finansial.'],
            ['Tanya Jawab', 'tanya-jawab', 'Ajukan pertanyaanmu tentang materi kursus atau topik keuangan.'],
            ['Berbagi Pengalaman', 'berbagi-pengalaman', 'Ceritakan pengalaman finansialmu untuk menginspirasi yang lain.'],
            ['Anti Pinjol & Judol', 'anti-pinjol-judol', 'Diskusi tentang perlindungan diri dari pinjol ilegal dan judi online.'],
        ];
        foreach ($forums as [$name, $slug, $desc]) {
            ForumCategory::firstOrCreate(['slug' => $slug], ['name' => $name, 'description' => $desc, 'order' => 1]);
        }

        $this->command->info('✅ CerdasFin database seeded: 4 modul utama + pre/post-test + forum!');
    }

    private function createLessons(int $courseId, array $lessons): void
    {
        foreach ($lessons as $i => [$title, $content, $video, $duration]) {
            Lesson::firstOrCreate(
                ['course_id' => $courseId, 'order' => $i + 1],
                [
                    'title'            => $title,
                    'slug'             => \Illuminate\Support\Str::slug($title),
                    'content'          => $content,
                    'video_url'        => $video,
                    'duration_minutes' => $duration,
                    'is_published'     => true,
                ]
            );
        }
    }

    private function createQuestions(int $quizId, array $questions): void
    {
        foreach ($questions as $i => $q) {
            Question::firstOrCreate(
                ['quiz_id' => $quizId, 'order' => $i + 1],
                ['question' => $q[0], 'options' => $q[1], 'correct_answer' => $q[2]]
            );
        }
    }

    // ═══ SOAL PRE-TEST & QUIZ ══════════════════════════════════

    private function preTestM1Questions(): array {
        return [
            ['Apa arti dari literasi keuangan?', ['Kemampuan membaca buku keuangan', 'Pengetahuan dan skill mengelola keuangan pribadi', 'Cara cepat menjadi kaya', 'Kemampuan mengaudit perusahaan'], 1],
            ['Berapakah idealnya alokasi tabungan dalam metode 50/30/20?', ['10%', '30%', '20%', '50%'], 2],
            ['Apa itu dana darurat?', ['Dana untuk liburan', 'Tabungan untuk situasi tak terduga tanpa harus berhutang', 'Dana investasi jangka panjang', 'Anggaran belanja bulanan'], 1],
        ];
    }

    private function quizM1Questions(): array {
        return [
            ['Pilar utama literasi keuangan yang BUKAN merupakan bagian dari 4 pilar adalah...', ['Saving', 'Spending', 'Speculating', 'Borrowing'], 2],
            ['Dalam metode 50/30/20, berapa persen untuk kebutuhan pokok?', ['30%', '20%', '50%', '40%'], 2],
            ['Mana yang termasuk investasi dengan risiko RENDAH dan aman?', ['Saham gorengan', 'Deposito bank resmi', 'Kripto volatil', 'Pinjol ilegal'], 1],
            ['Berapa minimal dana darurat yang direkomendasikan untuk karyawan?', ['1x pengeluaran bulanan', '3-6x pengeluaran bulanan', '10x pengeluaran bulanan', '12x pengeluaran bulanan'], 1],
        ];
    }

    private function postTestM1Questions(): array {
        return [
            ['Mengapa penting memiliki anggaran keuangan bulanan?', ['Agar bisa pamer ke orang lain', 'Untuk mengontrol pengeluaran dan mencapai tujuan finansial', 'Untuk menghindari pajak', 'Agar bisa berhutang lebih banyak'], 1],
            ['Apa manfaat utama investasi sejak dini?', ['Mendapat pujian dari teman', 'Compound interest membuat uang berkembang lebih besar seiring waktu', 'Bisa berhenti bekerja besok', 'Tidak ada manfaatnya'], 1],
            ['Jika penghasilan Rp 5.000.000, berapa yang seharusnya ditabung menurut 50/30/20?', ['Rp 500.000', 'Rp 1.500.000', 'Rp 1.000.000', 'Rp 2.500.000'], 2],
            ['Apa bedanya kebutuhan dan keinginan?', ['Sama saja', 'Kebutuhan = penting untuk hidup, Keinginan = ingin tapi tidak wajib', 'Keinginan lebih penting dari kebutuhan', 'Kebutuhan hanya makanan saja'], 1],
        ];
    }

    private function preTestM2Questions(): array {
        return [
            ['Apa singkatan OJK?', ['Otoritas Jasa Kepolisian', 'Otoritas Jasa Keuangan', 'Organisasi Jaminan Kredit', 'Otoritas Jaminan Keuangan'], 1],
            ['Pinjol yang aman harus memiliki...', ['Bunga tertinggi', 'Izin resmi dari OJK', 'Kantor di luar negeri', 'Aplikasi yang bagus saja'], 1],
            ['Berapa hotline OJK untuk melaporkan pinjol ilegal?', ['110', '119', '157', '112'], 2],
        ];
    }

    private function quizM2Questions(): array {
        return [
            ['Ciri UTAMA pinjol ilegal adalah...', ['Aplikasinya bagus', 'Tidak memiliki izin OJK dan bunga sangat tinggi', 'Bisa cair dalam 1 jam', 'Banyak iklannya di TV'], 1],
            ['Berapa batas maksimal bunga harian pinjol yang legal menurut OJK?', ['0.1%', '0.4%', '1%', '5%'], 1],
            ['Apa yang harus PERTAMA dilakukan jika terjebak pinjol ilegal?', ['Kabur ke luar negeri', 'Pinjam di pinjol lain untuk menutup hutang', 'Lapor ke OJK 157 dan hentikan pembayaran ke pinjol ilegal', 'Jual semua aset'], 2],
            ['Pinjol ilegal biasanya modus dengan mengakses apa dari HP korban?', ['Aplikasi kamera saja', 'Seluruh daftar kontak untuk mengancam', 'Hanya galeri foto', 'Akun media sosial'], 1],
        ];
    }

    private function preTestM3Questions(): array {
        return [
            ['Apa yang dimaksud "house edge" dalam judi online?', ['Keuntungan yang dijamin pemain', 'Persentase keuntungan yang selalu dimiliki platform judi', 'Biaya sewa kantor', 'Bonus yang diberikan platform'], 1],
            ['Mengapa judi online ilegal di Indonesia?', ['Karena pemerintah iri', 'Karena merusak keuangan dan mental masyarakat serta dilarang undang-undang', 'Karena pajak yang besar', 'Hanya ilegal untuk anak-anak'], 1],
            ['Uang Rp 100.000 yang dipakai judi vs ditabung selama 1 tahun, mana hasilnya lebih baik?', ['Judi, karena bisa menang besar', 'Sama saja', 'Tabungan, karena pasti ada hasilnya', 'Tergantung keberuntungan'], 2],
        ];
    }

    private function preTestM4Questions(): array {
        return [
            ['Apa keuntungan utama investasi emas jangka panjang?', ['Bisa dimakan saat lapar', 'Nilainya cenderung naik dan anti-inflasi', 'Mudah dicuri', 'Tidak ada keuntungannya'], 1],
            ['Deposito bank dijamin oleh lembaga apa?', ['Polisi', 'OJK saja', 'LPS (Lembaga Penjamin Simpanan) hingga Rp 2 Miliar', 'Bank Indonesia'], 2],
            ['Reksa dana pasar uang cocok untuk investor yang...', ['Ingin untung besar dalam semalam', 'Menginginkan risiko rendah dan likuiditas tinggi', 'Suka spekulasi', 'Tidak peduli dengan investasi'], 1],
        ];
    }
}
