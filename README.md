# 📁 Arsip Digital UKRI — Laravel

<p align="center">
	<img src="public/images/ukri.jpg" alt="UKRI Logo" width="110" />
</p>

Versi ringkas dan panduan singkat untuk menjalankan proyek Sistem Arsip Digital berbasis Laravel.

## Ringkasan

Proyek ini adalah backend Laravel untuk pengelolaan dokumen, foto, video, dan tautan dengan fitur:
- Autentikasi berbasis session
- CRUD untuk Dokumen / Foto / Video / Link
- Manajemen pengguna (admin)
- Pencarian dan logging aktivitas

## Persyaratan

- PHP 8.1+ (direkomendasikan PHP 8.2)
- Composer
- MySQL / MariaDB (opsional jika ingin menggunakan database)
- Node.js & npm (opsional, untuk pengelolaan asset)

Periksa versi PHP dan Composer:

```bash
php -v
composer -v
```

## Instalasi (cepat)

Jalankan dari folder proyek:

```bash
cd c:\Users\hp\Downloads\arsip-ukri
composer install
copy .env.example .env    # Windows
php artisan key:generate
# (opsional) konfigurasi DB pada .env jika ingin migrate
php artisan storage:link
php artisan serve
```

Buka http://localhost:8000 di browser.

## Konfigurasi Database (opsional)

Jika ingin menggunakan database nyata:

1. Buat database (contoh MySQL):

```sql
CREATE DATABASE arsip_ukri CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Edit `.env`:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_ukri
DB_USERNAME=root
DB_PASSWORD=
```

3. Jalankan migrasi dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

## Storage & Uploads

Pastikan `public/storage` terhubung ke `storage/app/public`:

```bash
php artisan storage:link
```

Folder upload ada di `storage/app/public/{dokumen,foto,video,link}` dan tersedia via `http://localhost:8000/storage/...`.

Jika `php artisan storage:link` gagal karena `public/storage` sudah ada, pindahkan/migrasikan isinya lalu hapus folder tersebut sebelum membuat symlink.

## Menjalankan (ringkas)

```bash
# jalankan server development
php artisan serve

# (opsional) build assets jika melakukan perubahan frontend
npm install
npm run dev
```

## Akun Demo (untuk pengujian)

Gunakan email/password berikut di environment demo (jika tersedia):

- dzikri@ukri.ac.id / password (Admin)
- jilan@ukri.ac.id / password (User)

Jika tidak ada pengguna di database, jalankan seeder (lihat bagian Database).

## Preview Dokumen

- PDF dapat di-preview langsung di browser.
- DOCX biasanya tidak langsung tampil di iframe — gunakan tombol Download atau konversi ke PDF bila perlu.

## Troubleshooting singkat

- Composer cepat selesai (Nothing to install) — itu normal jika semua dependensi sudah terpasang.
- Jika file upload tidak muncul: pastikan `php artisan storage:link` sudah benar dan file ada di `storage/app/public`.
- Jika link eksternal gagal terbuka, cek apakah value `url` tersimpan dengan protokol (`http://` atau `https://`). Aplikasi menambahkan `https://` bila tidak ada.

## Perintah berguna

```bash
composer install
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

## Struktur singkat

```
app/             # Controllers, Models, Helpers
public/          # entrypoint, css, js, public/storage (symlink)
resources/views/ # blade templates
routes/web.php   # routes
database/        # migrations & seeders
```

---

