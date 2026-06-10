# GOR GAZA Schedule Fix Patch

Patch ini memperbaiki endpoint `/api/schedules` agar:
- Route `BookingController@getSchedules` tidak error lagi.
- Jadwal booking yang sudah ada di tabel `reservations` terbaca.
- Slot yang terisi dikirim dalam format frontend: `08:00 - 09:00`.
- Status `Booking`, `Confirmed`, dan `Completed` dianggap sudah terbooking.
- Status `Cancelled` tidak dihitung, sehingga slot bisa dipakai lagi.
- Frontend tetap aman jika response `booked_times` berupa string atau object.

Setelah copy patch:
```bat
composer dump-autoload
php artisan optimize:clear
php artisan route:clear
php artisan serve
```

Test endpoint:
```text
http://127.0.0.1:8000/api/schedules?tanggal=2026-06-11&facility_id=1
```
