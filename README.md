<img width="2515" height="1338" alt="image" src="https://github.com/user-attachments/assets/fdf16c96-cfa7-4970-991d-dff953d706f4" />
🏟️ FitRent – Sistem Peminjaman dan Manajemen Unit Lapangan

👥 Nama Kelompok
Kelompok Teh Poci - FitRent Development Team

🧑‍💻 Nama Team
Team FitRent
- Farid Ghani
- Charles Ricky Barnabas

💡 Nama Project
FitRent – Sistem Informasi Peminjaman Lapangan dan Unit Olahraga

⚙️ Deskripsi Singkat
FitRent adalah sistem web untuk mengelola penyewaan dan pengembalian lapangan olahraga dengan peran Superadmin, Admin Lapangan, dan User (Anggota).
Sistem ini mendukung manajemen data unit/lapangan, kategori, peminjaman, pengembalian, denda otomatis, dan laporan riwayat penyewaan.

🚀 Daftar Fitur dan Penjelasan
👥 1. Jenis Anggota
Superadmin → Mengelola seluruh data sistem (admin, user, kategori, unit, dan transaksi).
Admin Lapangan → Mengelola unit/lapangan, kategori, user, transaksi, serta memverifikasi pengembalian.
User (Anggota) → Login, sewa lapangan (maksimal 2 lapangan berbeda), upload bukti pengembalian.
Implementasi:
Tabel users memiliki kolom role yang menentukan hak akses.
Middleware auth dan role digunakan untuk membatasi halaman antar peran.

🔐 2. Autentikasi (Login & Registrasi)
Setiap user wajib login untuk mengakses sistem.
Menggunakan Laravel Auth (breeze/ui) dengan middleware auth.
Setelah login, dashboard menyesuaikan role pengguna.

🧾 3. Registrasi & Profil User
User harus mendaftar terlebih dahulu untuk dapat meminjam unit.
Setiap user hanya memiliki satu profil unik.
User dapat mengubah profil melalui halaman “Edit Profil”.
Implementasi:
Relasi User → Profile (one to one)
Validasi input pada setiap field (required, email, unique)

🏷️ 4. Kategori dan Unit
Setiap unit dapat memiliki multiple kategori (Many-to-Many).
Kode unit bersifat unik, nama unit boleh sama.
Implementasi:
Tabel: units, categories, dan category_unit (pivot table).
Validasi unique:units,kode_unit di controller saat menambah data.

🔍 5. Pencarian Unit
User dapat mencari unit berdasarkan nama unit.
Query where('nama_unit', 'LIKE', '%keyword%') digunakan pada controller.

🧑‍💼 6. CRUD oleh Admin
Admin dapat melakukan:
Tambah, Edit, Hapus data unit, kategori, dan user (anggota).
Implementasi:
Controller: AdminController, UnitController, CategoryController, UserController
Route dengan prefix /admin dan middleware role:admin.

⏱️ 7. Aturan Penyewaan (Real FitRent Logic)
Setiap user hanya boleh menyewa maksimal 2 lapangan berbeda.
Sistem akan menolak jika user mencoba menyewa lapangan yang sama dua kali, atau lebih dari dua total lapangan aktif.
Admin atau sistem akan memvalidasi ketersediaan lapangan sebelum disewa.
Data penyewaan mencakup:
- Tanggal dan jam mulai sewa
- Tanggal dan jam selesai sewa
- Status (active, waiting_approval, returned)

🔁 8. Pengembalian Unit
Proses pengembalian lapangan di FitRent tidak otomatis — user wajib mengajukan konfirmasi dengan bukti dan waktu aktual.
🧍‍♂️ Langkah oleh User:
- Upload bukti foto bahwa lapangan sudah kosong.
- Isi tanggal dan jam pengembalian aktual.
- Sistem menyimpan data dan mengubah status transaksi jadi waiting_approval.
- Admin menerima notifikasi untuk memverifikasi pengembalian.
🧑‍💼 Langkah oleh Admin:
- Admin membuka detail pengembalian dan melihat bukti foto + waktu pengembalian.
- Sistem menghitung selisih waktu keterlambatan antara jam seharusnya dan jam aktual.
- Jika keterlambatan ≤ 15 menit, tidak dikenakan denda.
- Jika keterlambatan > 15 menit, maka dihitung:
    Rp50.000 per 5 menit keterlambatan setelah 15 menit pertama.
Contoh:
Telat 20 menit → 15 menit aman, 5 menit denda → Rp50.000
Telat 30 menit → 15 menit aman, 15 menit denda → 3 × Rp50.000 = Rp150.000
Admin menyetujui pengembalian → status berubah ke returned.
Unit otomatis jadi “available” dan bisa disewa lagi.

📋 9. Riwayat & Laporan
Admin dapat melihat semua riwayat peminjaman user dan mencetak laporan.
User hanya dapat melihat riwayat miliknya sendiri.
Implementasi:
Filtering berdasarkan auth()->user()->role.
Menggunakan DOMPDF untuk cetak laporan PDF.

✅ 10. Validasi Field
Setiap form penting menggunakan validasi Laravel ($request->validate()):
required, unique, email, numeric, date
Validasi mencegah data kosong dan duplikasi pada proses input/update.

🧱 11. Database & Seeder
Struktur tabel meliputi:
users, profiles, categories, units, category_unit, borrows, returns
Seeder awal:
1 Superadmin, 1 Admin, beberapa User
Beberapa kategori (misal: Futsal, Badminton)
Unit contoh (Lapangan 1, Lapangan 2, dst)

Seeder: UserSeeder, CategorySeeder, UnitSeeder
Dijalankan dengan:
php artisan migrate --seed

🗺️ Skema Database
Tambahkan gambar hasil ERD / skema dari phpMyAdmin:


🎥 Demo Website
Tambahkan link video demo:


🧰 Teknologi yang Digunakan
Laravel 10 (Framework utama)
MySQL (Database)
Blade Template (Frontend View)
Bootstrap / TailwindCSS (Styling)
DOMPDF (Laporan PDF)
Laravel Auth (breeze/ui) (Autentikasi)

⚙️ Cara Menjalankan Project
git clone https://github.com/username/FitRent.git
cd FitRent
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
