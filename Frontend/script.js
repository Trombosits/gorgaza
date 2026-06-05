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

function renderSchedule(date) {
  if (!selectedDateLabel || !scheduleBody) return;

  const isLandingPage = !IS_BOOKING_PAGE;

  selectedDateLabel.textContent = `${selectedFacility} | ${formatDate(date)}`;

  scheduleBody.innerHTML = "";

  const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");

  const selectedTimes = draft.times || [];

  times.forEach((time, index) => {
    let isBooked;

    if (selectedFacility === "Badminton") {
      isBooked = (date.getDate() + index) % 3 === 0;
    } else {
      isBooked = (date.getDate() + index) % 4 === 0;
    }
    const statusText = isBooked ? "Sudah dibooking" : "Kosong";
    const statusClass = isBooked ? "text-danger" : "text-success";

    const row = document.createElement("tr");
    row.dataset.time = time;
    row.dataset.booked = isBooked ? "1" : "0";

    // On landing page, only show status without button
    if (isLandingPage) {
      row.innerHTML = `
        <td>${time}</td>
        <td class="${statusClass}">${statusText}</td>
      `;
    } else {
      // On booking page, show button
      const buttonHtml = isBooked
        ? "-"
        : `<button class="btn btn-sm btn-warning selectTimeBtn" data-time="${time}">Pilih</button>`;

      row.innerHTML = `
        <td>${time}</td>
        <td class="${statusClass}">${statusText}</td>
        <td>${buttonHtml}</td>
      `;

      // Highlight if already selected (only on booking page)
      if (!isBooked && selectedTimes.includes(time)) {
        row.classList.add("selected");
        const selectBtn = row.querySelector(".selectTimeBtn");
        if (selectBtn) {
          selectBtn.classList.add("selected");
          selectBtn.textContent = "Dibatalkan";
        }
      }

      // Add click handler only for non-booked items on booking page
      if (!isBooked) {
        const selectBtn = row.querySelector(".selectTimeBtn");
        selectBtn.addEventListener("click", (e) => {
          e.stopPropagation();

          // Toggle time in array
          const currentTimes = selectedTimes.includes(time)
            ? selectedTimes.filter((t) => t !== time)
            : [...selectedTimes, time];

          // Update draft booking
          const draftUpdate = JSON.parse(
            sessionStorage.getItem("bookingDraft") || "{}",
          );
          draftUpdate.date = date.toISOString();
          draftUpdate.times = currentTimes;
          sessionStorage.setItem("bookingDraft", JSON.stringify(draftUpdate));

          // Refresh schedule display
          renderSchedule(date);
        });
      }
    }

    scheduleBody.appendChild(row);
  });
}

function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();

  // Check if we're on the landing page (no bookingDraft in sessionStorage means landing page)
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

    // On landing page and booking page, enable date selection
    // On landing page: only to view schedule, no buttons for booking
    // On booking page: to select and book
    dayCell.addEventListener("click", () => {
      selectedDate = new Date(year, month, day);
      renderCalendar(currentDate);
      renderSchedule(selectedDate);
    });

    // On landing page, apply different styling
    if (isLandingPage) {
      dayCell.classList.add("landing-page-date");
    }

    calendarDays.appendChild(dayCell);
  }
}

