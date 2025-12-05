@extends('admin.layouts.app')

@section('title', 'Sửa chuyên khoa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit"></i> Sửa chuyên khoa</h1>
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
                <form action="{{ route('admin.specialties.update', $specialty) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên chuyên khoa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $specialty->name) }}" 
                               placeholder="Ví dụ: Nha khoa, Tim mạch..." required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" 
                                  placeholder="Nhập mô tả về chuyên khoa...">{{ old('description', $specialty->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tối đa 1000 ký tự</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật
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
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin</h6>
            </div>
            <div class="card-body">
                <p class="mb-2 small"><strong>Ngày tạo:</strong> {{ $specialty->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0 small"><strong>Cập nhật:</strong> {{ $specialty->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Lưu ý</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0 small">
                    <li>Tên chuyên khoa phải là duy nhất</li>
                    <li>Không thể xóa nếu đang có bác sĩ</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
