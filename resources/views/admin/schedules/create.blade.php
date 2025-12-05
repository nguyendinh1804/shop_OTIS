@extends('admin.layouts.app')

@section('title', 'Thêm Lịch Làm Việc')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="fas fa-calendar-plus me-2"></i>Thêm Lịch Làm Việc</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Lịch Làm Việc</a></li>
                <li class="breadcrumb-item active">Thêm Mới</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông Tin Lịch Làm Việc</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">
                                Bác Sĩ <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                    id="doctor_id" 
                                    name="doctor_id" 
                                    required>
                                <option value="">-- Chọn Bác Sĩ --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} - {{ $doctor->specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="day_of_week" class="form-label">
                                Thứ Trong Tuần <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('day_of_week') is-invalid @enderror" 
                                    id="day_of_week" 
                                    name="day_of_week" 
                                    required>
                                <option value="">-- Chọn Thứ --</option>
                                @foreach($days as $key => $value)
                                    <option value="{{ $key }}" {{ old('day_of_week') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('day_of_week')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                                           value="{{ old('start_time') }}"
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
                                           value="{{ old('end_time') }}"
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
                                       {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Kích hoạt lịch này</strong>
                                    <small class="d-block text-muted">Bác sĩ có thể nhận lịch hẹn vào thời gian này</small>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu Lịch
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
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Hướng Dẫn</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0 small">
                        <li class="mb-2">Mỗi bác sĩ chỉ có thể có <strong>1 lịch làm việc</strong> cho mỗi thứ trong tuần</li>
                        <li class="mb-2">Giờ kết thúc phải <strong>sau giờ bắt đầu</strong></li>
                        <li class="mb-2">Nếu tắt trạng thái "Kích hoạt", bệnh nhân sẽ <strong>không thể đặt lịch</strong> vào thời gian này</li>
                        <li class="mb-0">Ví dụ: Bác sĩ A làm việc <strong>Thứ 2</strong> từ <strong>08:00 - 17:00</strong></li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-warning mt-3">
                <div class="card-header bg-warning">
                    <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Gợi Ý</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Khung giờ phổ biến:</strong></p>
                    <ul class="small mb-0">
                        <li>Ca sáng: 08:00 - 12:00</li>
                        <li>Ca chiều: 13:00 - 17:00</li>
                        <li>Ca tối: 18:00 - 21:00</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
