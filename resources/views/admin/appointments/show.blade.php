@extends('admin.layouts.app')

@section('title', 'Chi tiết lịch hẹn')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-info-circle"></i> Chi tiết lịch hẹn #{{ $appointment->id }}</h1>
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
                <h5 class="mb-0"><i class="fas fa-user"></i> Thông tin bệnh nhân</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Họ tên:</strong></div>
                    <div class="col-sm-8">{{ $appointment->patient_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Số điện thoại:</strong></div>
                    <div class="col-sm-8"><i class="fas fa-phone"></i> {{ $appointment->patient_phone }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Email:</strong></div>
                    <div class="col-sm-8">
                        @if($appointment->patient_email)
                            <i class="fas fa-envelope"></i> {{ $appointment->patient_email }}
                        @else
                            <span class="text-muted">Không có</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Ghi chú / Triệu chứng:</strong></div>
                    <div class="col-sm-8">
                        @if($appointment->note)
                            {{ $appointment->note }}
                        @else
                            <span class="text-muted">Không có</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-user-md"></i> Thông tin bác sĩ & lịch khám</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Bác sĩ:</strong></div>
                    <div class="col-sm-8">{{ $appointment->doctor->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Chuyên khoa:</strong></div>
                    <div class="col-sm-8"><span class="badge bg-info">{{ $appointment->doctor->specialty->name }}</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Ngày khám:</strong></div>
                    <div class="col-sm-8">
                        <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($appointment->date)->locale('vi')->isoFormat('dddd') }})
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Giờ khám:</strong></div>
                    <div class="col-sm-8"><i class="fas fa-clock"></i> {{ $appointment->time }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Trạng thái</h6>
            </div>
            <div class="card-body text-center">
                @if($appointment->status === 'pending')
                    <span class="badge bg-warning text-dark fs-5">Chờ duyệt</span>
                @elseif($appointment->status === 'confirmed')
                    <span class="badge bg-success fs-5">Đã duyệt</span>
                @elseif($appointment->status === 'completed')
                    <span class="badge bg-info fs-5">Đã khám</span>
                @else
                    <span class="badge bg-secondary fs-5">Đã hủy</span>
                @endif
                <hr>
                <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Đổi trạng thái
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-clock"></i> Thời gian</h6>
            </div>
            <div class="card-body">
                <p class="mb-2 small"><strong>Đặt lúc:</strong><br>{{ $appointment->created_at->format('d/m/Y H:i:s') }}</p>
                <p class="mb-0 small"><strong>Cập nhật:</strong><br>{{ $appointment->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
