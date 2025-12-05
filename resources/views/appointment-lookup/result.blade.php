@extends('layouts.app')

@section('title', 'Thông Tin Lịch Hẹn')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2><i class="fas fa-calendar-check text-primary me-2"></i>Thông Tin Lịch Hẹn</h2>
                <p class="text-muted">Mã lịch hẹn: <strong>#{{ $appointment->id }}</strong></p>
            </div>

            <!-- Trạng thái -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    @if($appointment->status == 'pending')
                        <div class="badge bg-warning fs-5 px-4 py-2">
                            <i class="fas fa-clock me-2"></i>Chờ Xác Nhận
                        </div>
                        <p class="text-muted mt-3 mb-0">Lịch hẹn của bạn đang được phòng khám xem xét.</p>
                    @elseif($appointment->status == 'confirmed')
                        <div class="badge bg-success fs-5 px-4 py-2">
                            <i class="fas fa-check-circle me-2"></i>Đã Xác Nhận
                        </div>
                        <p class="text-success mt-3 mb-0 fw-bold">Lịch hẹn đã được xác nhận. Vui lòng đến đúng giờ!</p>
                    @elseif($appointment->status == 'completed')
                        <div class="badge bg-primary fs-5 px-4 py-2">
                            <i class="fas fa-clipboard-check me-2"></i>Đã Hoàn Thành
                        </div>
                        <p class="text-muted mt-3 mb-0">Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
                    @else
                        <div class="badge bg-danger fs-5 px-4 py-2">
                            <i class="fas fa-times-circle me-2"></i>Đã Hủy
                        </div>
                        <p class="text-danger mt-3 mb-0">Lịch hẹn này đã bị hủy.</p>
                    @endif
                </div>
            </div>

            <!-- Thông tin bệnh nhân -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông Tin Bệnh Nhân</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Họ và Tên</label>
                            <p class="fw-bold mb-0">{{ $appointment->patient_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Số Điện Thoại</label>
                            <p class="fw-bold mb-0">{{ $appointment->patient_phone }}</p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small">Email</label>
                            <p class="fw-bold mb-0">{{ $appointment->patient_email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin bác sĩ -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user-md me-2"></i>Thông Tin Bác Sĩ</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if($appointment->doctor->avatar)
                                <img src="{{ asset('storage/' . $appointment->doctor->avatar) }}" 
                                     alt="{{ $appointment->doctor->name }}" 
                                     class="rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-user-md fa-2x text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <h5 class="mb-1">{{ $appointment->doctor->name }}</h5>
                            <p class="text-muted mb-1">
                                <i class="fas fa-stethoscope me-1"></i>
                                {{ $appointment->doctor->specialty->name }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-1"></i>{{ $appointment->doctor->phone }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin lịch hẹn -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Thời Gian Khám</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Ngày Khám</label>
                            <p class="fw-bold fs-5 mb-0">
                                <i class="fas fa-calendar-day text-success me-2"></i>
                                {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Giờ Khám</label>
                            <p class="fw-bold fs-5 mb-0">
                                <i class="fas fa-clock text-success me-2"></i>
                                {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    @if($appointment->note)
                        <div class="mt-3 pt-3 border-top">
                            <label class="text-muted small">Triệu Chứng / Ghi Chú</label>
                            <p class="mb-0">{{ $appointment->note }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-3 justify-content-center mb-4">
                <a href="{{ route('appointment.lookup') }}" class="btn btn-outline-primary">
                    <i class="fas fa-search me-2"></i>Tra Cứu Lịch Khác
                </a>
                
                @if(in_array($appointment->status, ['pending', 'confirmed']))
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        <i class="fas fa-times-circle me-2"></i>Hủy Lịch Hẹn
                    </button>
                @endif

                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home me-2"></i>Trang Chủ
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hủy Lịch -->
@if(in_array($appointment->status, ['pending', 'confirmed']))
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác Nhận Hủy Lịch
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('appointment.cancel', $appointment->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Bạn chỉ có thể hủy lịch trước 24 giờ so với giờ khám.
                    </div>
                    
                    <p>Bạn có chắc chắn muốn hủy lịch hẹn này không?</p>
                    
                    <div class="mb-3">
                        <label for="patient_phone" class="form-label">
                            Nhập lại số điện thoại để xác nhận <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="patient_phone" 
                            name="patient_phone" 
                            placeholder="Số điện thoại đã đặt lịch"
                            required
                        >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Đóng
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Xác Nhận Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
