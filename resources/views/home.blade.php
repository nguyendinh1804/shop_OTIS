@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Chào mừng đến với Phòng khám OTIS</h1>
        <p class="lead mb-4">Đặt lịch khám bệnh dễ dàng, nhanh chóng với đội ngũ bác sĩ chuyên nghiệp</p>
        @auth
            <a href="{{ route('booking.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-calendar-plus"></i> Đặt lịch ngay
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập để đặt lịch
            </a>
        @endauth
    </div>
</section>

<div class="container py-5">
    <section class="mb-5">
        <h2 class="text-center mb-4">Chuyên khoa của chúng tôi</h2>
        <div class="row g-3 justify-content-center">
            @foreach($specialties as $specialty)
            <div class="col-auto">
                <a href="{{ route('home', ['specialty_id' => $specialty->id]) }}" 
                   class="btn btn-outline-primary specialty-badge">
                    <i class="fas fa-stethoscope"></i> {{ $specialty->name }}
                    <span class="badge bg-primary ms-1">{{ $specialty->doctors_count }}</span>
                </a>
            </div>
            @endforeach
            @if(request('specialty_id'))
            <div class="col-auto">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> Xóa bộ lọc
                </a>
            </div>
            @endif
        </div>
    </section>

    <section>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                @if(request('specialty_id'))
                    Bác sĩ chuyên khoa {{ $specialties->firstWhere('id', request('specialty_id'))->name ?? '' }}
                @else
                    Đội ngũ bác sĩ
                @endif
            </h2>
            <form action="{{ route('home') }}" method="GET" class="d-flex">
                @if(request('specialty_id'))
                    <input type="hidden" name="specialty_id" value="{{ request('specialty_id') }}">
                @endif
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Tìm theo tên bác sĩ..." 
                       value="{{ request('search') }}" style="width: 300px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        @if($doctors->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                <p class="text-muted">Không tìm thấy bác sĩ phù hợp.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Xem tất cả</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($doctors as $doctor)
                <div class="col-md-6 col-lg-4">
                    <div class="card doctor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            @if($doctor->avatar)
                                <img src="{{ asset('storage/' . $doctor->avatar) }}" 
                                     alt="{{ $doctor->name }}" 
                                     class="rounded-circle mb-3" 
                                     width="100" height="100" 
                                     style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user-md fa-3x text-primary"></i>
                                </div>
                            @endif
                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            <p class="text-muted mb-2">
                                <span class="badge bg-info">{{ $doctor->specialty->name }}</span>
                            </p>
                            <p class="card-text small text-muted">
                                {{ Str::limit($doctor->bio, 100) }}
                            </p>
                            <p class="small mb-3">
                                <i class="fas fa-phone text-primary"></i> {{ $doctor->phone }}
                            </p>
                            @auth
                                <a href="{{ route('booking.create', ['doctor_id' => $doctor->id]) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-calendar-plus"></i> Đặt lịch
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-sign-in-alt"></i> Đăng nhập để đặt lịch
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $doctors->links() }}
            </div>
        @endif
    </section>
</div>
@endsection
