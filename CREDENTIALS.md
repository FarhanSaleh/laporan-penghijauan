# Kredensial Login

Berikut adalah daftar user yang telah dibuat oleh seeder:

## Admin
- **Email**: admin@example.com
- **Password**: password
- **Role**: admin
- **Nama**: Admin Sistem

## Petugas
1. **Email**: petugas@example.com
   - **Password**: password
   - **Role**: petugas
   - **Nama**: Petugas Lapangan

2. **Email**: petugas2@example.com
   - **Password**: password
   - **Role**: petugas
   - **Nama**: Petugas 2

## User Biasa
1. **Email**: user@example.com
   - **Password**: password
   - **Role**: user
   - **Nama**: User Biasa

2. **Email**: john@example.com
   - **Password**: password
   - **Role**: user
   - **Nama**: John Doe

---

## Cara Menggunakan

1. Akses halaman login: `/login`
2. Masukkan email dan password dari daftar di atas
3. Klik tombol "Login"
4. Anda akan diarahkan ke halaman dashboard

## Cara Menjalankan Seeder

```bash
# Fresh migration dengan seeder
php artisan migrate:fresh --seed

# Hanya jalankan seeder
php artisan db:seed

# Jalankan seeder tertentu
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
```

## Fitur yang Tersedia

### 1. Autentikasi
- Login dengan email dan password
- Remember me functionality
- Logout

### 2. Role-Based Access Control
- 3 Role: Admin, Petugas, User
- Middleware untuk proteksi route berdasarkan role
- Helper methods di User model:
  - `isAdmin()` - Cek apakah user adalah admin
  - `isPetugas()` - Cek apakah user adalah petugas
  - `isUser()` - Cek apakah user adalah user biasa
  - `hasRole($role)` - Cek role tertentu

### 3. Contoh Penggunaan Middleware Role

```php
// Route khusus admin
Route::middleware('role:admin')->group(function () {
    // routes...
});

// Route untuk admin dan petugas
Route::middleware('role:admin,petugas')->group(function () {
    // routes...
});
```

### 4. Contoh Route yang Tersedia
- `/login` - Halaman login
- `/dashboard` - Dashboard (semua user yang sudah login)
- `/admin` - Halaman admin (hanya admin)
- `/laporan` - Halaman laporan (admin dan petugas)

## Model dan Relasi

### User Model
- Relasi: `belongsTo(Role::class)`
- Fillable: `nama`, `email`, `password`, `role_id`

### Role Model
- Relasi: `hasMany(User::class)`
- Fillable: `name`
