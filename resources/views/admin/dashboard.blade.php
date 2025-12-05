@extends('admin.layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-calendar"></i> {{ $today->format('d/m/Y') }}
            </button>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-calendar-day fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Lịch hẹn hôm nay</h6>
                        <h3 class="mb-0">{{ $totalTodayAppointments }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Chờ duyệt</h6>
                        <h3 class="mb-0">{{ $pendingAppointments }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Đã xác nhận</h6>
                        <h3 class="mb-0">{{ $confirmedAppointments }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="fas fa-user-md fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Tổng bác sĩ</h6>
                        <h3 class="mb-0">{{ $totalDoctors }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Chào mừng đến với hệ thống quản trị</h5>
            </div>
            <div class="card-body">
                <p class="mb-2">Sử dụng menu bên trái để điều hướng đến các chức năng quản lý:</p>
                <ul class="mb-0">
                    <li><strong>Quản lý chuyên khoa:</strong> Thêm, sửa, xóa các chuyên khoa y tế</li>
                    <li><strong>Quản lý bác sĩ:</strong> Quản lý thông tin bác sĩ, chuyên môn</li>
                    <li><strong>Quản lý lịch hẹn:</strong> Xem và duyệt các lịch hẹn từ bệnh nhân</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
