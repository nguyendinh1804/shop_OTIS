@extends('layouts.app')

@section('title', 'Thông Tin Cá Nhân')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    
                    @if(auth()->user()->role === 'admin')
                        <span class="badge bg-danger mb-3">
                            <i class="fas fa-crown me-1"></i>Quản trị viên
                        </span>
                    @else
                        <span class="badge bg-primary mb-3">
                            <i class="fas fa-user me-1"></i>Khách hàng
                        </span>
                    @endif
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="#editProfile" class="btn btn-outline-primary" data-bs-toggle="collapse">
                            <i class="fas fa-edit me-2"></i>Chỉnh Sửa
                        </a>
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        @endif
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Đăng Xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông Tin Cá Nhân</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Thông Tin Hiện Tại</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Họ và Tên:</strong></td>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Vai trò:</strong></td>
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                        <span class="badge bg-danger">Quản trị viên</span>
                                    @else
                                        <span class="badge bg-primary">Khách hàng</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ngày tham gia:</strong></td>
                                <td>{{ auth()->user()->created_at->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="collapse" id="editProfile">
                        <hr>
                        <h6 class="text-muted mb-3">Cập Nhật Thông Tin</h6>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Họ và Tên</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', auth()->user()->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', auth()->user()->email) }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        Mật Khẩu Mới <small class="text-muted">(Để trống nếu không đổi)</small>
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password"
                                           placeholder="Ít nhất 6 ký tự">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           placeholder="Nhập lại mật khẩu mới">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Lưu Thay Đổi
                                </button>
                                <a href="#editProfile" class="btn btn-secondary" data-bs-toggle="collapse">
                                    <i class="fas fa-times me-2"></i>Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'customer')
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Lịch Sử Đặt Lịch</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Chức năng đang được phát triển...
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
