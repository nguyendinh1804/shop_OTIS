@extends('layouts.app')

@section('title', 'Đặt lịch thành công')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-check fa-3x text-white"></i>
                        </div>
                    </div>
                    
                    <h2 class="text-success mb-3">Đặt lịch thành công!</h2>
                    <p class="lead mb-4">Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi.</p>
                    
                    <div class="alert alert-info text-start">
                        <h5 class="alert-heading"><i class="fas fa-info-circle"></i> Thông tin lịch hẹn</h5>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Mã lịch hẹn:</strong></div>
                            <div class="col-sm-7">#{{ $appointment->id }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Bệnh nhân:</strong></div>
                            <div class="col-sm-7">{{ $appointment->patient_name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Số điện thoại:</strong></div>
                            <div class="col-sm-7">{{ $appointment->patient_phone }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Bác sĩ:</strong></div>
                            <div class="col-sm-7">{{ $appointment->doctor->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Chuyên khoa:</strong></div>
                            <div class="col-sm-7">{{ $appointment->doctor->specialty->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Ngày khám:</strong></div>
                            <div class="col-sm-7">
                                <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><strong>Giờ khám:</strong></div>
                            <div class="col-sm-7">
                                <i class="fas fa-clock"></i> {{ $appointment->time }}
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning text-start">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Lưu ý quan trọng</h6>
                        <ul class="mb-0 small">
                            <li>Vui lòng đến <strong>trước 15 phút</strong> so với giờ hẹn để làm thủ tục</li>
                            <li>Mang theo <strong>CMND/CCCD</strong> và <strong>sổ khám bệnh</strong> (nếu có)</li>
                            <li>Nếu cần hủy hoặc thay đổi lịch, vui lòng liên hệ: <strong>1900 xxxx</strong></li>
                            <li>Trạng thái hiện tại: <span class="badge bg-warning text-dark">Chờ xác nhận</span></li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Về trang chủ
                        </a>
                        <a href="{{ route('booking.create') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-calendar-plus"></i> Đặt lịch khác
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
