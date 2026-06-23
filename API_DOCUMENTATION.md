# API Documentation - Sistem Arsip Digital UKRI

## Base URL
```
http://localhost:8000/api
```

## Authentication
API menggunakan Laravel Sanctum untuk token-based authentication.

### Login
**Endpoint:** `POST /api/login`

**Request:**
```json
{
  "email": "dzikri@ukri.ac.id",
  "password": "password"
}
```

**Response (200):**
```json
{
  "data": {
    "user": {
      "id": 1,
      "nama": "M. Dzikri Sagara",
      "email": "dzikri@ukri.ac.id",
      "role": "admin",
      "status": true
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz"
  },
  "message": "Login berhasil"
}
```

### Register
**Endpoint:** `POST /api/register`

**Request:**
```json
{
  "nama": "John Doe",
  "email": "john@example.com",
  "nim": "20241320001",
  "password": "password",
  "password_confirmation": "password"
}
```

**Response (201):** Same as Login

### Logout
**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "message": "Logout berhasil"
}
```

### Get Current User
**Endpoint:** `GET /api/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "nama": "M. Dzikri Sagara",
    "email": "dzikri@ukri.ac.id",
    "role": "admin"
  }
}
```

---

## Resources

### Dokumen

#### Get All Dokumen
**Endpoint:** `GET /api/dokumen`

**Parameters:**
- `page` (optional): Halaman (default: 1)
- `per_page` (optional): Item per halaman (default: 15)

**Response (200):**
```json
{
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "judul": "Laporan KKN 2026.pdf",
        "deskripsi": "Laporan lengkap KKN",
        "file_path": "dokumen/filename.pdf",
        "ukuran": "2.4 MB",
        "tipe": "PDF",
        "user_id": 2,
        "created_at": "2026-06-17T10:00:00Z"
      }
    ],
    "last_page": 5,
    "total": 75
  }
}
```

#### Create Dokumen
**Endpoint:** `POST /api/dokumen`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request:**
- `judul` (required): string, max 255
- `file` (required): file, max 50MB
- `deskripsi` (optional): string, max 1000

**Response (201):**
```json
{
  "data": {
    "id": 5,
    "judul": "Dokumen Baru",
    "file_path": "dokumen/new-file.pdf",
    "created_at": "2026-06-17T10:00:00Z"
  },
  "message": "Dokumen berhasil diupload"
}
```

#### Get Dokumen Detail
**Endpoint:** `GET /api/dokumen/{id}`

**Response (200):** Single dokumen object

#### Update Dokumen
**Endpoint:** `PUT /api/dokumen/{id}`

**Request:**
```json
{
  "judul": "Updated Title",
  "deskripsi": "Updated description"
}
```

**Response (200):** Updated dokumen object

#### Delete Dokumen
**Endpoint:** `DELETE /api/dokumen/{id}`

**Response (200):**
```json
{
  "message": "Dokumen berhasil dihapus"
}
```

#### Download Dokumen
**Endpoint:** `POST /api/dokumen/{id}/download`

**Response:** File download

#### Search Dokumen
**Endpoint:** `GET /api/dokumen/search/{query}`

**Response (200):** Array of matching dokumen

---

### Foto

Same endpoints as Dokumen:
- `GET /api/foto`
- `POST /api/foto`
- `GET /api/foto/{id}`
- `PUT /api/foto/{id}`
- `DELETE /api/foto/{id}`
- `GET /api/foto/search/{query}`

**Max file size:** 10MB (image only)

---

### Video

Same endpoints as Dokumen:
- `GET /api/video`
- `POST /api/video`
- `GET /api/video/{id}`
- `PUT /api/video/{id}`
- `DELETE /api/video/{id}`
- `GET /api/video/search/{query}`

**Max file size:** 512MB (mp4, avi, mkv, mov, webm)

---

### Link

#### Get All Links
**Endpoint:** `GET /api/link`

#### Create Link
**Endpoint:** `POST /api/link`

**Request:**
```json
{
  "judul": "Portal Mahasiswa",
  "url": "https://portal.ukri.ac.id",
  "kategori": "akademik",
  "deskripsi": "Portal akademik mahasiswa"
}
```

#### Get Link Detail
**Endpoint:** `GET /api/link/{id}`

#### Update Link
**Endpoint:** `PUT /api/link/{id}`

#### Delete Link
**Endpoint:** `DELETE /api/link/{id}`

#### Search Link
**Endpoint:** `GET /api/link/search/{query}`

#### Get Links by Category
**Endpoint:** `GET /api/link/category/{category}`

---

### Users (Admin Only)

#### Get All Users
**Endpoint:** `GET /api/users`

**Response (200):**
```json
{
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "nama": "M. Dzikri Sagara",
        "email": "dzikri@ukri.ac.id",
        "nim": "20241320004",
        "role": "admin",
        "status": true
      }
    ]
  }
}
```

#### Create User
**Endpoint:** `POST /api/users`

**Request:**
```json
{
  "nama": "New User",
  "email": "newuser@ukri.ac.id",
  "nim": "20241320100",
  "password": "password",
  "role": "user"
}
```

#### Get User Detail
**Endpoint:** `GET /api/users/{id}`

#### Update User
**Endpoint:** `PUT /api/users/{id}`

**Request:**
```json
{
  "nama": "Updated Name",
  "email": "updated@ukri.ac.id",
  "nim": "20241320100",
  "role": "user"
}
```

#### Delete User
**Endpoint:** `DELETE /api/users/{id}`

#### Toggle User Status
**Endpoint:** `POST /api/users/{id}/toggle-status`

**Response (200):**
```json
{
  "data": {
    "id": 2,
    "status": false
  },
  "message": "Status user berhasil diubah"
}
```

#### Get User Activity
**Endpoint:** `GET /api/users/{id}/activity`

**Response (200):**
```json
{
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "aksi": "upload_dokumen",
        "model": "Dokumen",
        "model_id": 5,
        "keterangan": "Upload dokumen: Laporan KKN",
        "created_at": "2026-06-17T10:00:00Z"
      }
    ]
  }
}
```

---

## Error Responses

### 401 Unauthorized
```json
{
  "error": "Email atau password salah"
}
```

### 403 Forbidden
```json
{
  "error": "Akses ditolak. Hanya admin yang dapat mengakses resource ini."
}
```

### 404 Not Found
```json
{
  "error": "Resource tidak ditemukan"
}
```

### 422 Unprocessable Content
```json
{
  "errors": {
    "email": ["Email sudah terdaftar"],
    "password": ["Password minimal 6 karakter"]
  }
}
```

### 500 Internal Server Error
```json
{
  "error": "Gagal memproses request"
}
```

---

## Demo Users

### Admin
- Email: `dzikri@ukri.ac.id`
- Password: `password`

### Regular Users
- Email: `jilan@ukri.ac.id`
- Email: `nosa@ukri.ac.id`
- Email: `sahrul@ukri.ac.id`
- Email: `eka@ukri.ac.id`
- Password: `password` (all)

---

## Implementation Notes

- Token harus dikirim di header `Authorization: Bearer {token}`
- Semua request menggunakan JSON format
- Timestamps dalam format ISO 8601 UTC
- Pagination default 15 items per page
- Admin dapat melihat semua resource, user hanya melihat resource miliknya
