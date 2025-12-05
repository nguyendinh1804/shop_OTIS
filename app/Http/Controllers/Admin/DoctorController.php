<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Doctor::with('specialty');

        // Lọc theo chuyên khoa
        if ($request->filled('specialty_id')) {
            $query->where('specialty_id', $request->specialty_id);
        }

        // Tìm kiếm theo tên hoặc số điện thoại
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $doctors = $query->latest()->paginate(10);
        $specialties = Specialty::all();

        return view('admin.doctors.index', compact('doctors', 'specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $specialties = Specialty::all();
        return view('admin.doctors.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:doctors,phone',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'specialty_id.required' => 'Vui lòng chọn chuyên khoa.',
            'specialty_id.exists' => 'Chuyên khoa không tồn tại.',
            'name.required' => 'Tên bác sĩ là bắt buộc.',
            'name.max' => 'Tên bác sĩ không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'bio.max' => 'Tiểu sử không được vượt quá 1000 ký tự.',
            'avatar.image' => 'Ảnh đại diện phải là file hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng: jpeg, png, jpg.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('doctors', 'public');
        }

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Thêm bác sĩ thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor): View
    {
        $doctor->load('specialty', 'appointments');
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor): View
    {
        $specialties = Specialty::all();
        return view('admin.doctors.edit', compact('doctor', 'specialties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:doctors,phone,' . $doctor->id,
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'specialty_id.required' => 'Vui lòng chọn chuyên khoa.',
            'specialty_id.exists' => 'Chuyên khoa không tồn tại.',
            'name.required' => 'Tên bác sĩ là bắt buộc.',
            'name.max' => 'Tên bác sĩ không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'bio.max' => 'Tiểu sử không được vượt quá 1000 ký tự.',
            'avatar.image' => 'Ảnh đại diện phải là file hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng: jpeg, png, jpg.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ]);

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($doctor->avatar && Storage::disk('public')->exists($doctor->avatar)) {
                Storage::disk('public')->delete($doctor->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('doctors', 'public');
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Cập nhật bác sĩ thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor): RedirectResponse
    {
        if ($doctor->appointments()->count() > 0) {
            return redirect()->route('admin.doctors.index')
                ->with('error', 'Không thể xóa bác sĩ đang có lịch hẹn!');
        }

        // Xóa ảnh nếu có
        if ($doctor->avatar && Storage::disk('public')->exists($doctor->avatar)) {
            Storage::disk('public')->delete($doctor->avatar);
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Xóa bác sĩ thành công!');
    }
}
