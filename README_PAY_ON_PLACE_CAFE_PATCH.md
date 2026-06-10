# Patch Pay On Place + Cafe Draft

Patch ini menambahkan:
- Kolom `metode_pembayaran` pada tabel `transactions`.
- Booking customer otomatis memakai metode `Pay On Place`.
- Status pembayaran tetap `Pending` sampai admin mengubah menjadi `Paid`.
- Admin dapat melihat metode pembayaran di daftar/detail booking.
- Laporan keuangan dan export CSV menampilkan metode pembayaran.
- Dropdown jenis fasilitas admin ditambah opsi `Cafe`.
- Cafe hanya bisa dikelola di admin panel; belum ditampilkan di landing page dan belum muncul di pilihan booking customer.

## Cara pasang

Copy semua isi patch ke root project Laravel:

```bat
cd /d C:\src\gorgaza
composer dump-autoload
php artisan migrate
php artisan optimize:clear
php artisan serve
```

Jangan gunakan `migrate:fresh` kalau data booking/fasilitas tidak ingin hilang.
