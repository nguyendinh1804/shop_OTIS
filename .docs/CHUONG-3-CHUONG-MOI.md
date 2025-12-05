# Hướng Dẫn Sử Dụng Chức Năng Mới

## 1. Tra Cứu Lịch Hẹn (Client)

### Mục đích
Cho phép bệnh nhân tra cứu thông tin lịch hẹn và hủy lịch trực tuyến.

### Cách sử dụng

#### A. Tra cứu lịch hẹn
1. Truy cập trang chủ
2. Click vào menu **"Tra cứu lịch hẹn"** trên thanh điều hướng
3. Nhập thông tin:
   - **Mã lịch hẹn**: Mã số được gửi qua email sau khi đặt lịch thành công (ví dụ: 12345)
   - **Số điện thoại**: Số điện thoại đã dùng để đặt lịch
4. Click nút **"Tra Cứu Lịch Hẹn"**

#### B. Xem thông tin chi tiết
Sau khi tra cứu thành công, hệ thống hiển thị:
- **Trạng thái lịch hẹn**: Chờ duyệt / Đã xác nhận / Đã hoàn thành / Đã hủy
- **Thông tin bệnh nhân**: Họ tên, số điện thoại, email
- **Thông tin bác sĩ**: Tên, chuyên khoa, số điện thoại, ảnh đại diện
- **Thời gian khám**: Ngày và giờ khám
- **Ghi chú**: Triệu chứng bệnh (nếu có)

#### C. Hủy lịch hẹn
1. Trên trang kết quả tra cứu, click nút **"Hủy Lịch Hẹn"** (màu đỏ)
2. Trong hộp thoại xác nhận:
   - Đọc kỹ lưu ý: Chỉ được hủy trước 24 giờ
   - Nhập lại số điện thoại để xác nhận
3. Click **"Xác Nhận Hủy"**

#### Lưu ý quan trọng
- ⚠️ Chỉ có thể hủy lịch hẹn **trước 24 giờ** so với giờ khám
- ⚠️ Lịch hẹn đã **hoàn thành** hoặc đã **hủy** không thể hủy lại
- ⚠️ Nếu cần hủy gấp (dưới 24h), vui lòng liên hệ hotline: **1900-xxxx**

#### Route liên quan
```php
GET  /tra-cuu-lich-hen       // Hiển thị form tra cứu
POST /tra-cuu-lich-hen       // Xử lý tra cứu
DELETE /huy-lich-hen/{id}    // Hủy lịch hẹn
```

---

## 2. Quản Lý Lịch Làm Việc Bác Sĩ (Admin)

### Mục đích
Thiết lập lịch làm việc của từng bác sĩ theo từng thứ trong tuần.

### Cách sử dụng

#### A. Xem danh sách lịch làm việc
1. Đăng nhập tài khoản Admin
2. Vào menu **"Lịch làm việc bác sĩ"**
3. Hệ thống hiển thị:
   - Danh sách tất cả bác sĩ
   - Lịch làm việc của từng bác sĩ (nếu có)
   - Trạng thái: Hoạt động / Tạm ngưng

#### B. Thêm lịch làm việc mới
1. Click nút **"Thêm Lịch Mới"** (màu xanh)
2. Điền thông tin:
   - **Bác sĩ**: Chọn bác sĩ từ danh sách
   - **Thứ trong tuần**: Chọn từ Thứ Hai đến Chủ Nhật
   - **Giờ bắt đầu**: Ví dụ: 08:00
   - **Giờ kết thúc**: Ví dụ: 17:00 (phải sau giờ bắt đầu)
   - **Kích hoạt**: Bật/Tắt (nếu tắt, bệnh nhân không thể đặt lịch vào thời gian này)
3. Click **"Lưu Lịch"**

#### C. Chỉnh sửa lịch làm việc
1. Tìm lịch cần sửa trong danh sách
2. Click nút **"Sửa"** (màu vàng)
3. Cập nhật thông tin:
   - ⚠️ **Không thể thay đổi** bác sĩ và thứ trong tuần
   - Chỉ có thể thay đổi giờ làm việc và trạng thái
4. Click **"Cập Nhật"**

#### D. Xóa lịch làm việc
1. Click nút **"Xóa"** (màu đỏ) bên cạnh lịch cần xóa
2. Xác nhận trong hộp thoại
3. Lịch làm việc sẽ bị xóa vĩnh viễn