if (prevMonth && nextMonth) {
  // Add event listeners for both landing page and booking page
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

// Login handler (register/login forms)
document.addEventListener("DOMContentLoaded", () => {
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
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const email = document.getElementById("loginEmail").value;
      const password = document.getElementById("loginPassword").value;
      // For demo: accept any credentials and mark user as logged
      const stored = JSON.parse(
        localStorage.getItem("registeredUser") || "null",
      );
      const name =
        stored && stored.email === email ? stored.name : email.split("@")[0];
      const phone = stored && stored.email === email ? stored.phone : "";
      const user = { name, email, phone };
      setLoggedUser(user);
      // redirect to booking if present
      window.location.href = "booking.html";
    });
  }

  const registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const name = document.getElementById("regName").value;
      const email = document.getElementById("regEmail").value;
      const phone = document.getElementById("regPhone").value;
      const password = document.getElementById("regPassword").value;
      const passwordConfirm =
        document.getElementById("regPasswordConfirm").value;
      if (password !== passwordConfirm) {
        alert("Password dan konfirmasi tidak sama");
        return;
      }
      // save registered user (demo only)
      localStorage.setItem(
        "registeredUser",
        JSON.stringify({ name, email, phone, password }),
      );
      setLoggedUser({ name, email, phone });
      window.location.href = "booking.html";
    });
  }

  // Booking page: choose type
  const chooseBadminton = document.getElementById("chooseBadminton");
  const chooseBilliard = document.getElementById("chooseBilliard");
  if (chooseBadminton || chooseBilliard) {
    if (chooseBadminton) {
      chooseBadminton.addEventListener("click", () => {
        sessionStorage.setItem(
          "bookingDraft",
          JSON.stringify({ type: "Badminton" }),
        );
        window.location.href = "booking_schedule.html";
      });
    }
    if (chooseBilliard) {
      chooseBilliard.addEventListener("click", () => {
        sessionStorage.setItem(
          "bookingDraft",
          JSON.stringify({ type: "Billiard" }),
        );
        window.location.href = "booking_schedule.html";
      });
    }
  }

  // On schedule page: load draft and populate calendar
  if (document.body.contains(document.getElementById("monthYear"))) {
    const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
    // show chosen type in header
    const typeHeader = document.querySelector(".section-title p");
    if (typeHeader && draft.type)
      typeHeader.textContent = `Tipe booking: ${draft.type}`;

    // enable continue button
    const continueBtn = document.getElementById("continueToConfirm");
    if (continueBtn) {
      continueBtn.addEventListener("click", () => {
        const draft2 = JSON.parse(
          sessionStorage.getItem("bookingDraft") || "{}",
        );
        // Support both old "time" and new "times" format
        const hasTime =
          (draft2.times && draft2.times.length > 0) || draft2.time;
        if (!draft2.date || !hasTime) {
          alert("Pilih tanggal dan jam terlebih dahulu.");
          return;
        }
        // Migrate old format to new format
        if (draft2.time && !draft2.times) {
          draft2.times = [draft2.time];
          delete draft2.time;
          sessionStorage.setItem("bookingDraft", JSON.stringify(draft2));
        }
        window.location.href = "booking_confirm.html";
      });
    }
  }

  // Confirmation page: render summary
  if (document.getElementById("bookingSummary")) {
    const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
    // Migrate old format to new format
    if (draft.time && !draft.times) {
      draft.times = [draft.time];
      delete draft.time;
    }

    const bookingSummary = document.getElementById("bookingSummary");
    bookingSummary.innerHTML = "";
    const liType = document.createElement("li");
    liType.className = "list-group-item";
    liType.textContent = `Tipe: ${draft.type || "-"}`;
    bookingSummary.appendChild(liType);

    const liDate = document.createElement("li");
    liDate.className = "list-group-item";
    liDate.textContent = `Tanggal: ${draft.date ? new Date(draft.date).toLocaleDateString("id-ID") : "-"}`;
    bookingSummary.appendChild(liDate);

    // Display multiple times
    const times = draft.times || [];
    const liTime = document.createElement("li");
    liTime.className = "list-group-item";
    if (times.length === 0) {
      liTime.textContent = `Jam: -`;
    } else if (times.length === 1) {
      liTime.textContent = `Jam: ${times[0]}`;
    } else {
      // Multiple times - show as badges
      const timesHtml = times
        .map((t, idx) => `<span class="badge bg-warning me-2 mb-2">${t}</span>`)
        .join("");
      liTime.innerHTML = `<strong>Jam (${times.length} sesi):</strong><br/><div class="mt-2">${timesHtml}</div>`;
    }
    bookingSummary.appendChild(liTime);

    const user = getLoggedUser();
    const userSummary = document.getElementById("userSummary");
    userSummary.innerHTML = "";
    if (user) {
      const u1 = document.createElement("li");
      u1.className = "list-group-item";
      u1.textContent = `Nama: ${user.name}`;
      userSummary.appendChild(u1);

      const u2 = document.createElement("li");
      u2.className = "list-group-item";
      u2.textContent = `Email: ${user.email}`;
      userSummary.appendChild(u2);

      const u3 = document.createElement("li");
      u3.className = "list-group-item";
      u3.textContent = `Nomor Telepon: ${user.phone || "-"}`;
      userSummary.appendChild(u3);
    } else {
      const u1 = document.createElement("li");
      u1.className = "list-group-item";
      u1.textContent = "Pengguna belum login";
      userSummary.appendChild(u1);
    }

    const confirmBtn = document.getElementById("confirmBooking");
    if (confirmBtn) {
      confirmBtn.addEventListener("click", () => {
        // save booking to localStorage (demo)
        const bookings = JSON.parse(localStorage.getItem("bookings") || "[]");
        bookings.push({ ...draft, user });
        localStorage.setItem("bookings", JSON.stringify(bookings));
        document.getElementById("confirmMessage").innerHTML =
          '<div class="alert alert-success">Booking berhasil! Cek WhatsApp untuk konfirmasi lebih lanjut.</div>';
        // clear draft
        sessionStorage.removeItem("bookingDraft");
      });
    }
  }
});
