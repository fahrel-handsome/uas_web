<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Sertifikat CerdasFin — {{ $certificate->certificate_number }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'DejaVu Sans', 'Arial', sans-serif;
    background: #f5f5f0;
    width: 297mm;
    height: 210mm;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cert-wrapper {
    width: 277mm;
    height: 190mm;
    background: #ffffff;
    border: 3px solid #0b7443;
    position: relative;
    padding: 20mm 24mm;
}
/* Corner decorations */
.corner {
    position: absolute;
    width: 18mm;
    height: 18mm;
    border-color: #61bc76;
    border-style: solid;
}
.corner-tl { top: 6mm; left: 6mm; border-width: 3px 0 0 3px; }
.corner-tr { top: 6mm; right: 6mm; border-width: 3px 3px 0 0; }
.corner-bl { bottom: 6mm; left: 6mm; border-width: 0 0 3px 3px; }
.corner-br { bottom: 6mm; right: 6mm; border-width: 0 3px 3px 0; }
/* Inner border */
.inner-border {
    position: absolute;
    inset: 10mm;
    border: 1px solid #d1fadf;
}
/* Logo */
.logo {
    text-align: center;
    font-size: 22pt;
    font-weight: bold;
    color: #0b7443;
    letter-spacing: -0.5pt;
    margin-bottom: 2mm;
}
.logo-sub {
    text-align: center;
    font-size: 8pt;
    letter-spacing: 3pt;
    color: #5b616b;
    text-transform: uppercase;
    margin-bottom: 6mm;
}
/* Divider */
.divider {
    border: none;
    border-top: 1.5px solid #0b7443;
    margin: 0 auto 6mm;
    width: 80mm;
}
/* Titles */
.cert-title {
    text-align: center;
    font-size: 28pt;
    font-weight: bold;
    color: #0b7443;
    margin-bottom: 1mm;
    font-style: italic;
}
.cert-subtitle {
    text-align: center;
    font-size: 9pt;
    letter-spacing: 4pt;
    color: #5b616b;
    text-transform: uppercase;
    margin-bottom: 8mm;
}
/* Recipient */
.given-to {
    text-align: center;
    font-size: 9pt;
    color: #5b616b;
    margin-bottom: 2mm;
}
.recipient-name {
    text-align: center;
    font-size: 30pt;
    font-weight: bold;
    color: #000000;
    border-bottom: 1.5px solid #0b7443;
    display: inline-block;
    padding: 0 15mm 2mm;
    margin: 0 auto 4mm;
}
.name-wrapper { text-align: center; margin-bottom: 5mm; }
/* Course info */
.completed-text {
    text-align: center;
    font-size: 9pt;
    color: #5b616b;
    margin-bottom: 2mm;
}
.course-title {
    text-align: center;
    font-size: 14pt;
    font-weight: bold;
    color: #0b7443;
    margin-bottom: 8mm;
}
/* Meta footer */
.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: 8mm;
    padding-top: 4mm;
    border-top: 1px solid #e5e7eb;
}
.meta-col { text-align: center; }
.meta-label { font-size: 7pt; color: #9ca3af; text-transform: uppercase; letter-spacing: 1pt; margin-bottom: 2mm; }
.meta-val   { font-size: 9pt; font-weight: bold; color: #000; }
.cert-number {
    text-align: center;
    margin-top: 4mm;
    font-size: 7pt;
    color: #9ca3af;
    letter-spacing: 1.5pt;
    font-family: 'Courier New', monospace;
}
/* Score badge */
.score-badge {
    display: inline-block;
    background: #d1fadf;
    color: #0b7443;
    padding: 3mm 8mm;
    border-radius: 20mm;
    font-weight: bold;
    font-size: 10pt;
    margin: 0 auto 6mm;
}
.score-wrapper { text-align: center; }
</style>
</head>
<body>
<div class="cert-wrapper">
    <!-- Corners -->
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>
    <div class="inner-border"></div>

    <!-- Logo -->
    <div class="logo">🌱 CerdasFin</div>
    <div class="logo-sub">Platform Literasi Keuangan Indonesia</div>
    <hr class="divider">

    <!-- Title -->
    <div class="cert-title">Sertifikat Penyelesaian</div>
    <div class="cert-subtitle">Certificate of Completion</div>

    <!-- Recipient -->
    <div class="given-to">Diberikan kepada:</div>
    <div class="name-wrapper">
        <span class="recipient-name">{{ $user->name }}</span>
    </div>

    <!-- Course -->
    <div class="completed-text">Telah berhasil menyelesaikan kursus:</div>
    <div class="course-title">{{ $course->title ?? 'Kursus Literasi Keuangan' }}</div>

    @if($avg_score)
    <div class="score-wrapper">
        <span class="score-badge">Rata-rata Skor: {{ $avg_score }}/100</span>
    </div>
    @endif

    <!-- Meta Footer -->
    <div class="meta-row">
        <div class="meta-col">
            <div class="meta-label">Modul</div>
            <div class="meta-val">{{ $module->title ?? '-' }}</div>
        </div>
        <div class="meta-col">
            <div class="meta-label">Tanggal Dikeluarkan</div>
            <div class="meta-val">{{ $issued_date }}</div>
        </div>
        <div class="meta-col">
            <div class="meta-label">Dikeluarkan Oleh</div>
            <div class="meta-val">CerdasFin Platform</div>
        </div>
    </div>

    <div class="cert-number">{{ $certificate->certificate_number }}</div>
</div>
</body>
</html>
