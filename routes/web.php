<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\AwarenessController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminModuleController;
use Illuminate\Support\Facades\Route;

// ============================================================
// PUBLIC ROUTES
// ============================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

// Courses (read-only - public)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Modules (public listing)
Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');

// Awareness Page (public)
Route::get('/awareness', [AwarenessController::class, 'index'])->name('awareness.index');

// Forum (read-only public)
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/{category:slug}', [ForumController::class, 'category'])->name('forum.category');
Route::get('/forum/{category:slug}/{post:slug}', [ForumController::class, 'show'])->name('forum.post');

// ============================================================
// AUTHENTICATED ROUTES
// ============================================================

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Lessons (protected)
    Route::get('/courses/{course}/lessons/{lesson}', [CourseController::class, 'lesson'])->name('courses.lesson');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [CourseController::class, 'completeLesson'])->name('courses.lesson.complete');

    // Quizzes (protected)
    Route::get('/courses/{course}/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/courses/{course}/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/courses/{course}/quizzes/{quiz}/result', [QuizController::class, 'result'])->name('quizzes.result');

    // Pre-test / Post-test
    Route::get('/modules/{module}/pre-test', [QuizController::class, 'preTest'])->name('modules.pre-test');
    Route::post('/modules/{module}/pre-test/submit', [QuizController::class, 'submitPreTest'])->name('modules.pre-test.submit');
    Route::get('/modules/{module}/post-test', [QuizController::class, 'postTest'])->name('modules.post-test');
    Route::post('/modules/{module}/post-test/submit', [QuizController::class, 'submitPostTest'])->name('modules.post-test.submit');

    // Forum (write - protected)
    Route::get('/forum/{category:slug}/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum/{category:slug}', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/{category:slug}/{post:slug}/comment', [ForumController::class, 'comment'])->name('forum.comment');

    // Certificates
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
});

// Simulation (public - no auth required so guests can try)
Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation.index');
Route::post('/simulation/pinjol', [SimulationController::class, 'pinjol'])->name('simulation.pinjol');
Route::post('/simulation/investment', [SimulationController::class, 'investment'])->name('simulation.investment');
Route::post('/simulation/budget', [SimulationController::class, 'budget'])->name('simulation.budget');

// Tools (Financial Calculators - public)
Route::get('/tools/mortgage', [ToolController::class, 'mortgage'])->name('tools.mortgage');
Route::get('/tools/savings', [ToolController::class, 'savings'])->name('tools.savings');
Route::get('/tools/investment', [ToolController::class, 'investment'])->name('tools.investment');
Route::get('/tools/budget', [ToolController::class, 'budget'])->name('tools.budget');

// ============================================================
// ADMIN ROUTES
// ============================================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/modules', [AdminModuleController::class, 'index'])->name('modules.index');
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
});

require __DIR__.'/auth.php';
