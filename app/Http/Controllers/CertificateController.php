<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\View\View;
use Illuminate\Http\Response;

class CertificateController extends Controller
{
    public function index(): View
    {
        $certificates = Certificate::where('user_id', auth()->id())
            ->with(['course.module'])
            ->orderBy('issued_at', 'desc')
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    public function show(Certificate $certificate): View
    {
        if ($certificate->user_id !== auth()->id()) abort(403);
        $certificate->load(['course.module']);
        return view('certificates.show', compact('certificate'));
    }

    public function download(Certificate $certificate): Response
    {
        if ($certificate->user_id !== auth()->id()) abort(403);
        $certificate->load(['course.module']);

        $html = view('certificates.print', [
            'certificate' => $certificate,
            'user'        => auth()->user(),
        ])->render();

        return response($html)->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="certificate-' . $certificate->certificate_number . '.html"');
    }
}
