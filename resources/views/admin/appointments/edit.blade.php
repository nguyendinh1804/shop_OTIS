@extends('admin.layouts.app')

@section('title', 'Đổi trạng thái lịch hẹn')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit"></i> Đổi trạng thái lịch hẹn</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">Thông tin lịch hẹn</h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4"><strong>Bệnh nhân:</strong></div>
                    <div class="col-sm-8">{{ $appointment->patient_name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4"><strong>Bác sĩ:</strong></div>
                    <div class="col-sm-8">{{ $appointment->doctor->name }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Thời gian:</strong></div>
                    <div class="col-sm-8">
                        {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} lúc {{ $appointment->time }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="pending" {{ old('status', $appointment->status) === 'pending' ? 'selected' : '' }}>
                                Chờ duyệt
                            </option>
                            <option value="confirmed" {{ old('status', $appointment->status) === 'confirmed' ? 'selected' : '' }}>
                                Đã duyệt
                            </option>
                            <option value="completed" {{ old('status', $appointment->status) === 'completed' ? 'selected' : '' }}>
                                Đã khám
                            </option>
                            <option value="cancelled" {{ old('status', $appointment->status) === 'cancelled' ? 'selected' : '' }}>
                                Đã hủy
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật trạng thái
                        </button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Hướng dẫn</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0 small">
                    <li><strong>Chờ duyệt:</strong> Lịch hẹn mới tạo, chưa xác nhận</li>
                    <li><strong>Đã duyệt:</strong> Đã xác nhận với bệnh nhân</li>
                    <li><strong>Đã khám:</strong> Bệnh nhân đã hoàn thành khám</li>
                    <li><strong>Đã hủy:</strong> Lịch hẹn bị hủy bởi admin hoặc bệnh nhân</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
