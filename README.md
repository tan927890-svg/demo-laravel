# 🚗 AutoViet — Website Showroom Mercedes-Benz

Website giới thiệu, tư vấn và đặt lịch dịch vụ xe Mercedes-Benz, xây dựng bằng Laravel.

---

## 📋 Yêu Cầu Hệ Thống

| Công nghệ | Phiên bản tối thiểu |
|-----------|---------------------|
| PHP | >= 8.1 |
| Composer | >= 2.x |
| MySQL | >= 8.0 |
| Node.js | >= 18.x |
| NPM | >= 9.x |

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
APP_NAME=Laravel
APP_URL=http://demo-laravel.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=demo_laravel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tan927890@gmail.com
MAIL_PASSWORD=ulydvzgnecxzjqpc
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tan927890@gmail.com
MAIL_FROM_NAME="Mazda Bình Tân"
MAIL_GARAGE_EMAIL=tan927890@gmail.com
```

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

### 10. Build assets frontend

```bash
# Development (hot reload)
npm run dev

# Production
npm run build
```

### 11. Khởi chạy server

```bash
php artisan serve
```

Truy cập: [http://localhost:8000](http://localhost:8000)

---

## 📁 Cấu Trúc Dự Án

```
demo-laravel/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                      # Nhóm controller quản trị (admin panel)
│   │   │   ├── Auth/                       # Đăng nhập, đăng ký, quên mật khẩu
│   │   │   ├── CarController.php           # Danh sách, chi tiết, so sánh, báo giá xe
│   │   │   ├── BookingController.php       # Đặt lịch lái thử / dịch vụ
│   │   │   ├── OrderController.php         # Quản lý đơn hàng
│   │   │   ├── NewsController.php          # Trang tin tức
│   │   │   ├── ContactController.php       # Form liên hệ
│   │   │   ├── BaoGiaNhanhController.php   # Báo giá nhanh
│   │   │   ├── NewsletterController.php    # Đăng ký nhận bản tin
│   │   │   ├── PickupDeliveryController.php # Nhận/giao xe miễn phí
│   │   │   └── MaintenanceReminderController.php # Nhắc lịch bảo dưỡng
│   │   ├── Middleware/
│   │   └── Requests/
│   │       ├── Auth/
│   │       └── ProfileUpdateRequest.php
│   │
│   ├── Mail/
│   │   ├── BaoGiaMail.php                  # Email báo giá xe
│   │   ├── MaintenanceReminderMail.php     # Email nhắc bảo dưỡng
│   │   ├── NewsletterSubscribed.php        # Email xác nhận newsletter
│   │   └── PickupDeliveryRequest.php       # Email xác nhận nhận/giao xe
│   │
│   └── Models/
│       ├── Car.php                         # Model xe chính
│       ├── CarVariant.php                  # Phiên bản xe
│       ├── CarColor.php                    # Màu sắc xe
│       ├── CarSpec.php                     # Thông số kỹ thuật
│       ├── CarFeature.php                  # Tính năng xe
│       ├── CarGallery.php                  # Thư viện ảnh xe
│       ├── Brand.php                       # Hãng xe
│       ├── Order.php                       # Đơn hàng
│       ├── News.php                        # Tin tức
│       ├── NewsCategory.php                # Danh mục tin tức
│       ├── NewsTag.php                     # Tag tin tức
│       ├── Newsletter.php                  # Danh sách đăng ký nhận bản tin
│       ├── Contact.php                     # Liên hệ từ khách hàng
│       ├── BaoGiaNhanh.php                 # Yêu cầu báo giá nhanh
│       ├── Kpi.php                         # Chỉ số KPI
│       └── User.php                        # Người dùng nội bộ (admin / manager / staff)
│
├── database/
│   ├── migrations/                         # Toàn bộ lịch sử cấu trúc DB
│   └── seeders/
│       ├── DatabaseSeeder.php              # Seeder chính — tạo accounts + xe + gọi các seeder con
│       ├── CarDetailSeeder.php             # Seed chi tiết xe (variants, specs, features, gallery)
│       └── NewsSeeder.php                  # Seed tin tức mẫu
│
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── cars/          # Quản lý xe (index, create, edit)
│       │   ├── contacts/      # Xem liên hệ khách
│       │   ├── dashboard/     # Dashboard doanh thu
│       │   ├── kpi/           # Báo cáo KPI
│       │   ├── news/          # Quản lý tin tức, categories, tags
│       │   ├── newsletter/    # Quản lý danh sách bản tin
│       │   ├── orders/        # Quản lý đơn hàng
│       │   ├── staff/         # Quản lý nhân viên
│       │   └── users/         # Quản lý tài khoản
│       ├── auth/              # Đăng nhập, đăng ký, đặt lại mật khẩu (dành cho staff/admin)
│       ├── cars/              # Trang xe: danh sách, chi tiết, so sánh, báo giá, đặt lịch
│       ├── emails/            # Template email gửi đi (booking, báo giá, newsletter, bảo dưỡng...)
│       ├── layouts/           # Layout chính: admin.blade.php, frontend.blade.php, guest.blade.php
│       ├── orders/            # Theo dõi đơn hàng
│       ├── partials/          # Các partial tái sử dụng
│       ├── profile/           # Hồ sơ nội bộ (staff)
│       ├── services/          # Trang dịch vụ
│       └── [trang frontend]   # welcome, about, news, services, dat-lich-dich-vu, v.v.
│
├── public/
│   └── images/
│       ├── car/               # Ảnh xe KHÔNG có nền — dùng trong card, danh sách, so sánh
│       └── CTN/               # Ảnh xe CÓ nền — dùng trong banner, trang chủ, giới thiệu
│
└── routes/
    └── web.php                # Toàn bộ route của ứng dụng
