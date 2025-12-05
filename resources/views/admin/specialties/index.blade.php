@extends('admin.layouts.app')

@section('title', 'Quản lý chuyên khoa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-stethoscope"></i> Quản lý chuyên khoa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.specialties.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm chuyên khoa
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($specialties->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Chưa có chuyên khoa nào. Hãy thêm chuyên khoa đầu tiên!</p>
                <a href="{{ route('admin.specialties.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm chuyên khoa
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">Tên chuyên khoa</th>
                            <th style="width: 40%;">Mô tả</th>
                            <th style="width: 10%;" class="text-center">Số bác sĩ</th>
                            <th style="width: 15%;">Ngày tạo</th>
                            <th style="width: 10%;" class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($specialties as $specialty)
                        <tr>
                            <td>{{ $specialty->id }}</td>
                            <td><strong>{{ $specialty->name }}</strong></td>
                            <td>{{ Str::limit($specialty->description, 80) }}</td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $specialty->doctors_count }}</span>
                            </td>
                            <td>{{ $specialty->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.specialties.edit', $specialty) }}" class="btn btn-outline-primary" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.specialties.destroy', $specialty) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa chuyên khoa này?');">
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
                {{ $specialties->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
