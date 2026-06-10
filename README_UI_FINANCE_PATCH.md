# Patch UI Admin Panel + Laporan Keuangan GOR GAZA

## Isi patch
- UI admin layout baru: sidebar modern, topbar, card statistik, badge status, table lebih rapi.
- Dashboard admin diperbarui: revenue total, revenue bulan ini, booking hari ini, tagihan pending, ringkasan status booking/pembayaran.
- Halaman Laporan Keuangan baru: `/admin/reports/finance`.
- Filter laporan berdasarkan tanggal awal, tanggal akhir, dan status pembayaran.
- Rekap pendapatan paid, pending, cancelled, total transaksi.
- Rekap pendapatan per fasilitas.
- Rekap pendapatan harian.
- Detail transaksi.
- Export CSV laporan keuangan.

## Cara pasang
Copy semua isi patch ini ke root project Laravel `C:\src\gorgaza`, lalu replace file yang bentrok.

Setelah copy:

```bash
cd /d C:\src\gorgaza
composer dump-autoload
php artisan optimize:clear
php artisan serve
```

## URL baru
- Dashboard: `/admin/dashboard`
- Booking: `/admin/reservations`
- Fasilitas: `/admin/facilities`
- Laporan Keuangan: `/admin/reports/finance`

## Catatan
Patch ini tidak menambah migration baru, karena laporan keuangan mengambil data dari tabel `transactions`, `reservations`, `facilities`, dan `users` yang sudah ada.