```

---

## 🖼️ Quy Tắc Ảnh Xe

| Thư mục | Loại ảnh | Dùng ở đâu |
|---------|----------|------------|
| `public/images/car/` | Ảnh **không có nền** (PNG trong suốt) | Card xe, danh sách, trang so sánh |
| `public/images/CTN/` | Ảnh **có nền** (JPG/PNG với background) | Banner trang chủ, trang giới thiệu |

> Trong seeder, `image_url` trỏ tới `images/car/Ten-Xe-TN.png` (ảnh không nền).

---

## 🔐 Tài Khoản Mặc Định (sau khi seed)

Được tạo tự động bởi `DatabaseSeeder`. **Không có đăng ký tài khoản cho khách hàng** — chỉ nhân viên nội bộ mới cần đăng nhập.

| Vai trò | Email | Mật khẩu |
|---------|-------|----------|
| Admin | admin@autoviet.vn | password |
| Manager | manager@autoviet.vn | password |
| Staff | staff@autoviet.vn | password |

Truy cập trang quản trị: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## ✨ Tính Năng

### Trang khách — không cần đăng nhập
- Xem danh sách và chi tiết xe Mercedes
- So sánh xe, xem thư viện ảnh, thông số kỹ thuật
- Yêu cầu báo giá nhanh (gửi qua email)
- Đặt lịch lái thử / dịch vụ
- Đặt lịch bảo dưỡng định kỳ (gửi nhắc qua email)
- Đăng ký nhận/giao xe tận nơi miễn phí
- Xem tin tức, lọc theo danh mục và tag
- Đăng ký nhận bản tin newsletter
- Gửi liên hệ, tra cứu chi phí ước tính

### Trang quản trị — cần đăng nhập
| Quyền | Có thể làm |
|-------|-----------|
| **Admin** | Toàn quyền: xe, đơn hàng, tin tức, người dùng, KPI, doanh thu |
| **Manager** | Quản lý xe, đơn hàng, liên hệ, newsletter |
| **Staff** | Xem và xử lý đơn hàng, lịch dịch vụ |

---

## 📧 Cấu Hình Email

Dự án tự động gửi email cho các sự kiện: xác nhận đặt lịch, báo giá, nhắc bảo dưỡng, xác nhận newsletter.

**Môi trường development — dùng Mailtrap để test:**

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS=no-reply@autoviet.vn
MAIL_FROM_NAME="AutoViet"
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
# Kiểm tra file ảnh có đúng trong public/images/car/ và public/images/CTN/
```

**Lỗi npm build:**
```bash
npm cache clean --force && npm install && npm run build
```
** Chat bot **
layout → partial gọi nút toggle → click mở popup → iframe load GET /chat → ChatController@index → trả về chat/index.blade.php
# Tích hợp PWA vào laravel 
User vào web → nhấn "Thêm vào màn hình chính"
Nó tạo icon trên điện thoại y hệt app thật
Mở lên thì không có thanh địa chỉ, toàn màn hình như app
GPS hoạt động bình thường vì chạy HTTPS

B1 ** Tạo public/manifest.json **
B2   ** Tạo Service Worker 
         Tạo file public/sw.js **
 B3 ** Sửa lại views/layout/admin **    
đổi đia chỉ trong env 
xong php artisan config:clear     
# Hướng dẫn setup chấm công GPS

## 1. Cấu hình `.env`

```dotenv
# Tọa độ văn phòng (lấy từ Google Maps)
OFFICE_LAT=10.855313
OFFICE_LNG=106.629887
OFFICE_RADIUS=150
OFFICE_WIFI_SSID="Trầm và Tình"
```

---

## 2. Cấu hình `config/app.php`

Thêm vào cuối mảng, trước dấu `];`:

```php
'office' => [
    'lat'    => env('OFFICE_LAT'),
    'lng'    => env('OFFICE_LNG'),
    'radius' => env('OFFICE_RADIUS', 150),
],
```

---

## 3. Cấu hình `bootstrap/app.php`

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*');
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

---

## 4. Cấu hình `httpd.conf` (Laragon)

Đảm bảo có dòng:
```apache
Listen 80
```

---

## 5. Cấu hình Virtual Host

File: `C:/laragon/etc/apache2/sites-enabled/auto.demo-laravel.test.conf`

