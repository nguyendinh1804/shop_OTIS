@extends('layouts.app')

@section('title', 'Đặt lịch khám')

@section('content')
<div class="bg-primary bg-opacity-10 py-4 mb-4">
    <div class="container">
        <h2 class="mb-0"><i class="fas fa-calendar-plus"></i> Đặt lịch khám</h2>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="mb-2"><i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <h5 class="mb-3"><i class="fas fa-user-md"></i> Thông tin lịch khám</h5>
                        
                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">Chọn bác sĩ <span class="text-danger">*</span></label>
                            <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                    id="doctor_id" name="doctor_id" required>
                                <option value="">-- Chọn bác sĩ --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" 
                                        {{ (old('doctor_id', $selectedDoctorId) == $doctor->id) ? 'selected' : '' }}>
                                        {{ $doctor->name }} - {{ $doctor->specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Ngày khám <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                       id="date" name="date" value="{{ old('date') }}" 
                                       min="{{ date('Y-m-d') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label">Giờ khám <span class="text-danger">*</span></label>
                                <select class="form-select @error('time') is-invalid @enderror" 
                                        id="time" name="time" required>
                                    <option value="">-- Chọn giờ --</option>
                                    <option value="08:00" {{ old('time') == '08:00' ? 'selected' : '' }}>08:00</option>
                                    <option value="08:30" {{ old('time') == '08:30' ? 'selected' : '' }}>08:30</option>
                                    <option value="09:00" {{ old('time') == '09:00' ? 'selected' : '' }}>09:00</option>
                                    <option value="09:30" {{ old('time') == '09:30' ? 'selected' : '' }}>09:30</option>
                                    <option value="10:00" {{ old('time') == '10:00' ? 'selected' : '' }}>10:00</option>
                                    <option value="10:30" {{ old('time') == '10:30' ? 'selected' : '' }}>10:30</option>
                                    <option value="11:00" {{ old('time') == '11:00' ? 'selected' : '' }}>11:00</option>
                                    <option value="13:00" {{ old('time') == '13:00' ? 'selected' : '' }}>13:00</option>
                                    <option value="13:30" {{ old('time') == '13:30' ? 'selected' : '' }}>13:30</option>
                                    <option value="14:00" {{ old('time') == '14:00' ? 'selected' : '' }}>14:00</option>
                                    <option value="14:30" {{ old('time') == '14:30' ? 'selected' : '' }}>14:30</option>
                                    <option value="15:00" {{ old('time') == '15:00' ? 'selected' : '' }}>15:00</option>
                                    <option value="15:30" {{ old('time') == '15:30' ? 'selected' : '' }}>15:30</option>
                                    <option value="16:00" {{ old('time') == '16:00' ? 'selected' : '' }}>16:00</option>
                                    <option value="16:30" {{ old('time') == '16:30' ? 'selected' : '' }}>16:30</option>
                                    <option value="17:00" {{ old('time') == '17:00' ? 'selected' : '' }}>17:00</option>
                                </select>
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <h5 class="mb-3"><i class="fas fa-user"></i> Thông tin bệnh nhân</h5>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Thông tin được lấy từ tài khoản của bạn: <strong>{{ auth()->user()->name }}</strong>
                        </div>
                        
                        <div class="mb-3">
                            <label for="patient_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('patient_name') is-invalid @enderror" 
                                   id="patient_name" name="patient_name" 
                                   value="{{ old('patient_name', auth()->user()->name) }}" 
                                   placeholder="Nhập họ và tên đầy đủ" required>
                            @error('patient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patient_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('patient_phone') is-invalid @enderror" 
                                       id="patient_phone" name="patient_phone" value="{{ old('patient_phone') }}" 
                                       placeholder="Ví dụ: 0901234567" required>
                                @error('patient_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="patient_email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('patient_email') is-invalid @enderror" 
                                       id="patient_email" name="patient_email" 
                                       value="{{ old('patient_email', auth()->user()->email) }}" 
                                       placeholder="email@example.com">
                                @error('patient_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Không bắt buộc, nhưng khuyến khích để nhận xác nhận</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Triệu chứng / Ghi chú</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" name="note" rows="4" 
                                      placeholder="Mô tả ngắn gọn triệu chứng hoặc lý do khám...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Lưu ý:</strong> Sau khi đặt lịch, bạn sẽ nhận được xác nhận. Vui lòng đến đúng giờ hẹn.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> Đặt lịch ngay
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