#### E. Xem chi tiết lịch của bác sĩ
1. Click nút **"Xem Chi Tiết"**
2. Hiển thị:
   - Thông tin bác sĩ (ảnh, tên, chuyên khoa, SĐT)
   - Bảng lịch làm việc đầy đủ trong tuần
   - Thống kê: Tổng số ngày, ngày hoạt động, tổng giờ/tuần

#### Quy tắc quan trọng
- ✅ Mỗi bác sĩ chỉ có **1 lịch làm việc** cho mỗi thứ
- ✅ Giờ kết thúc phải **sau** giờ bắt đầu
- ✅ Nếu tắt "Kích hoạt", bệnh nhân **không thể đặt lịch** vào khung giờ đó
- ✅ Nếu muốn thay đổi thứ, phải **xóa lịch cũ** và **tạo lịch mới**

#### Gợi ý khung giờ phổ biến
- Ca sáng: 08:00 - 12:00
- Ca chiều: 13:00 - 17:00
- Ca tối: 18:00 - 21:00

#### Route liên quan
```php
GET    /admin/schedules              // Danh sách
GET    /admin/schedules/create       // Form thêm mới
POST   /admin/schedules              // Lưu lịch mới
GET    /admin/schedules/{id}         // Chi tiết
GET    /admin/schedules/{id}/edit    // Form chỉnh sửa
PUT    /admin/schedules/{id}         // Cập nhật
DELETE /admin/schedules/{id}         // Xóa
```

#### Database
- **Bảng**: `doctor_schedules`
- **Cột**:
  - `doctor_id`: ID bác sĩ (Foreign Key)
  - `day_of_week`: Thứ trong tuần (enum: monday-sunday)
  - `start_time`: Giờ bắt đầu (time)
  - `end_time`: Giờ kết thúc (time)
  - `is_active`: Trạng thái (boolean)

---

## 3. Báo Cáo & Thống Kê (Admin)

### Mục đích
Cung cấp các số liệu phân tích về hoạt động đặt lịch khám.

### Cách sử dụng

#### A. Truy cập trang báo cáo
1. Đăng nhập Admin
2. Click menu **"Báo cáo & Thống kê"**

#### B. Lọc theo thời gian
1. Chọn **Từ ngày** và **Đến ngày**
2. Click nút **"Lọc"**
3. Tất cả số liệu sẽ được tính lại dựa trên khoảng thời gian đã chọn

#### C. Các chỉ số thống kê

##### 1. Thống kê tổng quan (4 thẻ màu)
- **Tổng Lịch Hẹn** (màu xanh): Tổng số lịch đã đặt trong khoảng thời gian
- **Chờ Duyệt** (màu vàng): Số lịch đang chờ admin xác nhận
- **Đã Hoàn Thành** (màu xanh lá): Số lịch đã khám xong
- **Đã Hủy** (màu đỏ): Số lịch đã bị hủy

##### 2. Tỷ lệ hoàn thành và tỷ lệ hủy
- Hiển thị dạng phần trăm (%) với thanh progress bar
- **Tỷ lệ hoàn thành** = (Số lịch hoàn thành / Tổng lịch) × 100%
- **Tỷ lệ hủy** = (Số lịch hủy / Tổng lịch) × 100%

##### 3. Top 5 Bác Sĩ Nhiều Lịch Nhất
- Bảng xếp hạng bác sĩ có nhiều lượt đặt lịch nhất
- Hiển thị: Tên, chuyên khoa, số lượng lịch
- Icon đặc biệt cho Top 1, 2, 3 (huy chương vàng, bạc, đồng)

##### 4. Lịch Hẹn 7 Ngày Gần Nhất
- Biểu đồ cột (Bar Chart)
- Hiển thị số lượng lịch hẹn theo từng ngày
- Giúp nhận biết xu hướng đặt lịch

##### 5. Thống Kê Theo Chuyên Khoa
- Bảng danh sách các chuyên khoa
- Số lượng lịch hẹn của từng chuyên khoa
- Thanh tiến trình (%) so với tổng số lịch

##### 6. Giờ Đặt Lịch Phổ Biến
- Top 5 khung giờ được bệnh nhân đặt nhiều nhất
- Ví dụ: 09:00, 14:00, 16:00...
- Giúp tối ưu hóa lịch làm việc bác sĩ

##### 7. Phân Bố Trạng Thái
- Biểu đồ tròn (Doughnut Chart)
- Hiển thị tỷ lệ phần trăm của từng trạng thái
- Màu sắc: Vàng (chờ duyệt), Xanh lá (đã xác nhận), Xanh dương (hoàn thành), Đỏ (hủy)

#### D. Ứng dụng thực tế

