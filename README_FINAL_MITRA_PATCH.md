# Final Mitra Patch - GOR GAZA

Patch ini menambahkan polishing final untuk website GOR GAZA:

- Status booking otomatis menjadi `Out of Time` jika jam mulai sudah lewat lebih dari 1 menit.
- Landing page dipoles dengan font yang lebih elegan, gradasi card konsisten, animasi ringan, dan responsive improvement.
- Menu kafe dibuat sebagai katalog informasi dengan tombol `Segera Hadir` untuk pemesanan online.
- Admin booking mendukung status `Out of Time`.
- QRIS resmi tetap menggunakan file `public/images/payment/qris-gorgaza.jpeg` yang sudah ada.

## Cara menjalankan setelah copy patch

```bat
composer dump-autoload
php artisan migrate
php artisan optimize:clear
php artisan route:clear
php artisan serve
```

Jangan pakai `migrate:fresh` kalau data booking/fasilitas yang sudah ada masih mau dipertahankan.
