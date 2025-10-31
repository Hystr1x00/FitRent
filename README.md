# 🏟️ FitRent - Sistem Peminjaman dan Manajemen Lapangan Olahraga

![FitRent Banner](https://github.com/user-attachments/assets/fdf16c96-cfa7-4970-991d-dff953d706f4)

## 📋 Daftar Isi
- [Tentang Project](#tentang-project)
- [Tim Pengembang](#tim-pengembang)
- [Fitur Utama](#fitur-utama)
- [Teknologi](#teknologi)
- [Database Schema](#database-schema)
- [Instalasi](#instalasi)
- [Demo](#demo)

---

## 🎯 Tentang Project

**FitRent** adalah sistem informasi berbasis web untuk mengelola penyewaan dan pengembalian lapangan olahraga dengan manajemen pengguna multi-role (Superadmin, Admin Lapangan, dan User).

Sistem ini mendukung manajemen data unit/lapangan, kategori, peminjaman, pengembalian dengan verifikasi, perhitungan denda otomatis, dan laporan riwayat penyewaan.

---

## 👥 Tim Pengembang

**Kelompok Teh Poci - FitRent Development Team**

| Nama | Role |
|------|------|
| Farid Ghani | Developer |
| Charles Ricky Barnabas | Developer |

---

## ✨ Fitur Utama

### 1. 👥 Manajemen Multi-Role
- **Superadmin** - Mengelola seluruh data sistem (admin, user, kategori, unit, dan transaksi)
- **Admin Lapangan** - Mengelola unit/lapangan, kategori, user, transaksi, serta memverifikasi pengembalian
- **User (Anggota)** - Login, sewa lapangan (maksimal 2 lapangan berbeda), upload bukti pengembalian

**Implementasi:**
- Tabel `users` memiliki kolom `role` yang menentukan hak akses
- Middleware `auth` dan `role` digunakan untuk membatasi halaman antar peran

### 2. 🔐 Autentikasi & Registrasi
- Sistem login wajib untuk semua pengguna
- Menggunakan Laravel Auth (Breeze/UI) dengan middleware
- Dashboard menyesuaikan dengan role pengguna
- Setiap user memiliki satu profil unik dengan fitur edit profil

**Implementasi:**
- Relasi `User → Profile` (one to one)
- Validasi input ketat (required, email, unique)

### 3. 🏷️ Manajemen Kategori & Unit
- Setiap unit dapat memiliki multiple kategori (Many-to-Many)
- Kode unit bersifat unik, nama unit boleh sama
- Pencarian unit berdasarkan nama

**Implementasi:**
- Tabel: `units`, `categories`, dan `category_unit` (pivot table)
- Validasi `unique:units,kode_unit` pada controller
- Query pencarian: `where('nama_unit', 'LIKE', '%keyword%')`

### 4. 🧑‍💼 CRUD Admin
Admin dapat melakukan operasi:
- ✅ Tambah, Edit, Hapus data unit
- ✅ Kelola kategori lapangan
- ✅ Manajemen user (anggota)

**Implementasi:**
- Controllers: `AdminController`, `UnitController`, `CategoryController`, `UserController`
- Route dengan prefix `/admin` dan middleware `role:admin`

### 5. ⏱️ Aturan Penyewaan
**Batasan:**
- User hanya boleh menyewa **maksimal 2 lapangan berbeda**
- Tidak boleh menyewa lapangan yang sama dua kali
- Validasi ketersediaan lapangan oleh sistem

**Data Penyewaan:**
- Tanggal dan jam mulai sewa
- Tanggal dan jam selesai sewa
- Status: `active`, `waiting_approval`, `returned`

### 6. 🔁 Sistem Pengembalian dengan Verifikasi

#### 🧍‍♂️ Proses oleh User:
1. Upload bukti foto lapangan sudah kosong
2. Isi tanggal dan jam pengembalian aktual
3. Status transaksi berubah jadi `waiting_approval`
4. Admin menerima notifikasi untuk verifikasi

#### 🧑‍💼 Proses oleh Admin:
1. Admin melihat detail pengembalian + bukti foto
2. Sistem menghitung keterlambatan otomatis
3. **Perhitungan Denda:**
   - ✅ Keterlambatan ≤ 15 menit: **Tidak ada denda**
   - ❌ Keterlambatan > 15 menit: **Rp50.000 per 5 menit** (setelah 15 menit pertama)

**Contoh Perhitungan:**
```
Telat 20 menit → 15 menit aman, 5 menit denda
→ Denda: Rp50.000

Telat 30 menit → 15 menit aman, 15 menit denda (3 × 5 menit)
→ Denda: 3 × Rp50.000 = Rp150.000
```

4. Admin menyetujui pengembalian → status berubah ke `returned`
5. Unit otomatis tersedia untuk disewa lagi

### 7. 📋 Riwayat & Laporan
- Admin dapat melihat **semua riwayat peminjaman** dan mencetak laporan
- User hanya melihat **riwayat miliknya sendiri**

**Implementasi:**
- Filtering berdasarkan `auth()->user()->role`
- Export laporan PDF menggunakan **DOMPDF**

### 8. ✅ Validasi Data
Setiap form menggunakan validasi Laravel (`$request->validate()`):
- `required` - Field wajib diisi
- `unique` - Tidak boleh duplikat
- `email` - Format email valid
- `numeric` - Hanya angka
- `date` - Format tanggal valid

### 9. 🧱 Database & Seeder

**Struktur Tabel:**
- `users` - Data pengguna dan role
- `profiles` - Profil detail pengguna
- `categories` - Kategori lapangan
- `units` - Data lapangan/unit
- `category_unit` - Relasi many-to-many
- `borrows` - Data peminjaman
- `returns` - Data pengembalian

**Seeder Awal:**
- 1 Superadmin
- 1 Admin
- Beberapa User contoh
- Kategori: Futsal, Badminton, dll.
- Unit: Lapangan 1, Lapangan 2, dst.

**Menjalankan Seeder:**
```bash
php artisan migrate --seed
```

---

## 🛠️ Teknologi

| Teknologi | Kegunaan |
|-----------|----------|
| Laravel 10 | Framework utama |
| MySQL | Database |
| Blade Template | Frontend View |
| Bootstrap / TailwindCSS | Styling |
| DOMPDF | Export laporan PDF |
| Laravel Breeze/UI | Autentikasi |

---

## 🗺️ Database Schema

![Database ERD](link-ke-gambar-erd-anda)

> *Tambahkan screenshot ERD dari phpMyAdmin atau tool modeling database*

---

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (opsional, untuk asset)

### Langkah Instalasi

```bash
# Clone repository
git clone https://github.com/username/FitRent.git
cd FitRent

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Konfigurasi database di file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitrent
DB_USERNAME=root
DB_PASSWORD=

# Migrasi database dan seed data
php artisan migrate --seed

# Jalankan server
php artisan serve
```

Buka browser dan akses: `http://localhost:8000`

### Login Default

| Role | Email | Password |
|------|-------|----------|
| Superadmin | superadmin@fitrent.com | password |
| Admin | admin@fitrent.com | password |
| User | user@fitrent.com | password |

---

## 🎥 Demo

### 📹 Video Demo
[Link Video Demo](link-youtube-atau-drive)

### 📸 Screenshots
> *Tambahkan beberapa screenshot aplikasi*

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik/portfolio.

---

## 📞 Kontak

Untuk pertanyaan atau saran, hubungi:
- **Email:** [email-team@example.com]
- **GitHub:** [github.com/username]

---

<div align="center">
  <strong>Dibuat dengan ❤️ oleh Kelompok Teh Poci</strong>
</div>