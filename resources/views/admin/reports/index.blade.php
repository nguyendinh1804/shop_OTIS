@extends('admin.layouts.app')

@section('title', 'Báo Cáo & Thống Kê')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chart-line me-2"></i>Báo Cáo & Thống Kê</h2>
    </div>

    <!-- Bộ lọc thời gian -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Từ Ngày</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Đến Ngày</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-2"></i>Lọc
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Tổng Lịch Hẹn</h6>
                            <h2 class="mb-0">{{ $totalAppointments }}</h2>
                        </div>
                        <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Chờ Duyệt</h6>
                            <h2 class="mb-0">{{ $pendingCount }}</h2>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Đã Hoàn Thành</h6>
                            <h2 class="mb-0">{{ $completedCount }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Đã Hủy</h6>
                            <h2 class="mb-0">{{ $cancelledCount }}</h2>
                        </div>
                        <i class="fas fa-times-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tỷ lệ hoàn thành và hủy -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-percentage me-2"></i>Tỷ Lệ Hoàn Thành</h5>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-success mb-0">{{ $completionRate }}%</h1>
                    <p class="text-muted">{{ $completedCount }}/{{ $totalAppointments }} lịch hẹn</p>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $completionRate }}%">
                            {{ $completionRate }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-percentage me-2"></i>Tỷ Lệ Hủy</h5>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-danger mb-0">{{ $cancellationRate }}%</h1>
                    <p class="text-muted">{{ $cancelledCount }}/{{ $totalAppointments }} lịch hẹn</p>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $cancellationRate }}%">
                            {{ $cancellationRate }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 Bác sĩ và Lịch hẹn 7 ngày -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Top 5 Bác Sĩ Nhiều Lịch Nhất</h5>
                </div>
                <div class="card-body">
                    @if($topDoctors->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Bác Sĩ</th>
                                        <th>Chuyên Khoa</th>
                                        <th width="100" class="text-center">Số Lịch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topDoctors as $index => $doctor)
                                        <tr>
                                            <td>
                                                @if($index == 0)
                                                    <i class="fas fa-trophy text-warning"></i>
                                                @elseif($index == 1)
                                                    <i class="fas fa-medal text-secondary"></i>
                                                @elseif($index == 2)
                                                    <i class="fas fa-award text-danger"></i>
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $doctor->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $doctor->specialty->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success fs-6">{{ $doctor->appointments_count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Chưa có dữ liệu</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Lịch Hẹn 7 Ngày Gần Nhất</h5>
                </div>
                <div class="card-body">
                    <canvas id="dailyChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê theo chuyên khoa -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Thống Kê Theo Chuyên Khoa</h5>
                </div>
                <div class="card-body">
                    @if($specialtyStats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Chuyên Khoa</th>
                                        <th width="200">Số Lượng Lịch Hẹn</th>
                                        <th width="300">Tỷ Lệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($specialtyStats as $specialty)
                                        @php
                                            $percentage = $totalAppointments > 0 ? round(($specialty->appointments_count / $totalAppointments) * 100, 1) : 0;
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $specialty->name }}</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ $specialty->appointments_count }} lịch</span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-info" 
                                                         role="progressbar" 
                                                         style="width: {{ $percentage }}%">
                                                        {{ $percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Chưa có dữ liệu</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Giờ đặt lịch phổ biến -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Giờ Đặt Lịch Phổ Biến</h5>
                </div>
                <div class="card-body">
                    @if($popularTimes->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($popularTimes as $time)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ \Carbon\Carbon::parse($time->time)->format('H:i') }}</strong>
                                    <span class="badge bg-warning text-dark">{{ $time->count }} lượt</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center mb-0">Chưa có dữ liệu</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Phân Bố Trạng Thái</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ cột - Lịch hẹn 7 ngày
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    const dailyChart = new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($dailyAppointments, 'date')) !!},
            datasets: [{
                label: 'Số Lịch Hẹn',
                data: {!! json_encode(array_column($dailyAppointments, 'count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Biểu đồ tròn - Trạng thái
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_column($statusData, 'label')) !!},
            datasets: [{
                data: {!! json_encode(array_column($statusData, 'count')) !!},
                backgroundColor: {!! json_encode(array_column($statusData, 'color')) !!},
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
@endsection
