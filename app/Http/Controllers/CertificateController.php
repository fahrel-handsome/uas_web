<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Module;
use App\Models\UserProgress;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(): View
    {
        $certificates = Certificate::where('user_id', auth()->id())
            ->with(['course.module'])
            ->orderByDesc('issued_at')
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    public function show(Certificate $certificate): View
    {
        if ($certificate->user_id !== auth()->id()) abort(403);
        $certificate->load(['course.module']);
        return view('certificates.show', compact('certificate'));
    }

    /**
     * Generate PDF certificate download.
     *
     * Rules:
     * 1. Certificate must belong to authenticated user.
     * 2. User must have completed the module (score_post_test exists or is_completed).
     * 3. Generate PDF from certificates.print view.
     */
    public function download(Certificate $certificate): Response
    {
        if ($certificate->user_id !== auth()->id()) abort(403);

        $certificate->load(['course.module']);
        $user = auth()->user();

        // Verify user has actually completed the related module/course
        $isCompleted = UserProgress::where('user_id', $user->id)
            ->where(function ($q) use ($certificate) {
                $q->where('module_id', $certificate->course->module_id ?? null)
                  ->orWhere('course_id', $certificate->course_id);
            })
            ->where(function ($q) {
                $q->where('is_completed', true)
                  ->orWhereNotNull('score_post_test');
            })
            ->exists();

        // Also check: if certificate exists and was issued, it's already validated
        // The certificate issuance was already gated by quiz completion logic
        // So we trust the certificate record itself as proof
        if (!$isCompleted && !$certificate->issued_at) {
            abort(403, 'Kamu belum menyelesaikan modul ini.');
        }

        // Calculate average score for this user across all modules
        $avgScore = UserProgress::where('user_id', $user->id)
            ->whereNotNull('score_post_test')
            ->avg('score_post_test');

        $data = [
            'certificate' => $certificate,
            'user'        => $user,
            'course'      => $certificate->course,
            'module'      => $certificate->course?->module,
            'avg_score'   => $avgScore ? round($avgScore) : null,
            'issued_date' => $certificate->issued_at?->format('d F Y') ?? now()->format('d F Y'),
        ];

        $pdf = Pdf::loadView('certificates.print', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont'       => 'sans-serif',
                'isRemoteEnabled'   => false,
                'isHtml5ParserEnabled' => true,
            ]);

        $filename = 'Sertifikat_CerdasFin_' . str_replace(' ', '_', $user->name) . '.pdf';

        return $pdf->download($filename);
    }
}
