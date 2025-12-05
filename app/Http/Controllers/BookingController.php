<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Hiển thị form đặt lịch
     */
    public function create(Request $request): View
    {
        $doctors = Doctor::with('specialty')->get();
        $selectedDoctorId = $request->get('doctor_id');

        return view('booking.create', compact('doctors', 'selectedDoctorId'));
    }

    /**
     * Lưu lịch hẹn mới
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

        // Kiểm tra trùng lịch (Core Logic)
        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'Khung giờ này bác sĩ đã bận, vui lòng chọn giờ khác!'])->withInput();
        }

        // Thêm user_id vào dữ liệu
        $validated['user_id'] = auth()->id();

        // Nếu không trùng thì lưu vào DB
        $appointment = Appointment::create($validated);

        return redirect()->route('booking.success', $appointment->id)
            ->with('success', 'Đặt lịch thành công!');
    }

    /**
     * Hiển thị trang thành công
     */
    public function success($id): View
    {
        $appointment = Appointment::with('doctor.specialty')->findOrFail($id);
        return view('booking.success', compact('appointment'));
    }
}
