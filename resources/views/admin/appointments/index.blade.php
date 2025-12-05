@extends('admin.layouts.app')

@section('title', 'Quản lý lịch hẹn')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-check"></i> Quản lý lịch hẹn</h1>
    <div>
        <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tạo lịch hẹn mới
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="doctor_id" class="form-label">Bác sĩ</label>
                <select name="doctor_id" id="doctor_id" class="form-select">
                    <option value="">Tất cả bác sĩ</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã khám</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="date" class="form-label">Ngày khám</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Tìm kiếm</label>
                <input type="text" name="search" id="search" class="form-control" 
                       value="{{ request('search') }}" placeholder="Tên hoặc SĐT bệnh nhân...">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Lọc
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($appointments->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">
                    @if(request()->hasAny(['doctor_id', 'status', 'date', 'search']))
                        Không tìm thấy lịch hẹn phù hợp với bộ lọc.
                    @else
                        Chưa có lịch hẹn nào.
                    @endif
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 15%;">Bệnh nhân</th>
                            <th style="width: 12%;">SĐT</th>
                            <th style="width: 15%;">Bác sĩ</th>
                            <th style="width: 10%;">Ngày khám</th>
                            <th style="width: 8%;">Giờ</th>
                            <th style="width: 10%;">Trạng thái</th>
                            <th style="width: 15%;">Ghi chú</th>
                            <th style="width: 10%;" class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td><strong>{{ $appointment->patient_name }}</strong></td>
                            <td><i class="fas fa-phone"></i> {{ $appointment->patient_phone }}</td>
                            <td>
                                {{ $appointment->doctor->name }}<br>
                                <small class="text-muted">{{ $appointment->doctor->specialty->name }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                            <td><i class="fas fa-clock"></i> {{ $appointment->time }}</td>
                            <td>
                                @if($appointment->status === 'pending')
                                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                @elseif($appointment->status === 'confirmed')
                                    <span class="badge bg-success">Đã duyệt</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-info">Đã khám</span>
                                @else
                                    <span class="badge bg-secondary">Đã hủy</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($appointment->note, 30) }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-outline-info" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-outline-primary" title="Đổi trạng thái">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa lịch hẹn này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
