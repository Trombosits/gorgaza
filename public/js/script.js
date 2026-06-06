const monthYear = document.getElementById("monthYear");
const calendarDays = document.getElementById("calendarDays");
const selectedDateLabel = document.getElementById("selectedDateLabel");
const scheduleBody = document.getElementById("scheduleBody");
const prevMonth = document.getElementById("prevMonth");
const nextMonth = document.getElementById("nextMonth");
const IS_BOOKING_PAGE = !!document.getElementById("continueToConfirm");

let selectedFacility = "Badminton";
let currentDate = new Date();
let selectedDate = new Date();

// Utility: save and load logged user
function setLoggedUser(user) {
  localStorage.setItem("loggedUser", JSON.stringify(user));
}

function getLoggedUser() {
  try {
    return JSON.parse(localStorage.getItem("loggedUser"));
  } catch (e) {
    return null;
  }
}

const times = [
  "08:00 - 09:00",
  "09:00 - 10:00",
  "10:00 - 11:00",
  "11:00 - 12:00",
  "13:00 - 14:00",
  "14:00 - 15:00",
  "15:00 - 16:00",
  "16:00 - 17:00",
  "17:00 - 18:00",
  "18:00 - 19:00",
  "19:00 - 20:00",
  "20:00 - 21:00",
  "21:00 - 22:00",
];

function formatDate(date) {
  return date.toLocaleDateString("id-ID", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  });
}

// ==========================================
// 1. ASYNC FUNCTION RENDER SCHEDULE
// ==========================================
async function renderSchedule(date) {
  if (!selectedDateLabel || !scheduleBody) return;

  const isLandingPage = !IS_BOOKING_PAGE;
  selectedDateLabel.textContent = `${selectedFacility} | ${formatDate(date)}`;

  // Tampilkan loading state
  scheduleBody.innerHTML = '<tr><td colspan="3" class="text-center">Memuat jadwal dari database...</td></tr>';

  try {
    // Format tanggal ke YYYY-MM-DD untuk parameter API
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const formattedDateStr = `${year}-${month}-${day}`;

    // Tentukan ID Fasilitas (1 untuk Badminton, 2 untuk Billiard - sesuai gor_gaza.sql)
    const facilityId = selectedFacility === "Badminton" ? 1 : 2;

    // Panggil API Laravel
    const response = await fetch(`/api/schedules?tanggal=${formattedDateStr}&facility_id=${facilityId}`);
    const data = await response.json();
    const bookedTimes = data.booked_times || []; 

    // Render ulang tabel
    scheduleBody.innerHTML = "";

    // Ambil draft dari sessionStorage untuk melihat jam apa saja yang sedang dipilih user (Multi-select)
    const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
    const selectedTimes = draft.times || [];

    times.forEach((time) => {
      const isBooked = bookedTimes.includes(time);
      const statusText = isBooked ? "Sudah dibooking" : "Kosong";
      const statusClass = isBooked ? "text-danger" : "text-success";

      const row = document.createElement("tr");
      row.dataset.time = time;
      row.dataset.booked = isBooked ? "1" : "0";

      if (isLandingPage) {
        // Tampilan Landing Page (Hanya status)
        row.innerHTML = `
          <td>${time}</td>
          <td class="${statusClass}">${statusText}</td>
        `;
      } else {
        // Tampilan Halaman Booking (Dengan Tombol)
        const buttonHtml = isBooked
          ? '<span class="badge bg-secondary">Penuh</span>'
          : `<button class="btn btn-sm btn-warning selectTimeBtn" data-time="${time}">Pilih</button>`;

        row.innerHTML = `
          <td>${time}</td>
          <td class="${statusClass}">${statusText}</td>
          <td>${buttonHtml}</td>
        `;

        // Highlight jika sedang dipilih user di draft
        if (!isBooked && selectedTimes.includes(time)) {
          row.classList.add("selected");
          const selectBtn = row.querySelector(".selectTimeBtn");
          if (selectBtn) {
            selectBtn.classList.add("selected", "btn-success", "text-white");
            selectBtn.classList.remove("btn-warning");
            selectBtn.textContent = "Terpilih";
          }
        }

        // Event klik untuk memilih jam (Multi-select support)
        if (!isBooked) {
          const selectBtn = row.querySelector(".selectTimeBtn");
          selectBtn.addEventListener("click", (e) => {
            e.stopPropagation();

            const currentTimes = selectedTimes.includes(time)
              ? selectedTimes.filter((t) => t !== time) // Hapus jika sudah ada
              : [...selectedTimes, time]; // Tambah jika belum ada

            // Update sessionStorage draft
            const draftUpdate = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
            draftUpdate.type = selectedFacility;
            draftUpdate.facility_id = facilityId; 
            draftUpdate.date = formattedDateStr; 
            draftUpdate.times = currentTimes;
            sessionStorage.setItem("bookingDraft", JSON.stringify(draftUpdate));

            renderSchedule(date); // Refresh tampilan baris
          });
        }
      }

      scheduleBody.appendChild(row);
    });

  } catch (error) {
    console.error("Gagal mengambil jadwal:", error);
    scheduleBody.innerHTML = '<tr><td colspan="3" class="text-center text-danger">Gagal memuat jadwal dari server. Pastikan server berjalan.</td></tr>';
  }
}

