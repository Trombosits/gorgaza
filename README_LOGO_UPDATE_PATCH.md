# GOR GAZA Logo Update Patch

Patch ini mengganti logo navbar/admin dari teks/inisial lama menjadi gambar `public/images/logo-gorgaza.png`.

File yang diubah:
- resources/views/Frontend/landing_page.blade.php
- resources/views/Frontend/login.blade.php
- resources/views/Frontend/register.blade.php
- resources/views/Frontend/booking.blade.php
- resources/views/Frontend/booking_schedule.blade.php
- resources/views/Frontend/booking_confirm.blade.php
- resources/views/Frontend/pembayaran.blade.php
- resources/views/Admin/layout.blade.php
- public/css/style.css
- public/js/script.js
- public/images/logo-gorgaza.png

Setelah copy patch:
php artisan view:clear
php artisan optimize:clear

Lalu refresh browser dengan Ctrl + F5.