```apache
<VirtualHost *:80>
    DocumentRoot "C:/laragon/www/demo-laravel/public"
    ServerName demo-laravel.test
    ServerAlias *.demo-laravel.test
    ServerAlias murky-rematch-flaring.ngrok-free.dev
    <Directory "C:/laragon/www/demo-laravel/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

---

## 6. Cấu hình `sw.js` (Service Worker)

Thêm danh sách bypass cache:

```javascript
const NO_CACHE_PATHS = [
    '/admin/staff/attendance/checkin',
    '/admin/staff/attendance/checkout',
    '/api/',
];

self.addEventListener('fetch', e => {
    if (e.request.method !== 'GET') return;

    const url = new URL(e.request.url);
    const noCache = NO_CACHE_PATHS.some(path => url.pathname.startsWith(path));
    if (noCache) return;

    e.respondWith(
        fetch(e.request)
            .then(response => {
                const clone = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(e.request, clone));
                return response;
            })
            .catch(() => caches.match(e.request))
    );
});
```

---

## 7. StaffController — logic GPS

File: `app/Http/Controllers/Admin/StaffController.php`

```php
public function checkIn(Request $request)
{
    $officeLat    = (float) config('app.office.lat');
    $officeLng    = (float) config('app.office.lng');
    $officeRadius = (int)   config('app.office.radius', 150);

    $dist = $this->getDistance(
        $request->lat, $request->lng,
        $officeLat, $officeLng
    );

    if ($dist > $officeRadius) {
        return back()->with('error',
            "Bạn đang cách văn phòng {$dist}m — cần trong vòng {$officeRadius}m!"
        );
    }
    // ... lưu attendance
}
```

---

## 8. Blade JS — `attendance.blade.php`

```javascript
const OFFICE_LAT    = {{ config('app.office.lat') }};
const OFFICE_LNG    = {{ config('app.office.lng') }};
const OFFICE_RADIUS = {{ config('app.office.radius', 150) }};
const isIOS = /iPhone|iPad|iPod/.test(navigator.userAgent);

navigator.geolocation.getCurrentPosition(
    async (pos) => { /* xử lý */ },
    (err) => { /* báo lỗi */ },
    {
        enableHighAccuracy: true,
        timeout: isIOS ? 15000 : 10000,
        maximumAge: 0
    }
);
```

---

## 9. Chạy ngrok (test trên điện thoại)

### Cài đặt lần đầu

```cmd
# Tải ngrok tại https://ngrok.com/download
# Đăng ký tài khoản tại https://dashboard.ngrok.com/signup
# Lấy token tại https://dashboard.ngrok.com/get-started/your-authtoken

ngrok config add-authtoken <token>
```

### Chạy mỗi lần test

```cmd
ngrok http 80 --host-header=demo-laravel.test
```

Sẽ hiện link dạng:
```
https://xxxx.ngrok-free.app
```

Cập nhật `.env`:
```dotenv
APP_URL=https://xxxx.ngrok-free.app
```

Chạy:
```cmd
php artisan config:clear
php artisan cache:clear
```

### URL đúng trên điện thoại

```
https://xxxx.ngrok-free.app/admin/staff/attendance
```

> ⚠️ Link ngrok thay đổi mỗi lần restart (bản free). Cần cập nhật lại `APP_URL` và `ServerAlias` mỗi lần.

---

## 10. Lệnh hay dùng

```cmd
# Xóa cache config
php artisan config:clear
php artisan cache:clear

# Kiểm tra route
php artisan route:list | findstr attendance

# Kiểm tra port 80
netstat -ano | findstr :80 | findstr LISTENING
```

---

## Lưu ý quan trọng

| | Android | iOS |
|---|---|---|
| GPS | ✅ Hoạt động tốt | ✅ Cần cấp quyền trong Settings |
| WiFi SSID | ✅ Đọc được | ❌ Không hỗ trợ |
| Zalo WebView | ⚠️ GPS hạn chế | ❌ GPS bị chặn |
| Giải pháp Zalo | Mở bằng Chrome | Mở bằng Safari |
| Timeout GPS | 10 giây | 15 giây |

> **Tọa độ văn phòng**: `10.855313, 106.629887`  
> Công viên phần mềm Quang, Tòa nhà JPVE, Đường Số 2, Trung Mỹ Tây, HCM
chạy AI chat bằng groq
Bước 1 — Clone project
git clone <your-repo-url>
chạy lệnh 
cd dealership-ai-chat-vn
Bước 2 — Cài thư viện
pip install -r requirements.txt
Bước 3 — Tạo file .env
cp .env.example .env
Mở file .env vừa tạo, điền vào:
GROQ_API_KEY=your_groq_api_key_here
MYSQL_PASSWORD=your_mysql_password
>  dùng MySQL localhost giữ nguyên 
Bước 4 — Tạo database
mysql -u root -p -e "CREATE DATABASE demo_laravel;"
mysql -u root -p demo_laravel < init.sql
Bước 5 — Chạy project
> uvicorn app.main:app --reload
>  Lấy Groq API key miễn phí tại: https://console.groq.com/keys
