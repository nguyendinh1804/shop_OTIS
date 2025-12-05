<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Appointment::with('doctor.specialty');

        // Lọc theo bác sĩ
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Tìm kiếm theo tên hoặc số điện thoại bệnh nhân
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_phone', 'like', "%{$search}%");
            });
        }

        $appointments = $query->latest()->paginate(15);
        $doctors = Doctor::all();

        return view('admin.appointments.index', compact('appointments', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $doctors = Doctor::with('specialty')->get();
        return view('admin.appointments.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'note' => 'nullable|string|max:1000',
        ], [
            'doctor_id.required' => 'Vui lòng chọn bác sĩ.',
            'doctor_id.exists' => 'Bác sĩ không tồn tại.',
            'patient_name.required' => 'Tên bệnh nhân là bắt buộc.',
            'patient_name.max' => 'Tên bệnh nhân không được vượt quá 255 ký tự.',
            'patient_phone.required' => 'Số điện thoại là bắt buộc.',
            'patient_phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'patient_email.email' => 'Email không đúng định dạng.',
            'date.required' => 'Ngày khám là bắt buộc.',
            'date.after_or_equal' => 'Ngày khám phải là hôm nay hoặc sau hôm nay.',
            'time.required' => 'Giờ khám là bắt buộc.',
            'note.max' => 'Ghi chú không được vượt quá 1000 ký tự.',
        ]);

        // Kiểm tra trùng lịch
        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'Khung giờ này bác sĩ đã bận, vui lòng chọn giờ khác!'])->withInput();
        }

        Appointment::create($validated);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Tạo lịch hẹn thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): View
    {
        $appointment->load('doctor.specialty');
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment): View
    {
        $doctors = Doctor::with('specialty')->get();
        return view('admin.appointments.edit', compact('appointment', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ], [
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Xóa lịch hẹn thành công!');
    }
}
