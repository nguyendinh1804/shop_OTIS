<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Hiển thị thống kê tổng quan cho quản trị viên.
     */
    public function __invoke(): View
    {
        $today = Carbon::today();

        $totalTodayAppointments = Appointment::query()
            ->whereDate('date', $today)
            ->count();

        $pendingAppointments = Appointment::query()
            ->where('status', 'pending')
            ->count();

        $confirmedAppointments = Appointment::query()
            ->where('status', 'confirmed')
            ->count();

        $totalDoctors = Doctor::query()->count();

        return view('admin.dashboard', [
            'today' => $today,
            'totalTodayAppointments' => $totalTodayAppointments,
            'pendingAppointments' => $pendingAppointments,
            'confirmedAppointments' => $confirmedAppointments,
            'totalDoctors' => $totalDoctors,
        ]);
    }
}
