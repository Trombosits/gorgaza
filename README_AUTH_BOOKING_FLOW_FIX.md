# GOR GAZA Auth Booking Flow Fix

Patch ini memperbaiki alur booking agar sesuai session login custom project GOR GAZA.

## Fix utama
- Route login/register diberi name yang benar.
- Route booking, booking schedule, booking confirm, pembayaran, dan POST booking wajib login.
- Middleware baru `customer.auth` memakai `session('auth_user')`, bukan Laravel Auth bawaan.
- User yang belum login diarahkan ke `/login` dan intended URL disimpan.
- Setelah login customer, user diarahkan kembali ke halaman booking yang ingin dibuka.
- BookingController memakai user dari session login, bukan data user dari frontend/localStorage.
- Response 401 memakai redirect `/login`, tidak lagi `route('login')`, agar tidak muncul error `Route [login] not defined`.
- script.js tidak lagi mengirim data user manual saat confirm booking.

## Setelah copy patch
Jalankan:

```bat
composer dump-autoload
php artisan optimize:clear
php artisan route:clear
php artisan serve
```

## Test
1. Logout.
2. Buka `/booking`, harus diarahkan ke `/login`.
3. Login sebagai customer, harus bisa lanjut ke booking tanpa login ulang.
4. Pilih jadwal dan konfirmasi booking, harus masuk ke halaman pembayaran.