// ==========================================
// 2. RENDER CALENDAR
// ==========================================
function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();
  const isLandingPage = !IS_BOOKING_PAGE;

  monthYear.textContent = date.toLocaleDateString("id-ID", {
    month: "long",
    year: "numeric",
  });

  calendarDays.innerHTML = "";

  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  for (let i = 0; i < firstDay; i++) {
    const emptyCell = document.createElement("div");
    emptyCell.className = "calendar-day empty";
    calendarDays.appendChild(emptyCell);
  }

  for (let day = 1; day <= daysInMonth; day++) {
    const dayCell = document.createElement("button");
    dayCell.type = "button";
    dayCell.className = "calendar-day";
    dayCell.textContent = day;

    if (
      day === selectedDate.getDate() &&
      month === selectedDate.getMonth() &&
      year === selectedDate.getFullYear()
    ) {
      dayCell.classList.add("active");
    }

    dayCell.addEventListener("click", () => {
      selectedDate = new Date(year, month, day);
      renderCalendar(currentDate);
      renderSchedule(selectedDate);
    });

    if (isLandingPage) {
      dayCell.classList.add("landing-page-date");
    }

    calendarDays.appendChild(dayCell);
  }
}

if (prevMonth && nextMonth) {
  prevMonth.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
  });

  nextMonth.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
  });

  renderCalendar(currentDate);
  renderSchedule(selectedDate);
}

