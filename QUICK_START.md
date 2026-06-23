# 🚀 Quick Start Guide - Sistem Arsip Digital UKRI

Backend telah selesai dibuat dengan full CRUD functionality, API, dan database setup.

## ⚡ Quick Setup (5 menit)

### 1. Install Dependencies
```bash
cd c:\laragon\www\arsip-ukri\arsip-ukri
composer install
```

### 2. Setup Environment
```bash
# Copy contoh file environment
copy .env.example .env

# Generate app key
php artisan key:generate
```

### 3. Database Setup
```bash
# Create database
mysql -u root -e "CREATE DATABASE arsip_ukri CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations
php artisan migrate

# Seed database dengan data dummy
php artisan db:seed
```

### 4. Setup File Storage
```bash
# Create symlink untuk public storage
php artisan storage:link

# Create upload directories
mkdir -p storage/app/public/dokumen
mkdir -p storage/app/public/foto
mkdir -p storage/app/public/video

# Set permissions (Windows tidak perlu, tapi untuk Linux/Mac)
chmod -R 777 storage/app/public/
```

### 5. Run Server
```bash
php artisan serve
```

Server akan berjalan di **http://localhost:8000**

---

## 📝 Default Login Credentials

### Admin Account
- **URL:** http://localhost:8000
- **Email:** dzikri@ukri.ac.id
- **Password:** password

### Test User
- **Email:** jilan@ukri.ac.id  
- **Password:** password

---

## 🔗 Important URLs

| URL | Purpose |
|-----|---------|
| http://localhost:8000 | Web App Login |
| http://localhost:8000/dashboard | Dashboard |
| http://localhost:8000/api/health | API Health Check |
| http://localhost:8000/api/login | API Login |

---

## 📚 Documentation Files

Dokumentasi lengkap tersedia di:

1. **[BACKEND_SETUP.md](./BACKEND_SETUP.md)**
   - Instalasi lengkap
   - Database structure
   - File structure
   - Troubleshooting

2. **[API_DOCUMENTATION.md](./API_DOCUMENTATION.md)**
   - Semua endpoint API
   - Request/Response examples
   - Error handling
   - Demo users

---

## 🎯 Features Implemented

### ✅ Web Interface
- [x] Login/Logout
- [x] Dashboard dengan statistics
- [x] Dokumen CRUD
- [x] Foto CRUD
- [x] Video CRUD
- [x] Link CRUD
- [x] User Management (Admin)
- [x] Activity Logs (Admin)
- [x] Search functionality

### ✅ REST API (Complete)
- [x] Authentication (Login, Register, Logout)
- [x] Dokumen API (CRUD + Download + Search)
- [x] Foto API (CRUD + Search)
- [x] Video API (CRUD + Search)
- [x] Link API (CRUD + Search + Filter by Category)
- [x] User API (Admin only - CRUD + Status Toggle + Activity)

### ✅ Database
- [x] 6 Tables (users, dokumen, foto, video, link, log)
- [x] Foreign keys dengan CASCADE delete
- [x] Soft deletes untuk semua resource
- [x] Timestamps (created_at, updated_at, deleted_at)
- [x] Activity logging

### ✅ Security
- [x] Password hashing (bcrypt)
- [x] Role-based access control
- [x] Authorization checks
- [x] Soft deletes
- [x] IP logging

### ✅ Additional Features
- [x] File upload validation
- [x] Pagination
- [x] Search functionality
- [x] Activity logging system
- [x] Helper functions
- [x] Middleware for auth & authorization

---

## 🧪 Testing API dengan cURL/Postman

### 1. Login dan Get Token
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "dzikri@ukri.ac.id",
    "password": "password"
  }'
```

Response akan berisi token, copy untuk langkah selanjutnya.

### 2. Gunakan Token untuk Request Lain
```bash
curl -X GET http://localhost:8000/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 3. Upload Dokumen
```bash
curl -X POST http://localhost:8000/api/dokumen \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "judul=Test Document" \
  -F "deskripsi=This is a test" \
  -F "file=@/path/to/file.pdf"
```

---

## 📊 Database Struktur

```
users (5 demo users)
├── dokumen (FK: user_id)
├── foto (FK: user_id)
├── video (FK: user_id)
├── link (FK: user_id)
└── log (FK: user_id) - Activity logs
```

---

## 🔧 Next Steps

### Untuk Frontend Developer:
1. Baca [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)
2. Implementasikan frontend sesuai API spec
3. Gunakan token-based authentication (JWT via Sanctum)
4. Handle 401/403 responses

### Untuk Testing:
1. Import [routes/api.php](./routes/api.php) ke Postman
2. Gunakan demo credentials untuk testing
3. Test semua CRUD operations
4. Test search & filtering

### Untuk Deployment:
1. Set .env untuk production
2. Run: `php artisan migrate --force`
3. Run: `php artisan db:seed --force`
4. Set proper file permissions
5. Configure web server (nginx/apache)

---

## 🆘 Troubleshooting

### Migrations Error
```bash
# Reset database
php artisan migrate:fresh
php artisan db:seed
```

### Storage Link Not Working
```bash
# Remove dan create ulang
rm public/storage
php artisan storage:link
```

### Database Connection Error
```bash
# Check .env DB_* variables
# Verify MySQL/MariaDB is running
# Create database manually if needed
```

### Permission Error
```bash
# Windows: Usually not needed
# Linux/Mac:
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

---

## 📞 Architecture Overview

```
┌─────────────────────────────────────────────────┐
│         Frontend (React/Vue/Blade)              │
└──────────────────┬──────────────────────────────┘
                   │
        ┌──────────┴──────────┐
        │                     │
    WEB ROUTES           API ROUTES
    (Blade Views)     (JSON Responses)
        │                     │
        └──────────┬──────────┘
                   │
        ┌──────────▼──────────┐
        │  Controllers        │
        │ (DokumenController) │
        │ (Api/DokumenApi)    │
        └──────────┬──────────┘
                   │
        ┌──────────▼──────────┐
        │  Models             │
        │ (Dokumen, Foto)     │
        │ (Video, Link, Log)  │
        └──────────┬──────────┘
                   │
        ┌──────────▼──────────┐
        │  Database (MySQL)   │
        │ (6 Tables)          │
        └─────────────────────┘
```

---

## ✨ Highlights

✅ **Fully Functional** - Semua fitur sudah berfungsi lengkap  
✅ **Well Documented** - API dan setup dokumentasi lengkap  
✅ **Production Ready** - Error handling, validation, authorization  
✅ **Scalable** - Clean code, proper architecture  
✅ **Secure** - Password hashing, role-based access, logging  
✅ **Easy to Use** - Simple setup, clear structure  

---

## 📈 Statistics

- **Database Tables:** 6
- **API Endpoints:** 30+
- **Controllers:** 13 (7 Web + 6 API)
- **Models:** 6
- **Migrations:** 6
- **Seeders:** 2
- **Middleware:** 3
- **Lines of Code:** 1000+

---

**Backend Development Completed! ✅**

Siap untuk integration dengan frontend atau deployment.

Untuk pertanyaan lebih lanjut, lihat dokumentasi lengkap di folder project.
