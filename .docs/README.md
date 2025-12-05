# Hệ thống Đặt Lịch Phòng Khám OTIS

## Giới thiệu
Website đặt lịch khám bệnh trực tuyến với Laravel 12.x, Bootstrap 5.3 và MySQL.

## Cài đặt

### Yêu cầu hệ thống
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (tùy chọn)

### Các bước cài đặt

1. **Clone repository**
```bash
git clone <repository-url>
cd shop_OTIS
```

2. **Cài đặt dependencies**
```bash
composer install
```

3. **Cấu hình môi trường**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Cấu hình database trong `.env`**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=otis_clinic
DB_USERNAME=root
DB_PASSWORD=
```

5. **Chạy migration và seeder**
```bash
php artisan migrate
php artisan db:seed
```

6. **Tạo symbolic link cho storage**
```bash
php artisan storage:link
```

7. **Khởi động server**
```bash
php artisan serve
```

Truy cập: http://localhost:8000

## Cấu trúc Database

### Bảng `specialties` (Chuyên khoa)
- `id`: Khóa chính
- `name`: Tên chuyên khoa
- `description`: Mô tả
- `timestamps`: Thời gian tạo/cập nhật

### Bảng `doctors` (Bác sĩ)
- `id`: Khóa chính
- `specialty_id`: Khóa ngoại tới bảng specialties
- `name`: Tên bác sĩ
- `phone`: Số điện thoại (unique)
- `bio`: Tiểu sử/kinh nghiệm
- `avatar`: Đường dẫn ảnh đại diện
- `timestamps`: Thời gian tạo/cập nhật

### Bảng `appointments` (Lịch hẹn)
- `id`: Khóa chính
- `doctor_id`: Khóa ngoại tới bảng doctors
- `patient_name`: Tên bệnh nhân
- `patient_phone`: SĐT bệnh nhân
- `patient_email`: Email bệnh nhân (nullable)
- `date`: Ngày khám
- `time`: Giờ khám
- `status`: Trạng thái (pending, confirmed, cancelled, completed)
- `note`: Ghi chú/triệu chứng
- `timestamps`: Thời gian tạo/cập nhật

## Chức năng

### Phân hệ Client (Bệnh nhân)
- **Trang chủ** (`/`): Hiển thị danh sách bác sĩ, lọc theo chuyên khoa
- **Đặt lịch** (`/booking/create`): Form đặt lịch khám
- **Thành công** (`/booking/success/{id}`): Xác nhận đặt lịch thành công

### Phân hệ Admin (Quản trị viên)
- **Dashboard** (`/admin`): Thống kê tổng quan
- **Quản lý chuyên khoa** (`/admin/specialties`): CRUD chuyên khoa
- **Quản lý bác sĩ** (`/admin/doctors`): CRUD bác sĩ với upload ảnh
- **Quản lý lịch hẹn** (`/admin/appointments`): Xem và đổi trạng thái lịch hẹn

## Logic kiểm tra trùng lịch

Hệ thống ngăn chặn việc đặt trùng lịch bằng cách:
- Kiểm tra bác sĩ (`doctor_id`)
- Kiểm tra ngày (`date`)
- Kiểm tra giờ (`time`)
- Chỉ tính các lịch có status là `pending` hoặc `confirmed`

Code tham khảo trong `BookingController@store`:
```php
$exists = Appointment::where('doctor_id', $request->doctor_id)
    ->where('date', $request->date)
    ->where('time', $request->time)
    ->whereIn('status', ['pending', 'confirmed'])
    ->exists();

if ($exists) {
    return back()->withErrors(['time' => 'Khung giờ này bác sĩ đã bận!']);
}
```

## Validation

Tất cả form đều có validation với thông báo lỗi tiếng Việt:
- Tên: bắt buộc, tối đa 255 ký tự
- SĐT: bắt buộc, tối đa 20 ký tự, unique (bác sĩ)
- Email: định dạng email hợp lệ
- Ngày khám: phải từ hôm nay trở đi
- Ảnh đại diện: jpeg/png/jpg, tối đa 2MB

## Routes chính

### Client
```
GET  /                          - Trang chủ
GET  /booking/create            - Form đặt lịch
POST /booking/store             - Xử lý đặt lịch
GET  /booking/success/{id}      - Trang thành công
```

### Admin
```
GET  /admin                     - Dashboard
Resource /admin/specialties     - CRUD chuyên khoa
Resource /admin/doctors         - CRUD bác sĩ
Resource /admin/appointments    - CRUD lịch hẹn
```

## Dữ liệu mẫu

Sau khi chạy seeder, hệ thống có sẵn:
- 5 chuyên khoa: Nha khoa, Tim mạch, Da liễu, Nhi khoa, Răng hàm mặt
- 5 bác sĩ với thông tin đầy đủ

## Công nghệ sử dụng

- **Backend**: Laravel 12.x, PHP 8.2
- **Frontend**: Blade Template, Bootstrap 5.3, FontAwesome 6
- **Database**: MySQL
- **Approach**: Code-First (Migration)

## Tính năng nổi bật

✅ Validation đầy đủ với thông báo tiếng Việt
✅ Kiểm tra trùng lịch (Core Logic)
✅ Upload và quản lý ảnh bác sĩ
✅ Lọc và tìm kiếm thông minh
✅ Responsive design với Bootstrap 5
✅ Flash messages cho UX tốt hơn
✅ Phân quyền admin/client rõ ràng

## Liên hệ & Support

- Email: info@otis.vn
- Phone: 1900 xxxx

---
© 2025 Phòng khám OTIS. All rights reserved.
