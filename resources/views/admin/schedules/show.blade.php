@extends('admin.layouts.app')

@section('title', 'Chi Tiết Lịch Làm Việc')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="fas fa-calendar-check me-2"></i>Lịch Làm Việc Chi Tiết</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Lịch Làm Việc</a></li>
                <li class="breadcrumb-item active">{{ $doctor->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-md me-2"></i>Thông Tin Bác Sĩ</h5>
                </div>
                <div class="card-body text-center">
                    @if($doctor->avatar)
                        <img src="{{ asset('storage/' . $doctor->avatar) }}" 
                             alt="{{ $doctor->name }}" 
                             class="rounded-circle mb-3"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user-md fa-3x text-white"></i>
                        </div>
                    @endif
                    
                    <h4 class="mb-2">{{ $doctor->name }}</h4>
                    <p class="text-muted mb-3">
                        <i class="fas fa-stethoscope me-2"></i>{{ $doctor->specialty->name }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-phone me-2"></i>{{ $doctor->phone }}
                    </p>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body text-center">
                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-plus me-2"></i>Thêm Lịch Mới
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i>Quay Lại
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Lịch Làm Việc Trong Tuần</h5>
                </div>
                <div class="card-body">
                    @if($doctor->schedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="30">#</th>
                                        <th>Thứ Trong Tuần</th>
                                        <th>Giờ Làm Việc</th>
                                        <th width="120">Trạng Thái</th>
                                        <th width="150" class="text-center">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctor->schedules as $index => $schedule)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong class="text-primary">
                                                    <i class="fas fa-calendar-day me-2"></i>{{ $schedule->day_name }}
                                                </strong>
                                            </td>
                                            <td>
                                                <i class="fas fa-clock text-success me-2"></i>
                                                <strong>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</strong>
                                                <span class="mx-2">-</span>
                                                <strong>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</strong>
                                                
                                                @php
                                                    $start = \Carbon\Carbon::parse($schedule->start_time);
                                                    $end = \Carbon\Carbon::parse($schedule->end_time);
                                                    $duration = $start->diffInHours($end);
                                                @endphp
                                                
                                                <small class="text-muted ms-2">({{ $duration }} giờ)</small>
                                            </td>
                                            <td>
                                                @if($schedule->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Hoạt động
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-pause-circle me-1"></i>Tạm ngưng
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.schedules.edit', $schedule->id) }}" 
                                                       class="btn btn-warning"
                                                       title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Bạn có chắc muốn xóa lịch làm việc này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger"
                                                                title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded">
                            <h6><i class="fas fa-chart-bar me-2"></i>Thống Kê</h6>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="border-end">
                                        <h3 class="text-primary mb-0">{{ $doctor->schedules->count() }}</h3>
                                        <small class="text-muted">Tổng số ngày</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border-end">
                                        <h3 class="text-success mb-0">{{ $doctor->schedules->where('is_active', 1)->count() }}</h3>
                                        <small class="text-muted">Đang hoạt động</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="text-warning mb-0">
                                        @php
                                            $totalHours = 0;
                                            foreach($doctor->schedules as $s) {
                                                $start = \Carbon\Carbon::parse($s->start_time);
                                                $end = \Carbon\Carbon::parse($s->end_time);
                                                $totalHours += $start->diffInHours($end);
                                            }
                                        @endphp
                                        {{ $totalHours }}h
                                    </h3>
                                    <small class="text-muted">Tổng giờ/tuần</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có lịch làm việc</h5>
                            <p class="text-muted">Bác sĩ này chưa có lịch làm việc nào được thiết lập.</p>
                            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Thêm Lịch Làm Việc
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
