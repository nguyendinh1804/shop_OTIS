<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $specialties = Specialty::withCount('doctors')->latest()->paginate(10);
        
        return view('admin.specialties.index', compact('specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.specialties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:specialties,name',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Tên chuyên khoa là bắt buộc.',
            'name.unique' => 'Tên chuyên khoa đã tồn tại.',
            'name.max' => 'Tên chuyên khoa không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
        ]);

        Specialty::create($validated);

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Thêm chuyên khoa thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty): View
    {
        $specialty->loadCount('doctors');
        
        return view('admin.specialties.show', compact('specialty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty): View
    {
        return view('admin.specialties.edit', compact('specialty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialty $specialty): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:specialties,name,' . $specialty->id,
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Tên chuyên khoa là bắt buộc.',
            'name.unique' => 'Tên chuyên khoa đã tồn tại.',
            'name.max' => 'Tên chuyên khoa không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
        ]);

        $specialty->update($validated);

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Cập nhật chuyên khoa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty): RedirectResponse
    {
        if ($specialty->doctors()->count() > 0) {
            return redirect()->route('admin.specialties.index')
                ->with('error', 'Không thể xóa chuyên khoa đang có bác sĩ!');
        }

        $specialty->delete();

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Xóa chuyên khoa thành công!');
    }
}
