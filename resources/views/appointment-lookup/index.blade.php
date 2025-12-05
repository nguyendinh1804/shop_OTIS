@extends('layouts.app')

@section('title', 'Tra Cứu Lịch Hẹn')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-search me-2"></i>Tra Cứu Lịch Hẹn</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Vui lòng nhập <strong>Mã lịch hẹn</strong> và <strong>Số điện thoại</strong> để tra cứu thông tin lịch khám của bạn.
                    </p>

                    <form action="{{ route('appointment.search') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="booking_code" class="form-label">
                                Mã Lịch Hẹn <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('booking_code') is-invalid @enderror" 
                                id="booking_code" 
                                name="booking_code" 
                                placeholder="Ví dụ: 12345"
                                value="{{ old('booking_code') }}"
                                required
                            >
                            @error('booking_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>Mã này được gửi qua email sau khi bạn đặt lịch thành công.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="patient_phone" class="form-label">
                                Số Điện Thoại <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('patient_phone') is-invalid @enderror" 
                                id="patient_phone" 
                                name="patient_phone" 
                                placeholder="Ví dụ: 0912345678"
                                value="{{ old('patient_phone') }}"
                                required
                            >
                            @error('patient_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Tra Cứu Lịch Hẹn
                        </button>
                    </form>
                </div>
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">
                        Chưa có lịch hẹn? <a href="{{ route('booking.create') }}" class="text-decoration-none">Đặt lịch ngay</a>
                    </small>
                </div>
            </div>

            <div class="card mt-4 border-warning">
                <div class="card-body">
                    <h6 class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Lưu ý</h6>
                    <ul class="mb-0 small text-muted">
                        <li>Mã lịch hẹn được gửi qua email sau khi đặt lịch thành công</li>
                        <li>Bạn chỉ có thể hủy lịch trước 24 giờ so với giờ khám</li>
                        <li>Nếu cần thay đổi thông tin, vui lòng hủy lịch cũ và đặt lịch mới</li>
                        <li>Liên hệ hotline: <strong>1900-xxxx</strong> nếu cần hỗ trợ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
