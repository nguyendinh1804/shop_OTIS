<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with('specialty', 'schedules')->get();
        return view('admin.schedules.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::with('specialty')->get();
        $days = [
            'monday' => 'Thứ Hai',
            'tuesday' => 'Thứ Ba',
            'wednesday' => 'Thứ Tư',
            'thursday' => 'Thứ Năm',
            'friday' => 'Thứ Sáu',
            'saturday' => 'Thứ Bảy',
            'sunday' => 'Chủ Nhật',
        ];
        
        return view('admin.schedules.create', compact('doctors', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'boolean',
        ], [
            'doctor_id.required' => 'Vui lòng chọn bác sĩ.',
            'doctor_id.exists' => 'Bác sĩ không tồn tại.',
            'day_of_week.required' => 'Vui lòng chọn thứ trong tuần.',
            'day_of_week.in' => 'Thứ trong tuần không hợp lệ.',
            'start_time.required' => 'Vui lòng nhập giờ bắt đầu.',
            'start_time.date_format' => 'Giờ bắt đầu phải có định dạng HH:mm.',
            'end_time.required' => 'Vui lòng nhập giờ kết thúc.',
            'end_time.date_format' => 'Giờ kết thúc phải có định dạng HH:mm.',
            'end_time.after' => 'Giờ kết thúc phải sau giờ bắt đầu.',
        ]);

        // Kiểm tra trùng lịch
        $exists = DoctorSchedule::where('doctor_id', $validated['doctor_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'day_of_week' => 'Bác sĩ đã có lịch làm việc vào thứ này. Vui lòng chỉnh sửa lịch cũ thay vì tạo mới.'
            ])->withInput();
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        DoctorSchedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Thêm lịch làm việc thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::with(['specialty', 'schedules' => function($query) {
            $query->orderByRaw("FIELD(day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')");
        }])->findOrFail($id);
        
        return view('admin.schedules.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = DoctorSchedule::with('doctor')->findOrFail($id);
        $days = [
            'monday' => 'Thứ Hai',
            'tuesday' => 'Thứ Ba',
            'wednesday' => 'Thứ Tư',
            'thursday' => 'Thứ Năm',
            'friday' => 'Thứ Sáu',
            'saturday' => 'Thứ Bảy',
            'sunday' => 'Chủ Nhật',
        ];
        
        return view('admin.schedules.edit', compact('schedule', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = DoctorSchedule::findOrFail($id);

        $validated = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'boolean',
        ], [
            'start_time.required' => 'Vui lòng nhập giờ bắt đầu.',
            'start_time.date_format' => 'Giờ bắt đầu phải có định dạng HH:mm.',
            'end_time.required' => 'Vui lòng nhập giờ kết thúc.',
            'end_time.date_format' => 'Giờ kết thúc phải có định dạng HH:mm.',
            'end_time.after' => 'Giờ kết thúc phải sau giờ bắt đầu.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Cập nhật lịch làm việc thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Xóa lịch làm việc thành công!');
    }
}
