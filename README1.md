# 📰 Hệ Thống Tin Tức — Hướng Dẫn Cài Đặt

## Cấu trúc file cần copy vào project

```
app/
  Models/
    News.php
    NewsCategory.php
    NewsTag.php
  Http/Controllers/
    NewsController.php              ← ghi đè file cũ
    Admin/
      NewsController.php            ← thêm mới

database/
  migrations/
    ..._create_news_categories_table.php
    ..._create_news_tags_table.php
    ..._create_news_table.php
    ..._create_news_news_tag_table.php
  seeders/
    NewsSeeder.php

resources/views/
  admin/news/
    index.blade.php
    form.blade.php
    categories.blade.php
    tags.blade.php
```

---

## Các bước thực hiện

### 1. Copy files vào đúng thư mục
Copy từng file theo cấu trúc trên vào project Laravel.

### 2. Chạy migration
```bash
php artisan migrate
```

### 3. Tạo storage link (nếu chưa có)
```bash
php artisan storage:link
```

### 4. Seed dữ liệu mẫu
```bash
php artisan db:seed --class=NewsSeeder
```

Hoặc thêm vào `DatabaseSeeder.php`:
```php
$this->call(NewsSeeder::class);
```

### 5. Thêm routes vào web.php
Mở `routes/web.php`, tìm block admin và thêm nội dung từ file `routes_to_add.php`.

### 6. Thêm link "Tin Tức" vào admin sidebar
Trong `layouts/admin.blade.php` thêm:
```html
<a href="{{ route('admin.news.index') }}">Tin Tức</a>
```

---

## Kết quả sau khi cài

| URL | Chức năng |
|-----|-----------|
| `/news` | Trang tin tức công khai (hiển thị bài từ DB) |
| `/news/{slug}` | Chi tiết bài viết |
| `/admin/news` | Danh sách bài viết (admin) |
| `/admin/news/create` | Tạo bài viết mới |
| `/admin/news/{id}/edit` | Sửa bài viết |
| `/admin/news-categories` | Quản lý chuyên mục |
| `/admin/news-tags` | Quản lý tags |

---

## Tính năng

- ✅ CRUD bài viết (tạo / sửa / xóa)
- ✅ Upload thumbnail
- ✅ Tự động tạo slug từ tiêu đề
- ✅ Tự động tính thời gian đọc (~200 từ/phút)
- ✅ Trạng thái Draft / Published (toggle bằng 1 click)
- ✅ Lọc theo chuyên mục, tag, trạng thái
- ✅ Đếm lượt xem tự động
- ✅ Bài viết liên quan
- ✅ 8 bài viết mẫu sẵn có từ seeder
