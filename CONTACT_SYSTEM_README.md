# 🌞 Hệ Thống Nhắn Tin & Liên Hệ Trực Tiếp - Hướng Dẫn

## 📋 Tính Năng Đã Thêm

### 1. **Contact Widget** (Góc phải mỗi trang)
- **Mini Google Map** - Hiển thị vị trí công ty
- **Tab Bản đồ** - Xem bản đồ công ty
- **Tab Nhắn tin** - Gửi tin nhắn trực tiếp cho admin
- **Tab Liên hệ** - Các hình thức liên lạc nhanh

### 2. **Giao Thức Nhắn Tin Trực Tiếp**
- Khách hàng gửi tin nhắn qua widget
- Tin nhắn lưu vào `data/messages.json`
- Admin có thể xem/quản lý tin nhắn tại `/admin/messages.php`
- Email thông báo cho admin (nếu cấu hình email)

### 3. **Thông Tin Công Ty**
- **Tên**: Công Ty TNHH ENERGY Mặt Trời Việt
- **SĐT**: 0789686565
- **Bản đồ**: https://maps.app.goo.gl/V8geD9qtEMJe6M1P8

---

## 📂 File & Thư Mục Đã Thêm/Sửa

### ✅ **FILE MỚI THÊM:**

```
api/message.php                 - API xử lý tin nhắn
includes/contact-widget.php     - Widget liên hệ
admin/messages.php             - Quản lý tin nhắn
data/messages.json             - Lưu tin nhắn
```

### ✅ **FILE ĐÃ CẬP NHẬT:**

```
includes/header.php            - Cập nhật tên công ty
includes/footer.php            - Cập nhật SĐT, thêm widget
admin/dashboard.php            - Thêm thống kê tin nhắn, link trang tin nhắn
contact.php                    - Cập nhật header section
```

---

## 🚀 Hướng Dẫn Sử Dụng

### Cho Khách Hàng:
1. Click icon chat **💬** ở góc phải (tất cả trang)
2. Chọn tab:
   - **Bản đồ**: Xem vị trí công ty
   - **Nhắn tin**: Gửi tin nhắn trực tiếp
   - **Liên hệ**: Gọi, SMS, Email, hoặc Form

### Cho Admin:
1. Vào **Dashboard** → Link **Tin nhắn**
2. Xem danh sách tin nhắn
3. Click vào số điện thoại để gọi trực tiếp
4. Click vào email để trả lời
5. Xóa tin nhắn đã xử lý

---

## ⚙️ Cấu Hình (Tuỳ Chọn)

### 1. **Thay đổi Tọa độ Google Map**
Edit `includes/contact-widget.php`, dòng ~380:
```javascript
const mapLocation = {
    lat: 21.0285,   // Thay đổi latitude
    lng: 105.8542   // Thay đổi longitude
};
```

### 2. **Thay đổi Email Admin Nhận Thông Báo**
Edit `api/message.php`, dòng ~100:
```php
$admin_email = 'admin@solar.vn';  // Thay email của bạn
```

### 3. **Thay đổi API Key Google Maps**
Edit `includes/contact-widget.php`, dòng cuối:
```html
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&language=vi&region=VN"></script>
```
> **Lưu ý**: API Key hiện tại chỉ demo, cần replace bằng key của bạn

---

## 🔐 Bảo Mật

- ✅ Validate dữ liệu input
- ✅ Kiểm tra phone format
- ✅ Escape HTML/SQL injection
- ✅ Session check cho admin API
- ✅ CORS protection

---

## 📊 Dữ Liệu Tin Nhắn

Mỗi tin nhắn lưu:
```json
{
  "id": "unique_id",
  "name": "Tên khách hàng",
  "phone": "0789686565",
  "email": "email@example.com",
  "message": "Nội dung tin nhắn",
  "user_ip": "192.168.1.1",
  "user_agent": "Browser info",
  "created_at": "2026-04-25 10:30:45"
}
```

---

## 🐛 Troubleshooting

### Widget không hiện?
- Kiểm tra `includes/contact-widget.php` có được load trong footer
- Xem console (F12) có error không

### Google Map không load?
- Kiểm tra API Key có hợp lệ
- Check Google Maps API đã enable

### Tin nhắn không lưu?
- Kiểm tra quyền write folder `data/`
- Xem error_log trong Apache/PHP

### Email thông báo không gửi?
- Server cần hỗ trợ mail()
- Cấu hình đúng email trong `api/message.php`

---

## 📝 Lưu Ý

- Widget hiển thị trên **tất cả trang** (từ footer.php)
- Tin nhắn lưu file JSON, có thể backup `data/messages.json`
- Admin panel chỉ dành cho admin đã login
- Không có database, mọi dữ liệu lưu file JSON

---

## 📞 Thông Tin Công Ty

- **Tên**: Công Ty TNHH ENERGY Mặt Trời Việt
- **SĐT**: 0789686565
- **Email**: info@solar.vn
- **Địa chỉ**: [Từ Google Maps]

---

**Cập nhật**: 25/04/2026
