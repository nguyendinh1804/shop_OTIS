<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Thời gian mặc định: tháng này
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // 1. Thống kê tổng quan
        $totalAppointments = Appointment::whereBetween('date', [$startDate, $endDate])->count();
        $pendingCount = Appointment::whereBetween('date', [$startDate, $endDate])->where('status', 'pending')->count();
        $confirmedCount = Appointment::whereBetween('date', [$startDate, $endDate])->where('status', 'confirmed')->count();
        $completedCount = Appointment::whereBetween('date', [$startDate, $endDate])->where('status', 'completed')->count();
        $cancelledCount = Appointment::whereBetween('date', [$startDate, $endDate])->where('status', 'cancelled')->count();

        // 2. Tỷ lệ (%)
        $completionRate = $totalAppointments > 0 ? round(($completedCount / $totalAppointments) * 100, 1) : 0;
        $cancellationRate = $totalAppointments > 0 ? round(($cancelledCount / $totalAppointments) * 100, 1) : 0;

        // 3. Top 5 Bác sĩ có nhiều lịch hẹn nhất
        $topDoctors = Doctor::withCount(['appointments' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }])
            ->with('specialty')
            ->orderBy('appointments_count', 'desc')
            ->limit(5)
            ->get();

        // 4. Thống kê theo chuyên khoa
        $specialtyStats = Specialty::with('doctors')
            ->get()
            ->map(function($specialty) use ($startDate, $endDate) {
                $appointmentsCount = Appointment::whereHas('doctor', function($query) use ($specialty) {
                    $query->where('specialty_id', $specialty->id);
                })
                ->whereBetween('date', [$startDate, $endDate])
                ->count();
                
                $specialty->appointments_count = $appointmentsCount;
                return $specialty;
            })
            ->filter(function($specialty) {
                return $specialty->appointments_count > 0;
            })
            ->sortByDesc('appointments_count');

        // 5. Lịch hẹn theo ngày (7 ngày gần nhất)
        $dailyAppointments = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = Appointment::whereDate('date', $date)->count();
            $dailyAppointments[] = [
                'date' => Carbon::parse($date)->format('d/m'),
                'count' => $count
            ];
        }

        // 6. Thống kê theo trạng thái (để vẽ biểu đồ tròn)
        $statusData = [
            ['label' => 'Chờ duyệt', 'count' => $pendingCount, 'color' => '#ffc107'],
            ['label' => 'Đã xác nhận', 'count' => $confirmedCount, 'color' => '#28a745'],
            ['label' => 'Đã hoàn thành', 'count' => $completedCount, 'color' => '#007bff'],
            ['label' => 'Đã hủy', 'count' => $cancelledCount, 'color' => '#dc3545'],
        ];

        // 7. Giờ đặt lịch phổ biến nhất
        $popularTimes = Appointment::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('time, COUNT(*) as count')
            ->groupBy('time')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'totalAppointments',
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount',
            'completionRate',
            'cancellationRate',
            'topDoctors',
            'specialtyStats',
            'dailyAppointments',
            'statusData',
            'popularTimes',
            'startDate',
            'endDate'
        ));
    }
}
