# Sistem Arsip Digital UKRI

Backend lengkap untuk sistem manajemen arsip digital Universitas Krisnadwipayana (UKRI).

## 📋 Fitur

- ✅ Autentikasi dengan role-based access control (Admin/User)
- ✅ Manajemen Dokumen (Upload, Edit, Hapus, Download)
- ✅ Manajemen Foto (Upload, Edit, Hapus)
- ✅ Manajemen Video (Upload, Edit, Hapus)
- ✅ Manajemen Link (CRUD)
- ✅ Manajemen User (Admin only)
- ✅ Log Aktivitas sistem
- ✅ Web Interface & REST API
- ✅ Search functionality
- ✅ Soft deletes untuk semua resource

## 🛠️ Teknologi

- **Backend:** Laravel 11
- **Database:** MySQL/MariaDB
- **Authentication:** Laravel Sanctum (untuk API)
- **File Storage:** Local Storage (public disk)
- **API Documentation:** Included

## 📦 Requirements

- PHP 8.2+
- Composer
- MySQL 5.7+ atau MariaDB 10.3+
- Node.js & npm (untuk frontend assets, optional)

## 🚀 Installation

### 1. Clone Repository
```bash
cd c:\laragon\www\arsip-ukri\arsip-ukri
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_ukri
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Seed Database
```bash
php artisan db:seed
```

### 8. Link Storage (untuk file uploads)
```bash
php artisan storage:link
```

### 9. Create Uploads Directory
```bash
mkdir -p storage/app/public/dokumen
mkdir -p storage/app/public/foto
mkdir -p storage/app/public/video
```

### 10. Run Development Server
```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## 📚 Database Structure

### Tables

#### `users`
- id
- nama
- email (unique)
- nim (unique, nullable)
- password
- role (admin/user)
- status
- soft deletes
- timestamps

#### `dokumen`
- id
- judul
- deskripsi
- file_path
- ukuran
- tipe
- user_id (FK)
- soft deletes
- timestamps

#### `foto`
- id
- judul
- deskripsi
- file_path
- ukuran
- user_id (FK)
- soft deletes
- timestamps

#### `video`
- id
- judul
- deskripsi
- file_path
- durasi (nullable)
- ukuran
- user_id (FK)
- soft deletes
- timestamps

#### `link`
- id
- judul
- url
- kategori (nullable)
- deskripsi
- user_id (FK)
- soft deletes
- timestamps

#### `log`
- id
- user_id (FK)
- aksi
- model
- model_id
- keterangan
- ip_address
- timestamps

## 👥 Demo Users

### Admin Account
- **Email:** dzikri@ukri.ac.id
- **Password:** password
- **NIM:** 20241320004

### Regular Users
| Email | NIM | Password |
|-------|-----|----------|
| jilan@ukri.ac.id | 20241320039 | password |
| nosa@ukri.ac.id | 20241320025 | password |
| sahrul@ukri.ac.id | 20241320031 | password |
| eka@ukri.ac.id | 20241320014 | password |

## 🔌 API Endpoints

### Authentication
- `POST /api/login` - Login user
- `POST /api/register` - Register user baru
- `POST /api/logout` - Logout user
- `GET /api/me` - Get current user info
- `PUT /api/profile` - Update profile
- `POST /api/change-password` - Ubah password

### Resources (CRUD)
- `/api/dokumen` - Dokumen management
- `/api/foto` - Foto management
- `/api/video` - Video management
- `/api/link` - Link management
- `/api/users` - User management (admin only)

### Search & Filter
- `GET /api/dokumen/search/{query}` - Cari dokumen
- `GET /api/foto/search/{query}` - Cari foto
- `GET /api/video/search/{query}` - Cari video
- `GET /api/link/search/{query}` - Cari link
- `GET /api/link/category/{category}` - Filter link by kategori

Lihat [API_DOCUMENTATION.md](./API_DOCUMENTATION.md) untuk dokumentasi lengkap.

## 🖥️ Web Routes

### Public
- `/` - Login page
- `/login` (POST) - Process login
- `/logout` (POST) - Process logout

### Protected (Require Login)
- `/dashboard` - Dashboard
- `/dokumen` - List dokumen
- `/foto` - List foto
- `/video` - List video
- `/link` - List link
- `/pencarian` - Search page

### Admin Only
- `/users` - User management
- `/log` - Activity logs
- `/log/export` - Export logs

## 🎯 File Structure

```
app/
  ├── Http/
  │   ├── Controllers/
  │   │   ├── Api/              # API Controllers
  │   │   │   ├── AuthApiController.php
  │   │   │   ├── DokumenApiController.php
  │   │   │   ├── FotoApiController.php
  │   │   │   ├── VideoApiController.php
  │   │   │   ├── LinkApiController.php
  │   │   │   └── UserApiController.php
  │   │   ├── AuthController.php
  │   │   ├── DokumenController.php
  │   │   ├── FotoController.php
  │   │   ├── VideoController.php
  │   │   ├── LinkController.php
  │   │   ├── UserController.php
  │   │   └── LogController.php
  │   └── Middleware/
  │       ├── AuthSession.php
  │       ├── AdminRole.php
  │       └── RoleAdmin.php
  ├── Models/
  │   ├── User.php
  │   ├── Dokumen.php
  │   ├── Foto.php
  │   ├── Video.php
  │   ├── Link.php
  │   └── Log.php
  └── Helpers/
      └── AppHelper.php
routes/
  ├── web.php               # Web routes
  └── api.php               # API routes
database/
  ├── migrations/           # Database migrations
  └── seeders/              # Database seeders
```

## 🔐 Security

- Password di-hash menggunakan bcrypt
- Soft deletes untuk data protection
- Role-based authorization
- IP logging untuk audit trail
- Activity logging untuk semua operasi

## 📝 Implementation Notes

### Models
Semua model memiliki relationship dengan User:
```php
// User -> Dokumen/Foto/Video/Link
$user->dokumen();
$user->foto();
$user->video();
$user->link();
```

### Authorization
- Admin dapat melihat semua resource
- User hanya dapat melihat resource miliknya sendiri
- Owner dapat edit/delete resource miliknya

### Activity Logging
Semua operasi CREATE, UPDATE, DELETE di-log:
```php
LogModel::create([
    'user_id' => $user->id,
    'aksi' => 'upload_dokumen',
    'model' => 'Dokumen',
    'model_id' => $dokumen->id,
    'keterangan' => 'Upload dokumen...',
    'ip_address' => request()->ip(),
]);
```

## 🧪 Testing

### Run Tests
```bash
php artisan test
```

### Manual Testing dengan Postman/cURL
1. Login: `POST /api/login`
2. Copy token dari response
3. Gunakan token di Authorization header untuk request selanjutnya

## 📊 Database Backup

### Export Data
```bash
php artisan db:seed
```

### Import Data
```bash
mysql -u root arsip_ukri < backup.sql
```

## 🐛 Troubleshooting

### Migration Error
```bash
php artisan migrate:fresh
php artisan db:seed
```

### Permission Error on Storage
```bash
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
```

### File Upload Not Working
```bash
php artisan storage:link
mkdir -p storage/app/public/{dokumen,foto,video}
chmod -R 777 storage/app/public/
```

## 📞 Support

Untuk pertanyaan atau issue, hubungi tim development.

## 📄 License

Proprietary - Universitas Krisnadwipayana

---

**Last Updated:** 2026-06-17
