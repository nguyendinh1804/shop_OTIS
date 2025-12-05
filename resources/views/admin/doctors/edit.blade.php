@extends('admin.layouts.app')

@section('title', 'Sửa bác sĩ')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit"></i> Sửa bác sĩ</h1>
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
                <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="specialty_id" class="form-label">Chuyên khoa <span class="text-danger">*</span></label>
                        <select class="form-select @error('specialty_id') is-invalid @enderror" 
                                id="specialty_id" name="specialty_id" required>
                            <option value="">-- Chọn chuyên khoa --</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}" 
                                    {{ old('specialty_id', $doctor->specialty_id) == $specialty->id ? 'selected' : '' }}>
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
                               id="name" name="name" value="{{ old('name', $doctor->name) }}" 
                               placeholder="Ví dụ: BS. Nguyễn Văn A" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}" 
                               placeholder="Ví dụ: 0901234567" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Tiểu sử / Kinh nghiệm</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="5" 
                                  placeholder="Nhập kinh nghiệm, chuyên môn của bác sĩ...">{{ old('bio', $doctor->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tối đa 1000 ký tự</div>
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        @if($doctor->avatar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $doctor->avatar) }}" 
                                     alt="{{ $doctor->name }}" 
                                     class="rounded" 
                                     width="150" height="150" 
                                     style="object-fit: cover;">
                                <p class="small text-muted mt-1">Ảnh hiện tại</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                               id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Định dạng: JPEG, PNG, JPG. Tối đa 2MB.
                            @if($doctor->avatar)
                                <br>Chọn ảnh mới để thay thế ảnh hiện tại.
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật
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
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin</h6>
            </div>
            <div class="card-body">
                <p class="mb-2 small"><strong>Ngày tạo:</strong> {{ $doctor->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0 small"><strong>Cập nhật:</strong> {{ $doctor->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Lưu ý</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0 small">
                    <li>Số điện thoại phải là duy nhất</li>
                    <li>Không thể xóa nếu đang có lịch hẹn</li>
                    <li>Ảnh mới sẽ thay thế ảnh cũ</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
