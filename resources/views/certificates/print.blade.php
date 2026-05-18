<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat — {{ $certificate->certificate_number }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Georgia', serif; background: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 40px; }
.cert { background: white; width: 800px; padding: 60px; border: 12px solid #0b7443; box-shadow: 0 8px 40px rgba(0,0,0,0.15); position: relative; }
.cert::before { content: ''; position: absolute; inset: 10px; border: 2px solid #d1fadf; pointer-events: none; }
.logo { text-align: center; margin-bottom: 20px; font-size: 28px; font-weight: bold; color: #0b7443; letter-spacing: -1px; }
.divider { height: 2px; background: linear-gradient(to right, transparent, #0b7443, transparent); margin: 16px 0; }
.cert-title { text-align: center; font-size: 36px; color: #0b7443; margin-bottom: 8px; font-style: italic; }
.cert-sub { text-align: center; font-size: 12px; letter-spacing: 4px; text-transform: uppercase; color: #5b616b; margin-bottom: 40px; }
.recipient-label { text-align: center; color: #5b616b; font-size: 14px; margin-bottom: 8px; }
.recipient-name { text-align: center; font-size: 42px; color: #000; border-bottom: 2px solid #0b7443; display: inline-block; padding: 0 40px 8px; margin: 0 auto 30px; display: block; }
.course-label { text-align: center; color: #5b616b; margin-bottom: 6px; }
.course-name { text-align: center; font-size: 22px; font-weight: bold; color: #0b7443; margin-bottom: 40px; }
.meta { display: flex; justify-content: space-between; font-size: 13px; color: #5b616b; margin-top: 40px; }
.meta-item { text-align: center; }
.meta-item .val { font-weight: bold; color: #000; margin-top: 4px; }
.cert-number { text-align: center; margin-top: 24px; font-size: 11px; color: #aaa; letter-spacing: 2px; }
@media print { body { background: white; } .cert { box-shadow: none; } }
</style>
</head>
<body>
<div class="cert">
    <div class="logo">CerdasFin</div>
    <div class="divider"></div>
    <div class="cert-title">Sertifikat Penyelesaian</div>
    <div class="cert-sub">Certificate of Completion</div>
    <div class="recipient-label">Diberikan kepada:</div>
    <div class="recipient-name">{{ $user->name }}</div>
    <div class="course-label">Telah berhasil menyelesaikan kursus:</div>
    <div class="course-name">{{ $certificate->course->title ?? 'Kursus' }}</div>
    <div class="divider"></div>
    <div class="meta">
        <div class="meta-item">
            <div>Modul</div>
            <div class="val">{{ $certificate->course->module->title ?? '-' }}</div>
        </div>
        <div class="meta-item">
            <div>Tanggal Penyelesaian</div>
            <div class="val">{{ $certificate->issued_at?->format('d F Y') }}</div>
        </div>
        <div class="meta-item">
            <div>Diterbitkan oleh</div>
            <div class="val">CerdasFin Platform</div>
        </div>
    </div>
    <div class="cert-number">{{ $certificate->certificate_number }}</div>
    <div style="text-align:center;margin-top:20px;font-size:12px;color:#aaa;">
        Platform Literasi Keuangan Indonesia · cerdasfin.id
    </div>
</div>
<script>window.onload = () => window.print();</script>
</body>
</html>
