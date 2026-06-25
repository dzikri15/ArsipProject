# 📁 Arsip Digital UKRI

<p align="center">
  <img src="public/images/ukri.jpg" alt="UKRI Logo" width="120" style="border-radius:12px;" />
</p>

<p align="center">
  <strong>Sistem Arsip Dokumen Digital — Universitas Kebangsaan Republik Indonesia</strong><br/>
  <em>Kelompok 6 · Manajemen Proyek Sistem Informasi · 2026</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" />
  <img src="https://img.shields.io/badge/Status-Production Ready-brightgreen?style=for-the-badge" />
</p>

---

## ✨ Fitur Utama

| Fitur | Status |
|---|---|
| 🔐 Autentikasi (Session-based) | ✅ Selesai |
| 📄 CRUD Arsip Dokumen | ✅ Selesai |
| 🖼️ CRUD Arsip Foto | ✅ Selesai |
| 🎬 CRUD Arsip Video | ✅ Selesai |
| 🔗 CRUD Arsip Link | ✅ Selesai |
| 👥 Manajemen User oleh Admin | ✅ Selesai |
| 📋 Log Aktivitas | ✅ Selesai |
| 🔍 Pencarian Arsip | ✅ Selesai |
| 🌐 REST API (Sanctum) | ✅ Selesai |
| 📱 Responsivitas Mobile | ✅ Selesai |

---

## 🛠️ Tech Stack

<p align="left">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white" height="28"/>
  <img src="https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white" height="28"/>
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white" height="28"/>
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white" height="28"/>
  <img src="https://img.shields.io/badge/Blade-FF2D20?style=flat-square&logo=laravel&logoColor=white" height="28"/>
  <img src="https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white" height="28"/>
  <img src="https://img.shields.io/badge/Laragon-0E83CD?style=flat-square&logo=laragon&logoColor=white" height="28"/>
  <img src="https://img.shields.io/badge/Git-F05032?style=flat-square&logo=git&logoColor=white" height="28"/>
</p>

---

## ⚙️ Persyaratan Sistem

| Komponen | Versi Minimum | Rekomendasi |
|---|---|---|
| ![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white) | 8.1+ | **8.2** |
| ![Composer](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=white) | 2.x | Latest |
| ![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white) | 5.7+ | **8.0** |
| ![Node.js](https://img.shields.io/badge/Node.js-339933?logo=nodedotjs&logoColor=white) | 16+ | Latest (opsional) |

Cek versi yang terpasang:
```bash
php -v
composer -v
mysql --version
```

---

## 🚀 Instalasi Cepat

### 1. Clone / Ekstrak Proyek
```bash
git clone https://github.com/dzikri15/ArsipProject
```

### 2. Install Dependensi
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
copy .env.example .env        # Windows
# cp .env.example .env        # Linux/Mac

php artisan key:generate
```

### 4. Setup Database

Buat database di MySQL terlebih dahulu:
```sql
CREATE DATABASE arsip_ukri CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Edit file `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_ukri
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi dan seeder:
```bash
php artisan migrate
php artisan db:seed
```

### 5. Setup Storage
```bash
php artisan storage:link
```

> ⚠️ Jika error karena `public/storage` sudah ada, hapus dulu lalu jalankan ulang.

### 6. Jalankan Server
```bash
php artisan serve
```

Buka **http://localhost:8000** di browser. 🎉

---

## 🗄️ Struktur Database

```
arsip_ukri/
├── users          → Data pengguna (role: admin / user)
├── dokumens       → Arsip dokumen (PDF, DOCX, XLSX, dll)
├── fotos          → Arsip foto (JPG, PNG, WEBP, dll)
├── videos         → Arsip video (MP4, AVI, MOV, dll)
├── links          → Arsip tautan URL
└── aktivitas_logs → Riwayat aktivitas pengguna
```

---

## 📂 Struktur Folder

```
arsip-ukri/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # AuthController, DokumenController, dll
│   │   └── Middleware/      # AuthSession, RoleAdmin
│   └── Models/              # User, Dokumen, Foto, Video, Link, AktivitasLog
├── database/
│   ├── migrations/          # Skema tabel
│   └── seeders/             # Data awal (UserSeeder)
├── public/
│   ├── images/              # Logo & aset gambar
│   └── storage/             # Symlink → storage/app/public
├── resources/views/         # Blade templates
├── routes/
│   ├── web.php              # Route web (session-based)
│   └── api.php              # Route API (Sanctum)
└── storage/app/public/
    ├── dokumen/             # File dokumen yang diupload
    ├── foto/                # File foto yang diupload
    ├── video/               # File video yang diupload
    └── link/                # (metadata link)
```

---

## 👤 Akun Demo

| Role | Email | Password |
|---|---|---|
| 👑 **Admin** | dzikri@ukri.ac.id | password |
| 👤 **User** | jilan@ukri.ac.id | password |

> Jalankan `php artisan db:seed` jika akun belum tersedia.

---

## 🔑 Hak Akses (Role)

| Fitur | Admin | User |
|---|---|---|
| Login & Logout | ✅ | ✅ |
| Lihat & Kelola Arsip Sendiri | ✅ | ✅ |
| Lihat Arsip Semua User | ✅ | ❌ |
| Buat Akun User Baru | ✅ | ❌ |
| Lihat Log Aktivitas | ✅ | ❌ |
| Kelola Semua Arsip | ✅ | ❌ |

---

## 📦 Perintah Berguna

```bash
# Install dependensi
composer install

# Generate app key
php artisan key:generate

# Migrasi database
php artisan migrate

# Jalankan seeder
php artisan db:seed

# Reset & migrasi ulang (hati-hati: data hilang!)
php artisan migrate:fresh --seed

# Buat symlink storage
php artisan storage:link

# Jalankan server lokal
php artisan serve

# Build asset frontend (opsional)
npm install && npm run dev

# Lihat semua route
php artisan route:list
```

---

## 🔧 Troubleshooting

| Masalah | Solusi |
|---|---|
| File upload tidak tampil | Jalankan `php artisan storage:link` |
| `public/storage` sudah ada | Hapus folder/symlink lama, lalu jalankan `storage:link` ulang |
| Error 403 / Unauthorized | Pastikan role user sudah benar di tabel `users` |
| Composer lambat | Gunakan `composer install --no-dev` untuk production |
| Link eksternal tidak terbuka | Pastikan URL tersimpan dengan `http://` atau `https://` |
| Halaman kosong / 500 error | Cek file `.env` dan pastikan `APP_KEY` sudah di-generate |

---

## 👨‍💻 Tim Pengembang

| Nama | NIM | Peran |
|---|---|---|
| M. Dzikri Sagara | 20241320004 | Project Manager |
| Jilan Jalilah | 20241320039 | System Analyst |
| Nosa Putra | 20241320025 | Frontend Developer |
| Ahmad Sahrul P | 20241320031 | Backend Developer |
| Eka Pebryanto | 20241320014 | Quality Assurance |

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademik Mata Kuliah **Manajemen Proyek Sistem Informasi**, Program Studi Sistem Informasi, **Universitas Kebangsaan Republik Indonesia (UKRI)** — 2026.

---

<p align="center">
  Made with ❤️ by Kelompok 6 · UKRI 2026
</p>
