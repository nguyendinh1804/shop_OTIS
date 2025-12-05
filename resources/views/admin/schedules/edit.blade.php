@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Lịch Làm Việc')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="fas fa-calendar-edit me-2"></i>Chỉnh Sửa Lịch Làm Việc</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Lịch Làm Việc</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Cập Nhật Lịch Làm Việc</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-user-md me-2"></i>
                        <strong>Bác sĩ:</strong> {{ $schedule->doctor->name }} 
                        <span class="ms-3">
                            <i class="fas fa-calendar me-1"></i>
                            <strong>Thứ:</strong> {{ $schedule->day_name }}
                        </span>
                    </div>

                    <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">
                                        Giờ Bắt Đầu <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" 
                                           class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" 
                                           name="start_time" 
                                           value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}"
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">
                                        Giờ Kết Thúc <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" 
                                           class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" 
                                           name="end_time" 
                                           value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}"
                                           required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $schedule->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Kích hoạt lịch này</strong>
                                    <small class="d-block text-muted">Bác sĩ có thể nhận lịch hẹn vào thời gian này</small>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Cập Nhật
                            </button>
                            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Lưu Ý</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0 small">
                        <li class="mb-2">Không thể thay đổi <strong>Bác sĩ</strong> và <strong>Thứ</strong></li>
                        <li class="mb-2">Chỉ có thể điều chỉnh <strong>giờ làm việc</strong></li>
                        <li class="mb-0">Nếu cần thay đổi thứ, hãy <strong>xóa</strong> lịch này và <strong>tạo lịch mới</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
