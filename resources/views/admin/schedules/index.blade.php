@extends('admin.layouts.app')

@section('title', 'Quản Lý Lịch Làm Việc')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-calendar-week me-2"></i>Quản Lý Lịch Làm Việc</h2>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm Lịch Mới
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @forelse($doctors as $doctor)
                <div class="mb-4 pb-4 @if(!$loop->last) border-bottom @endif">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            @if($doctor->avatar)
                                <img src="{{ asset('storage/' . $doctor->avatar) }}" 
                                     alt="{{ $doctor->name }}" 
                                     class="rounded-circle me-3"
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user-md text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $doctor->name }}</h5>
                                <small class="text-muted">
                                    <i class="fas fa-stethoscope me-1"></i>{{ $doctor->specialty->name }}
                                </small>
                            </div>
                        </div>
                        <a href="{{ route('admin.schedules.show', $doctor->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye me-1"></i>Xem Chi Tiết
                        </a>
                    </div>

                    @if($doctor->schedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="150">Thứ</th>
                                        <th>Giờ Làm Việc</th>
                                        <th width="100">Trạng Thái</th>
                                        <th width="150" class="text-center">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctor->schedules->sortBy(function($schedule) {
                                        $order = ['monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 7];
                                        return $order[$schedule->day_of_week];
                                    }) as $schedule)
                                        <tr>
                                            <td>
                                                <strong>{{ $schedule->day_name }}</strong>
                                            </td>
                                            <td>
                                                <i class="fas fa-clock text-primary me-2"></i>
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} 
                                                - 
                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                            </td>
                                            <td>
                                                @if($schedule->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Hoạt động
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-pause me-1"></i>Tạm ngưng
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa lịch này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Bác sĩ này chưa có lịch làm việc. 
                            <a href="{{ route('admin.schedules.create') }}" class="alert-link">Thêm lịch mới</a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có bác sĩ nào trong hệ thống.</p>
                    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm Bác Sĩ
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
