@extends('admin.layouts.app')

@section('title', 'Thêm bác sĩ')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-plus-circle"></i> Thêm bác sĩ</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="specialty_id" class="form-label">Chuyên khoa <span class="text-danger">*</span></label>
                        <select class="form-select @error('specialty_id') is-invalid @enderror" 
                                id="specialty_id" name="specialty_id" required>
                            <option value="">-- Chọn chuyên khoa --</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                    {{ $specialty->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên bác sĩ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Ví dụ: BS. Nguyễn Văn A" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" 
                               placeholder="Ví dụ: 0901234567" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Tiểu sử / Kinh nghiệm</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="5" 
                                  placeholder="Nhập kinh nghiệm, chuyên môn của bác sĩ...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tối đa 1000 ký tự</div>
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                               id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Định dạng: JPEG, PNG, JPG. Tối đa 2MB</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu bác sĩ
                        </button>
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
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
                    <li>Trường có dấu <span class="text-danger">*</span> là bắt buộc</li>
                    <li>Số điện thoại phải là duy nhất</li>
                    <li>Ảnh đại diện giúp bệnh nhân nhận biết bác sĩ dễ dàng hơn</li>
                    <li>Tiểu sử nên mô tả ngắn gọn về kinh nghiệm và chuyên môn</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