##### Kịch bản 1: Đánh giá hiệu quả hoạt động
```
Bước 1: Chọn "Tháng này" → Click "Lọc"
Bước 2: Xem tỷ lệ hoàn thành
  - Nếu > 80%: Hoạt động tốt ✅
  - Nếu < 50%: Cần cải thiện quy trình ⚠️
```

##### Kịch bản 2: Phát hiện bác sĩ quá tải
```
Bước 1: Xem "Top 5 Bác Sĩ"
Bước 2: Nếu có bác sĩ vượt xa người khác
  → Cân nhắc thêm lịch làm việc
  → Hoặc phân bổ lại bác sĩ
```

##### Kịch bản 3: Tối ưu lịch làm việc
```
Bước 1: Xem "Giờ Đặt Lịch Phổ Biến"
Bước 2: Nếu 14:00 - 16:00 có nhiều lượt đặt
  → Bố trí thêm bác sĩ vào khung giờ này
```

#### Route liên quan
```php
GET /admin/reports?start_date=2024-01-01&end_date=2024-01-31
```

#### Thư viện biểu đồ
- **Chart.js**: Được sử dụng để vẽ biểu đồ cột và biểu đồ tròn
- CDN: `https://cdn.jsdelivr.net/npm/chart.js`

---

## Kiểm Tra Toàn Bộ Chức Năng

### Checklist hoàn thành
- ✅ Chức năng 5: Tra cứu lịch hẹn (3 routes)
- ✅ Chức năng 6: Lịch làm việc bác sĩ (7 routes CRUD)
- ✅ Chức năng 7: Báo cáo & thống kê (1 route)
- ✅ Migration `doctor_schedules` đã chạy thành công
- ✅ Model `DoctorSchedule` với relationships đầy đủ
- ✅ Seeder tạo dữ liệu mẫu cho lịch làm việc
- ✅ Views: 2 views tra cứu + 4 views schedules + 1 view reports
- ✅ Admin sidebar menu đã cập nhật
- ✅ Client navbar đã thêm link tra cứu

### Cách kiểm tra

#### 1. Kiểm tra tra cứu lịch hẹn
```bash
# Truy cập
http://127.0.0.1:8000/tra-cuu-lich-hen

# Nhập thông tin (dùng ID lịch hẹn có trong database)
Mã lịch hẹn: 1
Số điện thoại: 0912345678
```

#### 2. Kiểm tra lịch làm việc bác sĩ
```bash
# Truy cập admin
http://127.0.0.1:8000/admin/schedules

# Thử thêm lịch mới cho bác sĩ
Click "Thêm Lịch Mới"
Chọn bác sĩ: Bs. Nguyễn Văn A
Thứ: Thứ Hai
Giờ: 08:00 - 17:00
```

#### 3. Kiểm tra báo cáo
```bash
# Truy cập
http://127.0.0.1:8000/admin/reports

# Lọc theo tháng hiện tại
# Xem các biểu đồ và thống kê
```

---

## Troubleshooting (Xử lý lỗi)

### Lỗi 1: Không thấy menu "Lịch làm việc bác sĩ"
**Giải pháp**: 
```bash
php artisan route:clear
php artisan cache:clear
php artisan view:clear
```

### Lỗi 2: Biểu đồ không hiển thị
**Nguyên nhân**: Chưa load Chart.js
**Giải pháp**: Kiểm tra internet, CDN Chart.js phải được load trong view

### Lỗi 3: Không tra cứu được lịch hẹn
**Nguyên nhân**: 
- Nhập sai mã lịch hẹn
- Nhập sai số điện thoại
**Giải pháp**: 
- Kiểm tra chính xác mã (ID) trong database
- Số điện thoại phải khớp 100%

### Lỗi 4: Không thể thêm lịch cho bác sĩ
**Nguyên nhân**: Bác sĩ đã có lịch làm việc vào thứ đó
**Giải pháp**: Sửa lịch cũ hoặc xóa lịch cũ rồi tạo mới

---

## Kết Luận

Ba chức năng mới đã hoàn thiện:
1. ✅ **Tra cứu lịch hẹn**: Giúp bệnh nhân tự tra cứu và hủy lịch
2. ✅ **Lịch làm việc bác sĩ**: Quản lý thời gian làm việc linh hoạt
3. ✅ **Báo cáo thống kê**: Cung cấp insight về hoạt động phòng khám

Tổng số routes đã thêm: **11 routes**
Tổng số views đã thêm: **7 views**
Tổng số tables mới: **1 table** (doctor_schedules)
