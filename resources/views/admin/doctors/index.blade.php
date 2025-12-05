@extends('admin.layouts.app')

@section('title', 'Quản lý bác sĩ')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-md"></i> Quản lý bác sĩ</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm bác sĩ
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form action="{{ route('admin.doctors.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="specialty_id" class="form-label">Chuyên khoa</label>
                <select name="specialty_id" id="specialty_id" class="form-select">
                    <option value="">Tất cả chuyên khoa</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->id }}" {{ request('specialty_id') == $specialty->id ? 'selected' : '' }}>
                            {{ $specialty->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="search" class="form-label">Tìm kiếm</label>
                <input type="text" name="search" id="search" class="form-control" 
                       value="{{ request('search') }}" placeholder="Tìm theo tên hoặc số điện thoại...">
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
        @if($doctors->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                <p class="text-muted">
                    @if(request()->hasAny(['specialty_id', 'search']))
                        Không tìm thấy bác sĩ phù hợp với bộ lọc.
                    @else
                        Chưa có bác sĩ nào. Hãy thêm bác sĩ đầu tiên!
                    @endif
                </p>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm bác sĩ
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 10%;">Ảnh</th>
                            <th style="width: 20%;">Tên bác sĩ</th>
                            <th style="width: 15%;">Chuyên khoa</th>
                            <th style="width: 15%;">Số điện thoại</th>
                            <th style="width: 25%;">Tiểu sử</th>
                            <th style="width: 10%;" class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->id }}</td>
                            <td>
                                @if($doctor->avatar)
                                    <img src="{{ asset('storage/' . $doctor->avatar) }}" 
                                         alt="{{ $doctor->name }}" 
                                         class="rounded-circle" 
                                         width="50" height="50" 
                                         style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $doctor->name }}</strong></td>
                            <td><span class="badge bg-info">{{ $doctor->specialty->name }}</span></td>
                            <td><i class="fas fa-phone"></i> {{ $doctor->phone }}</td>
                            <td>{{ Str::limit($doctor->bio, 50) }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-outline-primary" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa bác sĩ này?');">
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
                {{ $doctors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
