# 🏥 Website Đặt Lịch Phòng Khám OTIS

Hệ thống đặt lịch khám bệnh trực tuyến được xây dựng bằng Laravel 12.x, PHP 8.2, MySQL và Bootstrap 5.3.

## ✨ Tính Năng Chính

### 👥 Phân Hệ Khách Hàng
- 🏠 Trang chủ với danh sách bác sĩ và lọc theo chuyên khoa
- 📅 Đặt lịch khám trực tuyến (không cần đăng ký)
- ✅ Xác nhận đặt lịch thành công
- 🔍 **Tra cứu lịch hẹn** bằng mã + số điện thoại
- ❌ **Hủy lịch hẹn** trực tuyến (trước 24 giờ)

### 👨‍💼 Phân Hệ Quản Trị
- 📊 Dashboard với thống kê tổng quan
- 🏥 Quản lý chuyên khoa (CRUD)
- 👨‍⚕️ Quản lý bác sĩ (CRUD + upload ảnh)
- 📋 Quản lý lịch hẹn (CRUD + thay đổi trạng thái)
- 🕐 **Quản lý lịch làm việc bác sĩ** theo từng thứ trong tuần
- 📈 **Báo cáo & Thống kê** với biểu đồ trực quan

## 🎯 Core Logic

### Kiểm Tra Trùng Lịch (Overlap Prevention)
```php
// Ngăn chặn đặt trùng lịch - Logic quan trọng nhất
$exists = Appointment::where('doctor_id', $request->doctor_id)
    ->where('date', $request->date)
    ->where('time', $request->time)
    ->whereIn('status', ['pending', 'confirmed'])
    ->exists();
```

## 🗄️ Database

- **specialties**: Chuyên khoa (5 bản ghi mẫu)
- **doctors**: Bác sĩ (5 bản ghi mẫu, có avatar)
- **appointments**: Lịch hẹn
- **doctor_schedules**: Lịch làm việc bác sĩ _(mới)_

## 🚀 Cài Đặt

```bash
# 1. Cài đặt dependencies
composer install

# 2. Tạo file .env
cp .env.example .env
php artisan key:generate

# 3. Cấu hình database trong .env
DB_DATABASE=shop_otis
DB_USERNAME=root
DB_PASSWORD=

# 4. Chạy migration + seeder
php artisan migrate
php artisan db:seed

# 5. Tạo symbolic link cho storage
php artisan storage:link

# 6. Chạy server
php artisan serve
```

## 🌐 Truy Cập

- **Trang chủ**: http://127.0.0.1:8000
- **Đặt lịch**: http://127.0.0.1:8000/booking/create
- **Tra cứu lịch hẹn**: http://127.0.0.1:8000/tra-cuu-lich-hen
- **Admin**: http://127.0.0.1:8000/admin
- **Báo cáo**: http://127.0.0.1:8000/admin/reports

## 📊 Thống Kê Dự Án

- **Routes**: 39 routes
- **Controllers**: 8 controllers
- **Models**: 4 models
- **Views**: 23 Blade templates
- **Chức năng**: 9 modules

## 📚 Tài Liệu Chi Tiết

Xem thêm tại thư mục `.docs/`:
- `HUONG-DAN-SU-DUNG.md`: Hướng dẫn sử dụng chi tiết
- `CHUONG-3-CHUONG-MOI.md`: Hướng dẫn 3 chức năng mới
- `TONG-KET-DU-AN.md`: Tổng kết toàn bộ dự án

## 🛠️ Công Nghệ Sử Dụng

- **Backend**: Laravel 12.x, PHP 8.2
- **Frontend**: Blade Template + Bootstrap 5.3
- **Database**: MySQL
- **Biểu đồ**: Chart.js
- **Icons**: Font Awesome 6

## 📝 Lưu Ý

- ⚠️ Validation toàn bộ form bằng tiếng Việt
- ⚠️ Chỉ được hủy lịch trước 24 giờ
- ⚠️ Mỗi bác sĩ chỉ có 1 lịch làm việc cho mỗi thứ
- ⚠️ Cần đăng nhập để đặt lịch

## 📧 Liên Hệ

- Email: info@otis.vn
- Hotline: 0915527412

---

**Phiên bản**: 1.0.0  
**Ngày hoàn thành**: 02/12/2025
