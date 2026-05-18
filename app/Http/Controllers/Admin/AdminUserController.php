<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::with('userPoints')
            ->withCount(['progressData', 'certificates'])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load(['userPoints', 'progressData.course', 'certificates']);
        return view('admin.users.show', compact('user'));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $request->validate(['role' => 'required|in:user,mentor,admin']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
