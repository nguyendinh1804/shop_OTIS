<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ
     */
    public function index(Request $request): View
    {
        $query = Doctor::with('specialty');

        // Lọc theo chuyên khoa
        if ($request->filled('specialty_id')) {
            $query->where('specialty_id', $request->specialty_id);
        }

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $doctors = $query->paginate(6);
        $specialties = Specialty::withCount('doctors')->get();

        return view('home', compact('doctors', 'specialties'));
    }
}
