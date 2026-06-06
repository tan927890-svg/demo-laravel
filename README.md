# 🚗 Auto X — Website Showroom Mercedes-Benz

Website giới thiệu, tư vấn và đặt lịch dịch vụ xe Mercedes-Benz, xây dựng bằng Laravel + FastAPI AI Chat + PWA + Chấm công GPS.

---

## 📋 Yêu Cầu Hệ Thống

| Công nghệ | Phiên bản tối thiểu |
|-----------|---------------------|
| PHP | >= 8.1 |
| Composer | >= 2.x |
| MySQL | >= 8.0 |
| Node.js | >= 18.x |
| NPM | >= 9.x |
| Python | 3.10 |

---

## 🚀 Hướng Dẫn Cài Đặt

### 1. Clone dự án

```bash
git clone https://github.com/your-username/demo-laravel.git
cd demo-laravel
```

### 2. Cài đặt dependencies PHP

```bash
composer install
```

### 3. Cài đặt dependencies Node.js

```bash
npm install
```

### 4. Tạo file môi trường

```bash
cp .env.example .env
```

### 5. Sinh khóa ứng dụng

```bash
php artisan key:generate
```

### 6. Cấu hình file `.env`

```env
APP_NAME=Auto X
APP_URL=http://demo-laravel.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=demo_laravel
DB_USERNAME=root
DB_PASSWORD=

# Tọa độ văn phòng (chấm công GPS)
OFFICE_LAT=10.855313
OFFICE_LNG=106.629887
OFFICE_RADIUS=150
OFFICE_WIFI_SSID="Tên Wifi Văn Phòng"

# Email (dùng Mailtrap khi dev, Gmail khi production)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS=no-reply@autox.vn
MAIL_FROM_NAME="Auto X"
MAIL_GARAGE_EMAIL=your_email@gmail.com
```

> **Lấy Gmail App Password (dùng khi production):** https://myaccount.google.com/apppasswords

### 7. Tạo database

```sql
CREATE DATABASE demo_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 8. Chạy migration và seeder

```bash
php artisan migrate --seed
```

### 9. Tạo symbolic link cho storage

```bash
php artisan storage:link
```

### 10. Tải model nhận diện khuôn mặt (face-api.js)

> ⚠️ Phải `cd` vào thư mục gốc project (nơi có folder `public/`) trước khi chạy.

```powershell
mkdir -Force public\face-models; cd public\face-models; @(
  "tiny_face_detector_model-weights_manifest.json",
  "tiny_face_detector_model-shard1",
  "face_landmark_68_tiny_model-weights_manifest.json",
  "face_landmark_68_tiny_model-shard1",
  "face_recognition_model-weights_manifest.json",
  "face_recognition_model-shard1",
  "face_recognition_model-shard2"
) | ForEach-Object { Invoke-WebRequest -Uri "https://github.com/justadudewhohacks/face-api.js/raw/master/weights/$_" -OutFile $_ }
```

Kiểm tra sau khi tải — phải thấy đủ **7 file**:

```powershell
ls public\face-models | Select-Object Name, Length
```

| File | Kích thước |
|------|-----------|
| `face_recognition_model-shard1` | ~6.2 MB |
| `face_recognition_model-shard2` | ~2.0 MB |
| `tiny_face_detector_model-shard1` | ~190 KB |

> ❌ Nếu file nào = 0 bytes → tải lại file đó riêng:
> ```powershell
> Invoke-WebRequest -Uri "https://github.com/justadudewhohacks/face-api.js/raw/master/weights/face_recognition_model-shard1" -OutFile "public\face-models\face_recognition_model-shard1"
> ```

### 11. Cài đặt AI Chat (FastAPI + Groq)

```bash
# Di chuyển vào thư mục AI chat
cd dealership-ai-chat-main

# Cài thư viện Python
pip install -r requirements.txt

