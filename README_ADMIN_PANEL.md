# Admin Panel GOR GAZA - Patch untuk source terbaru

Patch ini dibuat mengikuti source terbaru `gorgaza-main (1).zip`.

## Fitur

- Login/register customer tetap memakai frontend lama.
- Login admin memakai halaman login yang sama.
- Admin dashboard: total customer, fasilitas, booking, revenue paid.
- CRUD fasilitas.
- Kelola booking/reservasi.
- Update status booking dan pembayaran.
- Cek jadwal bentrok saat customer booking.

## Cara pasang

1. Extract zip patch ini.
2. Copy semua folder/file ke root project Laravel kamu.
3. Kalau muncul pilihan replace, pilih replace untuk file berikut:
   - `routes/web.php`
   - `bootstrap/app.php`
   - `app/Http/Controllers/AuthController.php`
   - `app/Http/Controllers/BookingController.php`
   - `app/Models/User.php`
   - `app/Models/Facility.php`
   - `app/Models/Reservation.php`
   - `app/Models/Transaction.php`
   - `database/seeders/DatabaseSeeder.php`
   - `public/js/script.js`

## Jalankan

```bash
composer dump-autoload
php artisan migrate --seed
php artisan serve
```

Kalau database kamu masih kosong dan ingin reset total:

```bash
php artisan migrate:fresh --seed
```

## Akun admin default

Email: `admin@gorgaza.test`
Password: `password`

## URL penting

- Website: `/`
- Register: `/register`
- Login: `/login`
- Booking: `/booking`
- Admin dashboard: `/admin/dashboard`
- Admin fasilitas: `/admin/facilities`
- Admin booking: `/admin/reservations`
