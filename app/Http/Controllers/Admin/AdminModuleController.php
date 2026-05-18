<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\ModuleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminModuleController extends Controller
{
    public function __construct(
        private readonly ModuleService $moduleService
    ) {}

    public function index(): View
    {
        $modules = $this->moduleService->getAll();
        return view('admin.modules.index', compact('modules'));
    }

    public function create(): View
    {
        return view('admin.modules.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'content'      => 'nullable|string',
            'youtube_link' => 'nullable|url:http,https',
            'icon'         => 'nullable|string|max:10',
            'order'        => 'nullable|integer|min:0',
            'status'       => 'required|in:draft,published',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $this->moduleService->create($validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Modul berhasil ditambahkan!');
    }

    public function edit(Module $module): View
    {
        return view('admin.modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'content'      => 'nullable|string',
            'youtube_link' => 'nullable|url:http,https',
            'icon'         => 'nullable|string|max:10',
            'order'        => 'nullable|integer|min:0',
            'status'       => 'required|in:draft,published',
        ]);

        $validated['order'] = $validated['order'] ?? $module->order;

        $this->moduleService->update($module, $validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Modul berhasil diperbarui!');
    }

    public function destroy(Module $module): RedirectResponse
    {
        $this->moduleService->delete($module);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Modul berhasil dihapus!');
    }
}
