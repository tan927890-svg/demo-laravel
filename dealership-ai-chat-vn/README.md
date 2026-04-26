# 🚗 Dealership AI Chat - Chạy với Laragon

Chatbot tư vấn bán ô tô tiếng Việt, dùng Groq API (miễn phí) + FastAPI + MySQL (Laragon).

---

## 🚀 Hướng dẫn cài đặt từng bước

### Bước 1 — Lấy Groq API Key (miễn phí)
1. Vào [console.groq.com](https://console.groq.com) → Đăng ký
2. Vào **API Keys** → **Create API Key** → Copy key

---

### Bước 2 — Cài Python
1. Tải tại [python.org/downloads](https://www.python.org/downloads/)
2. Khi cài nhớ tick ✅ **"Add Python to PATH"**
3. Kiểm tra: mở CMD gõ `python --version`

---

### Bước 3 — Tạo database trong Laragon
1. Mở **Laragon** → click **Start All**
2. Click **Database** (hoặc mở HeidiSQL)
3. Chạy file `init.sql` để tạo database và dữ liệu mẫu:
   - Trong HeidiSQL: File → Run SQL file → chọn `init.sql`

---

### Bước 4 — Cấu hình file .env
Trong thư mục project, copy file `.env.example` thành `.env`:
```
copy .env.example .env
```
M�� `.env` bằng Notepad, sửa:
```
GROQ_API_KEY=gsk_xxxx_key_của_bạn

MYSQL_USER=root
MYSQL_PASSWORD=
MYSQL_HOST=localhost
MYSQL_PORT=3306
MYSQL_DB=dealership
```
> Laragon mặc định MySQL user=root, password để trống

---

### Bước 5 — Cài thư viện Python
M�� CMD, `cd` vào thư mục project rồi chạy:
```bash
pip install -r requirements.txt
```

---

### Bước 6 — Chạy server
```bash
uvicorn app.main:app --reload
```
Truy cập: **http://localhost:8000/api**

---

## 📡 Test chatbot

M�� trình duyệt vào: **http://localhost:8000/docs** để dùng giao diện test tự động.

Hoặc dùng CMD:
```bash
curl -X POST http://localhost:8000/api/chat ^
  -H "Content-Type: application/json" ^
  -d "{\"message\": \"Tôi muốn mua SUV tầm 900 triệu\"}"
```

---

## 💬 Ví dụ hội thoại
> **Khách:** Tôi cần xe gia đình 7 chỗ tầm 700 triệu  
> **Bot:** Dạ, với ngân sách 700 triệu, em xin giới thiệu Mitsubishi Xpander 2023 phiên bản 1.5 AT giá 668 triệu, màu Đen, hiện còn hàng ạ...

---

## 📁 Cấu trúc project
```
dealership-ai-chat-vn/
├── app/
│   ├── chatbot.py      # Logic AI + system prompt tiếng Việt
│   ├── database.py     # Kết nối MySQL
│   ├── models.py       # Model xe
│   └── main.py         # FastAPI routes
├── init.sql            # Tạo database + dữ liệu mẫu (chạy trong HeidiSQL)
├── requirements.txt    # Thư viện Python
├── .env.example        # Mẫu cấu hình
└── README.md
```
