<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentLookupController extends Controller
{
    /**
     * Hiển thị form tra cứu
     */
    public function index(): View
    {
        return view('appointment-lookup.index');
    }

    /**
     * Tìm kiếm lịch hẹn
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'booking_code' => 'required|numeric',
            'patient_phone' => 'required|string|max:20',
        ], [
            'booking_code.required' => 'Vui lòng nhập mã lịch hẹn.',
            'booking_code.numeric' => 'Mã lịch hẹn phải là số.',
            'patient_phone.required' => 'Vui lòng nhập số điện thoại.',
        ]);

        $appointment = Appointment::with('doctor.specialty')
            ->where('id', $validated['booking_code'])
            ->where('patient_phone', $validated['patient_phone'])
            ->first();

        if (!$appointment) {
            return back()
                ->withErrors(['booking_code' => 'Không tìm thấy lịch hẹn. Vui lòng kiểm tra lại thông tin.'])
                ->withInput();
        }

        return view('appointment-lookup.result', compact('appointment'));
    }

    /**
     * Hủy lịch hẹn
     */
    public function cancel(Request $request, $id)
    {
        $validated = $request->validate([
            'patient_phone' => 'required|string|max:20',
        ], [
            'patient_phone.required' => 'Vui lòng nhập số điện thoại để xác nhận.',
        ]);

        $appointment = Appointment::where('id', $id)
            ->where('patient_phone', $validated['patient_phone'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Không thể hủy lịch hẹn này.');
        }

        // Kiểm tra thời gian hủy (phải trước 24h)
        $appointmentDateTime = \Carbon\Carbon::parse($appointment->date . ' ' . $appointment->time);
        $now = \Carbon\Carbon::now();
        
        if ($appointmentDateTime->diffInHours($now, false) < 24) {
            return back()->with('error', 'Chỉ có thể hủy lịch trước 24 giờ. Vui lòng liên hệ phòng khám để được hỗ trợ.');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointment.lookup')
            ->with('success', 'Hủy lịch hẹn thành công!');
    }
}
