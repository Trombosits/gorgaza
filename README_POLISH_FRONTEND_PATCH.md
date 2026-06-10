# Patch Polish Frontend GOR GAZA

Patch ini memperbarui tampilan halaman utama, login, dan register tanpa mengubah alur fungsi utama.

File yang diganti:
- resources/views/Frontend/landing_page.blade.php
- resources/views/Frontend/login.blade.php
- resources/views/Frontend/register.blade.php
- public/css/style.css
- public/js/script.js

Perbaikan utama:
- UI landing page lebih modern dan responsive.
- ID section fasilitas diperbaiki agar navbar `/#fasilitas` tidak salah arah.
- Tampilan login dan register dibuat lebih rapi.
- Pesan error login/register tidak lagi hanya alert kasar, tetapi tampil di card.
- Submit button login/register punya loading state.
- Toggle show/hide password.
- Script dibuat lebih aman agar tidak error ketika elemen tertentu tidak ada di halaman.
- Fungsi booking, jadwal, login, register tetap memakai endpoint lama.
