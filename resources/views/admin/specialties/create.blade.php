@extends('admin.layouts.app')

@section('title', 'Thêm chuyên khoa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-plus-circle"></i> Thêm chuyên khoa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.specialties.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.specialties.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên chuyên khoa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Ví dụ: Nha khoa, Tim mạch..." required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" 
                                  placeholder="Nhập mô tả về chuyên khoa...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tối đa 1000 ký tự</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu chuyên khoa
                        </button>
                        <a href="{{ route('admin.specialties.index') }}" class="btn btn-secondary">
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
                    <li>Tên chuyên khoa phải là duy nhất</li>
                    <li>Trường có dấu <span class="text-danger">*</span> là bắt buộc</li>
                    <li>Mô tả giúp bệnh nhân hiểu rõ hơn về chuyên khoa</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
