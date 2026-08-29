<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeManagerController extends Controller
{
    public function index()
    {
        $sections = HomeContent::ordered()->get()->groupBy('section');
        return view('home_manager.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section'     => 'required|string|max:50',
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'content'     => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'order_index' => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = Auth::id();

        $content = HomeContent::create($validated);

        ActivityLogService::log(
            'create_home_content',
            'home_manager',
            "Konten landing page section '{$content->section}' ditambahkan",
            $content->id
        );

        return back()->with('success', 'Konten landing page berhasil ditambahkan.');
    }

    public function update(Request $request, HomeContent $homeContent)
    {
        $validated = $request->validate([
            'section'     => 'required|string|max:50',
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'content'     => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'order_index' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = Auth::id();

        $homeContent->update($validated);

        ActivityLogService::log(
            'update_home_content',
            'home_manager',
            "Konten landing page ID #{$homeContent->id} ({$homeContent->section}) diperbarui",
            $homeContent->id
        );

        return back()->with('success', 'Konten landing page berhasil diperbarui.');
    }

    public function destroy(HomeContent $homeContent)
    {
        $id = $homeContent->id;
        $section = $homeContent->section;

        $homeContent->delete();

        ActivityLogService::log('delete_home_content', 'home_manager', "Konten landing page ID #{$id} ({$section}) dihapus", $id);

        return back()->with('success', 'Konten landing page berhasil dihapus.');
    }

    public function toggleActive(HomeContent $homeContent)
    {
        $homeContent->is_active = !$homeContent->is_active;
        $homeContent->updated_by = Auth::id();
        $homeContent->save();

        $status = $homeContent->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLogService::log('toggle_home_content', 'home_manager', "Konten landing page ID #{$homeContent->id} {$status}", $homeContent->id);

        return back()->with('success', "Konten berhasil {$status}.");
    }
}