# Tạo file .env cho AI
cp .env.example .env
```

Mở file `.env` vừa tạo, điền vào:

```env
GROQ_API_KEY=your_groq_api_key_here
MYSQL_PASSWORD=your_mysql_password
```

> **Lấy Groq API key miễn phí:** https://console.groq.com/keys

Tạo database cho AI chat:

```bash
mysql -u root -p -e "CREATE DATABASE demo_laravel;"
mysql -u root -p demo_laravel < init.sql
```
  
Chạy AI chat server:

```bash
cd C:\laragon\www\demo-laravel\dealership-ai-chat-main\app
uvicorn main:app --host 0.0.0.0 --port 8000 --reload
```

### 12. Build assets frontend

```bash
# Development (hot reload)
npm run dev

# Production
npm run build
```

### 13. Khởi chạy server Laravel

```bash
php artisan serve
```

Truy cập: [http://localhost:8000](http://localhost:8000)

---

## 🌐 Expose ra Internet (Cloudflare Tunnel)

Dùng khi cần test PWA hoặc chấm công GPS qua HTTPS thật:

```bash
# Bước 1 — Chạy Laravel
php artisan serve --port=8000

# Bước 2 — Mở tunnel (chạy cửa sổ khác)
.\cloudflared-windows-amd64.exe tunnel --url http://localhost:8000
```

> Cập nhật URL nhận được vào `APP_URL` trong `.env`, sau đó chạy `php artisan config:clear`.

---

## 📁 Cấu Trúc Dự Án

```
demo-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                      # Controller quản trị
│   │   │   ├── Auth/                       # Đăng nhập, đăng ký, quên mật khẩu
│   │   │   ├── CarController.php           # Danh sách, chi tiết, so sánh, báo giá xe
│   │   │   ├── BookingController.php       # Đặt lịch lái thử / dịch vụ
│   │   │   ├── OrderController.php         # Quản lý đơn hàng
│   │   │   ├── NewsController.php          # Trang tin tức
│   │   │   ├── ContactController.php       # Form liên hệ
│   │   │   ├── BaoGiaNhanhController.php   # Báo giá nhanh
│   │   │   ├── NewsletterController.php    # Đăng ký nhận bản tin
│   │   │   ├── PickupDeliveryController.php
│   │   │   └── MaintenanceReminderController.php
│   │   └── Middleware/
│   ├── Mail/
│   └── Models/
│       ├── Car.php / CarVariant.php / CarColor.php / CarSpec.php
│       ├── Brand.php / Order.php / News.php / User.php
│       └── ...
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── CarDetailSeeder.php
│       └── NewsSeeder.php
├── resources/views/
│   ├── admin/        # cars, orders, news, staff, dashboard, kpi
│   ├── cars/         # danh sách, chi tiết, so sánh, báo giá, đặt lịch
│   ├── layouts/      # admin.blade.php, frontend.blade.php, guest.blade.php
│   ├── emails/       # template email gửi đi
│   └── partials/
├── public/
│   ├── face-models/  # Model nhận diện khuôn mặt (tải ở bước 10)
│   ├── manifest.json # PWA manifest
│   ├── sw.js         # Service Worker
│   └── images/
│       ├── car/      # Ảnh xe không nền (PNG) — dùng trong card, danh sách
│       └── CTN/      # Ảnh xe có nền (JPG) — dùng trong banner, trang chủ
├── dealership-ai-chat-main/  # AI Chat FastAPI
└── routes/web.php
```

---

## 🖼️ Quy Tắc Ảnh Xe

| Thư mục | Loại ảnh | Dùng ở đâu |
|---------|----------|------------|
| `public/images/car/` | PNG trong suốt (không nền) | Card xe, danh sách, trang so sánh |
| `public/images/CTN/` | JPG/PNG có background | Banner trang chủ, trang giới thiệu |

---

## 🔐 Tài Khoản Mặc Định

Tạo tự động sau khi chạy `migrate --seed`. **Không có đăng ký cho khách hàng** — chỉ nhân viên nội bộ.

| Vai trò | Email | Mật khẩu |
|---------|-------|----------|
| Admin | admin@autox.vn | password |
| Manager | manager@autox.vn | password |
| Staff | staff@autox.vn | password |

Trang quản trị: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## ✨ Tính Năng

### Trang khách — không cần đăng nhập
- Xem danh sách, chi tiết, so sánh xe Mercedes
- Báo giá nhanh, đặt lịch lái thử / dịch vụ
- Nhắc lịch bảo dưỡng định kỳ qua email
- Đăng ký nhận/giao xe tận nơi miễn phí
- Xem tin tức, lọc theo danh mục và tag
- Đăng ký newsletter, gửi liên hệ
- Chat AI tư vấn xe (Groq API)

### Trang quản trị — cần đăng nhập

| Quyền | Có thể làm |
|-------|-----------|
| **Admin** | Toàn quyền: xe, đơn hàng, tin tức, người dùng, KPI, doanh thu |
| **Manager** | Quản lý xe, đơn hàng, liên hệ, newsletter |
| **Staff** | Xem và xử lý đơn hàng, lịch dịch vụ, chấm công GPS |

---

## 📍 Chấm Công GPS

Cấu hình tọa độ văn phòng trong `.env`:

```env
OFFICE_LAT=10.855313
OFFICE_LNG=106.629887
OFFICE_RADIUS=150   # Bán kính tính bằng mét
```

Cấu hình `config/app.php` — thêm vào cuối mảng trước dấu `];`:

```php
'office' => [
    'lat'    => env('OFFICE_LAT'),
    'lng'    => env('OFFICE_LNG'),
    'radius' => env('OFFICE_RADIUS', 150),
],
```

> Địa chỉ văn phòng: Công viên phần mềm Quang Trung, Tòa nhà JPVE, Đường Số 2, Trung Mỹ Tây, HCM

---

## 📱 PWA (Progressive Web App)

Cho phép cài web lên màn hình điện thoại như app thật, hoạt động fullscreen và hỗ trợ GPS qua HTTPS.

Các file cần có:
- `public/manifest.json` — cấu hình PWA
- `public/sw.js` — Service Worker (cache + bypass cho checkin/checkout)
- Thêm thẻ link vào `views/layouts/admin.blade.php`

> Cần chạy qua HTTPS thật (dùng Cloudflare Tunnel ở bước 11) để GPS và PWA hoạt động đúng trên mobile.

---

## 🤖 Chat Bot AI

Luồng hoạt động:
```
Layout → partial nút toggle → click mở popup → iframe load GET /chat
→ ChatController@index → chat/index.blade.php → gọi FastAPI Groq
```

Thư viện Python sử dụng:
- `google-genai` — Google Gemini API (thay thế `google-generativeai` đã deprecated)

```bash
C:\laragon\bin\python\python-3.10\python.exe -m pip install google-genai
```

---

## 🛠 Lệnh Hữu Ích

```bash
# Reset toàn bộ DB và chạy lại seeder
php artisan migrate:fresh --seed

# Xóa cache
php artisan cache:clear && php artisan config:clear && php artisan view:clear

# Xem danh sách route
php artisan route:list

# Tạo lại symbolic link storage
php artisan storage:link
```

---

## 🐛 Xử Lý Lỗi Thường Gặp

**Lỗi 500 khi chạy lần đầu:**
```bash
php artisan key:generate && php artisan config:clear
```

**Lỗi permission trên Linux/macOS:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Ảnh không hiển thị:**
```bash
php artisan storage:link
# Kiểm tra file ảnh đúng trong public/images/car/ và public/images/CTN/
```

**Lỗi npm build:**
```bash
npm cache clean --force && npm install && npm run build
```

**SSL lỗi khi tải face-models (PowerShell):**
```powershell
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
# Chạy dòng này trước rồi mới chạy lệnh tải model
```
# cài thư viện dompdf
composer require barryvdh/laravel-dompdf
# sau đó chạy tiếp để cài font chữ Ctrl + C 
cd C:\laragon\www\demo-laravel
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
php artisan config:clear