Thông tin dự án

Tuyệt vời\! Bạn chọn đề tài **Website Đặt Lịch Phòng Khám (Booking System)**. Đây là một lựa chọn rất thông minh vì nó giải quyết bài toán thực tế về **quản lý thời gian và tài nguyên** – điều mà mọi công ty phần mềm đều quan tâm.

Dưới đây là bản thiết kế chi tiết (Blueprint) để bạn bắt tay vào code ngay.

-----

### 1\. Phân tích chức năng (Features)

Chúng ta sẽ chia làm 2 phân hệ: **Admin (Quản trị viên/Bác sĩ)** và **Client (Người dùng/Bệnh nhân)**.

#### A. Phân hệ Khách hàng (Client/Patient)

  * **Trang chủ:** Giới thiệu phòng khám, danh sách bác sĩ nổi bật, các chuyên khoa.
  * **Tìm kiếm & Lọc:** Tìm bác sĩ theo chuyên khoa (Răng hàm mặt, Tim mạch, Da liễu...).
  * **Đặt lịch (Booking):**
      * Chọn Bác sĩ -\> Chọn Ngày -\> Chọn Khung giờ (Slot).
      * Điền thông tin cá nhân (Tên, SĐT, Email, Triệu chứng).
      * *Lưu ý: Để đơn giản cho người mới, cho phép đặt lịch mà không cần Đăng nhập/Đăng ký tài khoản.*
  * **Thông báo:** Nhận email xác nhận sau khi đặt thành công.

#### B. Phân hệ Quản trị (Admin)

  * **Dashboard:** Thống kê số lịch hẹn hôm nay, số lịch chờ duyệt.
  * **Quản lý Bác sĩ:** Thêm/Sửa/Xóa thông tin bác sĩ, chuyên khoa.
  * **Quản lý Lịch hẹn:**
      * Xem danh sách lịch hẹn.
      * Đổi trạng thái: *Chờ duyệt (Pending) -\> Đã duyệt (Confirmed) -\> Đã khám (Completed) -\> Hủy (Cancelled)*.

### C. valdidation
  * Validattion tất cả các from đầu vào 
  * Thông báo lỗi được hiển thị bằng tiếng việt.
-----

### 2\. Thiết kế Cơ sở dữ liệu (Database Design)

Bạn cần tạo các bảng chính sau. Hãy dùng **Migrations** trong Laravel để tạo.

**1. Bảng `specialties` (Chuyên khoa)**

  * `id`
  * `name` (Ví dụ: Nha khoa, Nhi khoa)
  * `description`

**2. Bảng `doctors` (Bác sĩ)**

  * `id`
  * `specialty_id` (Khóa ngoại trỏ về bảng specialties)
  * `name`
  * `phone`
  * `bio` (Mô tả kinh nghiệm)
  * `avatar` (Đường dẫn ảnh)

**3. Bảng `appointments` (Lịch hẹn - Bảng quan trọng nhất)**

  * `id`
  * `doctor_id` (Khóa ngoại)
  * `patient_name` (Tên bệnh nhân)
  * `patient_phone`
  * `patient_email`
  * `date` (Ngày đặt - định dạng YYYY-MM-DD)
  * `time` (Giờ đặt - Ví dụ: "09:00", "10:30")
  * `status` (Enum: 'pending', 'confirmed', 'cancelled', 'completed')
  * `note` (Triệu chứng bệnh)
  * `timestamps` (created\_at, updated\_at)

-----

### 3\. Logic xử lý quan trọng ("Điểm ăn tiền")

Đây là phần bạn cần chú trọng nhất để ghi điểm với nhà tuyển dụng: **Ngăn chặn trùng lịch (Overlap Validation).**

**Bài toán:** Một bác sĩ không thể tiếp 2 bệnh nhân cùng một lúc.
**Giải pháp:** Trước khi lưu vào database, bạn phải kiểm tra xem giờ đó đã có ai đặt chưa.

**Code tham khảo (Trong Controller):**