// ==========================================
// 3. EVENT LISTENERS UTAMA & KONFIRMASI
// ==========================================
document.addEventListener("DOMContentLoaded", () => {
  // Pilihan Fasilitas Badminton / Billiard
  const showBadminton = document.getElementById("showBadminton");
  const showBilliard = document.getElementById("showBilliard");

  if (showBadminton && showBilliard) {
    showBadminton.addEventListener("click", () => {
      selectedFacility = "Badminton";
      showBadminton.classList.add("btn-warning", "active-facility");
      showBadminton.classList.remove("btn-outline-warning");
      showBilliard.classList.remove("btn-warning", "active-facility");
      showBilliard.classList.add("btn-outline-warning");
      renderSchedule(selectedDate);
    });

    showBilliard.addEventListener("click", () => {
      selectedFacility = "Billiard";
      showBilliard.classList.add("btn-warning", "active-facility");
      showBilliard.classList.remove("btn-outline-warning");
      showBadminton.classList.remove("btn-warning", "active-facility");
      showBadminton.classList.add("btn-outline-warning");
      renderSchedule(selectedDate);
    });
  }

  // Booking page: choose type di awal
  const chooseBadminton = document.getElementById("chooseBadminton");
  const chooseBilliard = document.getElementById("chooseBilliard");
  if (chooseBadminton) {
    chooseBadminton.addEventListener("click", () => {
      sessionStorage.setItem("bookingDraft", JSON.stringify({ type: "Badminton", facility_id: 1 }));
      window.location.href = "/booking-schedule";
    });
  }
  if (chooseBilliard) {
    chooseBilliard.addEventListener("click", () => {
      sessionStorage.setItem("bookingDraft", JSON.stringify({ type: "Billiard", facility_id: 2 }));
      window.location.href = "/booking-schedule";
    });
  }

  // Lanjut dari jadwal ke halaman konfirmasi
  const continueBtn = document.getElementById("continueToConfirm");
  if (continueBtn) {
    continueBtn.addEventListener("click", () => {
      const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
      if (!draft.date || !draft.times || draft.times.length === 0) {
        alert("Pilih tanggal dan jam terlebih dahulu.");
        return;
      }
      window.location.href = "/booking-confirm";
    });
  }

  // Konfirmasi Booking Page Render Summary
  const bookingSummary = document.getElementById("bookingSummary");
  if (bookingSummary) {
    const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
    const times = draft.times || [];

    bookingSummary.innerHTML = "";
    bookingSummary.innerHTML += `<li class="list-group-item">Tipe: ${draft.type || "-"}</li>`;
    bookingSummary.innerHTML += `<li class="list-group-item">Tanggal: ${draft.date ? new Date(draft.date).toLocaleDateString("id-ID") : "-"}</li>`;
    
    if (times.length > 0) {
      const timesHtml = times.map(t => `<span class="badge bg-warning text-dark me-2 mb-2">${t}</span>`).join("");
      bookingSummary.innerHTML += `<li class="list-group-item"><strong>Jam (${times.length} sesi):</strong><br/><div class="mt-2">${timesHtml}</div></li>`;
    } else {
      bookingSummary.innerHTML += `<li class="list-group-item">Jam: -</li>`;
    }

    const user = getLoggedUser();
    const userSummary = document.getElementById("userSummary");
    userSummary.innerHTML = "";
    if (user) {
      userSummary.innerHTML += `<li class="list-group-item">Nama: ${user.name}</li>`;
      userSummary.innerHTML += `<li class="list-group-item">Email: ${user.email}</li>`;
      userSummary.innerHTML += `<li class="list-group-item">Nomor Telepon: ${user.phone || "-"}</li>`;
    } else {
      userSummary.innerHTML += `<li class="list-group-item text-danger">Pengguna belum login! Silakan login terlebih dahulu.</li>`;
    }
  }

  // Tombol Submit Konfirmasi Akhir
  const confirmBtn = document.getElementById("confirmBooking");
  if (confirmBtn) {
    confirmBtn.addEventListener("click", () => {
      const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
      const user = getLoggedUser();

      if (!user) {
          alert("Anda harus login untuk melakukan booking!");
          return window.location.href = "/login";
      }

      // Ubah format Array ["08:00 - 09:00", "09:00 - 10:00"] menjadi waktu_mulai dan waktu_selesai untuk Laravel
      draft.times.sort(); 
      const jamMulai = draft.times[0].split(" - ")[0]; // Ambil "08:00"
      const jamSelesai = draft.times[draft.times.length - 1].split(" - ")[1]; // Ambil "10:00"

      const payloadDraft = {
          facility_id: draft.facility_id,
          waktu_mulai: `${draft.date} ${jamMulai}:00`,
          waktu_selesai: `${draft.date} ${jamSelesai}:00`
      };

      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

      fetch('/api/bookings', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json'
          },
          body: JSON.stringify({ draft: payloadDraft, user: user })
      })
      .then(response => response.json())
      .then(data => {
          if(data.success) {
            document.getElementById("confirmMessage").innerHTML =
            '<div class="alert alert-success">Booking berhasil disimpan ke database! Cek WhatsApp untuk konfirmasi.</div>';
            sessionStorage.removeItem("bookingDraft");
          } else {
            alert("Gagal menyimpan: " + data.message);
          }
      })
      .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menyimpan booking.');
      });
    });
  }
});

// ==========================================
// 4. FETCH API LOGIN & REGISTER (LARAVEL)
// ==========================================
const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

// Handle Register
const registerForm = document.querySelector("form"); 
if (registerForm && window.location.pathname.includes("register")) {
  registerForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const name = document.getElementById("regName").value;
    const phone = document.getElementById("regPhone").value;
    const email = document.getElementById("regEmail").value;
    const password = document.getElementById("regPassword").value;
    const passwordConfirm = document.getElementById("regPasswordConfirm").value;

    if (password !== passwordConfirm) {
      alert("Konfirmasi password tidak cocok!");
      return;
    }

    fetch('/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ nama: name, no_hp: phone, email: email, password: password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = "/login"; 
        } else {
            alert(data.message || "Registrasi Gagal");
        }
    })
    .catch(err => console.error("Error:", err));
  });
}

// Handle Login
if (registerForm && window.location.pathname.includes("login")) {
  registerForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ email: email, password: password })
    })
    .then(res => {
        if (!res.ok) throw res;
        return res.json();
    })
    .then(data => {
        if (data.success) {
            setLoggedUser(data.user); 
            alert("Selamat datang kembali, " + data.user.name);
            window.location.href = "/"; 
        }
    })
    .catch(async (err) => {
        const errorData = await err.json();
        alert(errorData.message || "Email atau password salah.");
    });
  });
}