```php
public function store(Request $request) {
    // 1. Validate dữ liệu đầu vào
    $request->validate([
        'doctor_id' => 'required',
        'date' => 'required|date|after:today', // Phải đặt sau ngày hôm nay
        'time' => 'required',
        'patient_phone' => 'required',
    ]);

    // 2. Logic kiểm tra trùng lịch (Core Logic)
    $exists = Appointment::where('doctor_id', $request->doctor_id)
        ->where('date', $request->date)
        ->where('time', $request->time)
        ->whereIn('status', ['pending', 'confirmed']) // Chỉ tính các lịch chưa bị hủy
        ->exists();

    if ($exists) {
        return back()->withErrors(['time' => 'Khung giờ này bác sĩ đã bận, vui lòng chọn giờ khác!']);
    }

    // 3. Nếu không trùng thì lưu vào DB
    Appointment::create($request->all());

    // 4. Gửi email xác nhận (Optional - làm sau cùng)
    // Mail::to($request->patient_email)->send(new AppointmentConfirmation($appointment));

    return redirect()->back()->with('success', 'Đặt lịch thành công!');
}
```

-----

### 4\. Lộ trình thực hiện (Step-by-step)

Để không bị "ngợp", hãy làm theo thứ tự sau:

  * **Giai đoạn 1: Khung sườn (Back-end First)**

      * Cài đặt Laravel.
      * Tạo Migration cho `specialties`, `doctors`, `appointments`.
      * Tạo Models và khai báo Relationships (Ví dụ: Doctor `belongsTo` Specialty).
      * Tạo Seeder (Dữ liệu giả) để có sẵn danh sách bác sĩ.

  * **Giai đoạn 2: Admin Panel (CRUD)**

      * Dựng giao diện Admin (có thể dùng template admin miễn phí như AdminLTE hoặc Stisla).
      * Làm chức năng thêm/sửa/xóa Bác sĩ.
      * Làm trang danh sách Lịch hẹn (Hiện ra bảng các lịch đã đặt).

  * **Giai đoạn 3: Client Side (Đặt lịch)**

      * Tạo form đặt lịch đơn giản.
      * Xử lý logic check trùng lịch như ở mục 3.
      * Hiển thị thông báo lỗi/thành công.

  * **Giai đoạn 4: Nâng cao & Hoàn thiện**

      * Dùng **AJAX** Javascript: Khi chọn Bác sĩ A, tự động load lại danh sách các giờ còn trống của Bác sĩ A mà không cần reload trang.
      * Gửi Email xác nhận.

-----

### 5\. Gợi ý công cụ hỗ trợ (Tech Stack)

  * **Giao diện:** Bootstrap 5 (Dễ dùng nhất cho người mới).
  * **Chọn ngày tháng:** Thư viện `Flatpickr` (JS) để hiện cái lịch chọn ngày cho đẹp.
  * **Icon:** FontAwesome.
  * **Debug:** Cài `Laravel Debugbar` để xem câu truy vấn SQL chạy thế nào.

-----

**Bạn muốn tôi hỗ trợ phần nào tiếp theo?**

1.  Viết file Migration chi tiết cho các bảng?
2.  Hướng dẫn cách viết Relationship (Model) giữa Bác sĩ và Chuyên khoa?
3.  Gợi ý cách làm giao diện form đặt lịch?

# Quy tắc

- luôn phản hồi bằng tiếng việt
- luôn tuân theo danh sách chức năng đã liệt kê ở trên 
- sử dụng tiếng việt có dấu trong toàn bộ giao diện và thông báo lỗi
- sử dụng bootstrap 5 để làm giao diện cho admin
- tất cả các file hướng dẫn .md được đặt ở thư mục `.docs` trong dự án
- luôn kiểm tra lại tên model,tên bảng, tên biến, tên route đã có trong dự án hay chưa sau khi hoàn thành chức năng.

# Techmical Stack

- Backend: Laravel 12.x, php 8.2
- Frontend: balde template + bootstrap 5.3
- Database: MySQL


# tài liệu tham khảo

-https://laravel.com/docs/12.x
-https://getbootstrap.com/docs/5.3/getting-started/introduction/