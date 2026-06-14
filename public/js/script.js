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

const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "";

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

function showAuthMessage(message, type = "info") {
  const alertBox = document.getElementById("authAlert");
  if (!alertBox) {
    alert(message);
    return;
  }

  alertBox.className = `auth-alert ${type}`;
  alertBox.textContent = message;
  alertBox.classList.remove("d-none");
}

function setButtonLoading(button, isLoading) {
  if (!button) return;

  const text = button.querySelector(".btn-text");
  const loading = button.querySelector(".btn-loading");

  button.disabled = isLoading;
  if (text) text.classList.toggle("d-none", isLoading);
  if (loading) loading.classList.toggle("d-none", !isLoading);
}

function normalizePaymentMethod(value) {
  const method = (value || "QRIS").trim();
  const lowerMethod = method.toLowerCase();

  if (lowerMethod.includes("qris") || lowerMethod.includes("gopay") || lowerMethod.includes("go pay")) {
    return "QRIS";
  }

  if (lowerMethod.includes("cash") || lowerMethod.includes("tunai") || lowerMethod.includes("bayar") || lowerMethod.includes("pay on place")) {
    return "Cash / Bayar di Tempat";
  }

  return method || "QRIS";
}

function getPaymentMethodLabel(value) {
  const method = normalizePaymentMethod(value);
  return method === "Cash / Bayar di Tempat" ? "Tunai / Bayar di Tempat" : "QRIS";
}

function getSelectedPaymentMethod() {
  return normalizePaymentMethod(document.querySelector("input[name='metode_pembayaran']:checked")?.value || "QRIS");
}

function initPaymentMethodChoice() {
  const options = document.querySelectorAll(".payment-method-option");
  if (!options.length) return;

  const syncActiveChoice = () => {
    document.querySelectorAll(".payment-choice").forEach((label) => label.classList.remove("active"));
    const checked = document.querySelector("input[name='metode_pembayaran']:checked");
    checked?.closest(".payment-choice")?.classList.add("active");

    const methodText = document.getElementById("bookingPaymentMethodText");
    if (methodText) {
      methodText.textContent = getPaymentMethodLabel(checked?.value || "QRIS");
    }
  };

  options.forEach((option) => {
    option.addEventListener("change", () => {
      const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
      draft.metode_pembayaran = getSelectedPaymentMethod();
      sessionStorage.setItem("bookingDraft", JSON.stringify(draft));
      syncActiveChoice();
    });
  });

  const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
  const savedMethod = normalizePaymentMethod(draft.metode_pembayaran || getSelectedPaymentMethod());
  const savedOption = [...options].find((option) => normalizePaymentMethod(option.value) === savedMethod);
  if (savedOption) savedOption.checked = true;

  draft.metode_pembayaran = savedMethod;
  sessionStorage.setItem("bookingDraft", JSON.stringify(draft));
  syncActiveChoice();
}

async function parseJsonResponse(response) {
  let data = {};

  try {
    data = await response.json();
  } catch (error) {
    data = {};
  }

  if (!response.ok) {
    const message = data.message || data.errors?.email?.[0] || data.errors?.password?.[0] || "Terjadi kesalahan pada server.";
    throw new Error(message);
  }

  return data;
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

function formatDateForApi(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  return `${year}-${month}-${day}`;
}

async function renderSchedule(date) {
  if (!selectedDateLabel || !scheduleBody) return;

  const isLandingPage = !IS_BOOKING_PAGE;
  const columnCount = isLandingPage ? 2 : 3;
  selectedDateLabel.textContent = `${selectedFacility} | ${formatDate(date)}`;
  scheduleBody.innerHTML = `<tr><td colspan="${columnCount}" class="text-center py-4">Memuat jadwal dari database...</td></tr>`;

  try {
    const formattedDateStr = formatDateForApi(date);
    const facilityId = selectedFacility === "Badminton" ? 1 : 2;
    const response = await fetch(`/api/schedules?tanggal=${formattedDateStr}&facility_id=${facilityId}`, {
      headers: { Accept: "application/json" },
    });
    const data = await parseJsonResponse(response);
    const bookedTimes = data.booked_times || [];

    scheduleBody.innerHTML = "";

    const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
    const selectedTimes = draft.times || [];

    const isTimeBooked = (time) => {
      return bookedTimes.some((booked) => {
        if (typeof booked === "string") {
          return booked === time;
        }

        if (booked && booked.start && booked.end) {
          return `${booked.start} - ${booked.end}` === time;
        }

        return false;
      });
    };

    times.forEach((time) => {
      const isBooked = isTimeBooked(time);

      const [startTime] = time.split(" - ");
      const slotStart = new Date(`${formattedDateStr}T${startTime}:00`);
      const outOfTimeLimit = new Date(slotStart.getTime() + 60 * 1000);
      const isOutOfTime = new Date() > outOfTimeLimit;

      let statusText = "Kosong";
      let statusClass = "text-success fw-bold";

      if (isBooked) {
        statusText = "Sudah dibooking";
        statusClass = "text-danger fw-bold";
      } else if (isOutOfTime) {
        statusText = "Out of Time";
        statusClass = "text-warning fw-bold";
      }

      const row = document.createElement("tr");
      row.dataset.time = time;
      row.dataset.booked = isBooked ? "1" : "0";
      row.dataset.outOfTime = isOutOfTime ? "1" : "0";

      if (isLandingPage) {
        row.innerHTML = `
          <td>${time}</td>
          <td class="${statusClass}">${statusText}</td>
        `;
      } else {
        const buttonHtml = isBooked
          ? '<span class="badge bg-secondary">Penuh</span>'
          : isOutOfTime
            ? '<span class="badge bg-warning text-dark">Out of Time</span>'
            : `<button class="btn btn-sm btn-warning selectTimeBtn" type="button" data-time="${time}">Pilih</button>`;

        row.innerHTML = `
          <td>${time}</td>
          <td class="${statusClass}">${statusText}</td>
          <td>${buttonHtml}</td>
        `;

        if (!isBooked && !isOutOfTime && selectedTimes.includes(time)) {
          row.classList.add("selected");
          const selectBtn = row.querySelector(".selectTimeBtn");
          if (selectBtn) {
            selectBtn.classList.add("selected", "btn-success", "text-white");
            selectBtn.classList.remove("btn-warning");
            selectBtn.textContent = "Terpilih";
          }
        }

        if (!isBooked && !isOutOfTime) {
          const selectBtn = row.querySelector(".selectTimeBtn");
          if (selectBtn) {
            selectBtn.addEventListener("click", (e) => {
              e.stopPropagation();

              const activeDraft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
              const activeTimes = activeDraft.times || [];
              const currentTimes = activeTimes.includes(time)
                ? activeTimes.filter((t) => t !== time)
                : [...activeTimes, time];

              activeDraft.type = selectedFacility;
              activeDraft.facility_id = facilityId;
              activeDraft.date = formattedDateStr;
              activeDraft.times = currentTimes;
              sessionStorage.setItem("bookingDraft", JSON.stringify(activeDraft));

              renderSchedule(date);
            });
          }
        }
      }

      scheduleBody.appendChild(row);
    });
  } catch (error) {
    console.error("Gagal mengambil jadwal:", error);
    scheduleBody.innerHTML = `<tr><td colspan="${columnCount}" class="text-center text-danger py-4">Gagal memuat jadwal. Pastikan server Laravel dan database sudah berjalan.</td></tr>`;
  }
}

function renderCalendar(date) {
  if (!monthYear || !calendarDays) return;

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

function initCalendar() {
  if (!prevMonth || !nextMonth || !monthYear || !calendarDays) return;

  // 🌟 PERBAIKAN DI SINI: Ambil draft dari sessionStorage jika ada
  const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
  if (draft.type) {
    selectedFacility = draft.type; // Set variabel global sesuai fasilitas terpilih (Badminton / Billiard)
    
    // Opsional: Sinkronkan status aktif tombol switcher (jika tombol switcher ada di halaman tersebut)
    const showBadminton = document.getElementById("showBadminton");
    const showBilliard = document.getElementById("showBilliard");
    if (showBadminton && showBilliard) {
      if (selectedFacility === "Billiard") {
        showBilliard.classList.add("btn-warning", "active-facility");
        showBilliard.classList.remove("btn-outline-warning");
        showBadminton.classList.remove("btn-warning", "active-facility");
        showBadminton.classList.add("btn-outline-warning");
      } else {
        showBadminton.classList.add("btn-warning", "active-facility");
        showBadminton.classList.remove("btn-outline-warning");
        showBilliard.classList.remove("btn-warning", "active-facility");
        showBilliard.classList.add("btn-outline-warning");
      }
    }
  }

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

function initFacilitySwitcher() {
  const showBadminton = document.getElementById("showBadminton");
  const showBilliard = document.getElementById("showBilliard");

  if (!showBadminton || !showBilliard) return;

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

function initBookingFlow() {
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
}

function initBookingSummary() {
  const bookingSummary = document.getElementById("bookingSummary");
  if (!bookingSummary) return;

  const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
  const selectedDraftTimes = draft.times || [];

  bookingSummary.innerHTML = "";
  bookingSummary.innerHTML += `<li class="list-group-item">Tipe: ${draft.type || "-"}</li>`;
  bookingSummary.innerHTML += `<li class="list-group-item">Tanggal: ${draft.date ? new Date(draft.date).toLocaleDateString("id-ID") : "-"}</li>`;

  if (selectedDraftTimes.length > 0) {
    const timesHtml = selectedDraftTimes.map((t) => `<span class="badge bg-warning text-dark me-2 mb-2">${t}</span>`).join("");
    bookingSummary.innerHTML += `<li class="list-group-item"><strong>Jam (${selectedDraftTimes.length} sesi):</strong><br/><div class="mt-2">${timesHtml}</div></li>`;
  } else {
    bookingSummary.innerHTML += `<li class="list-group-item">Jam: -</li>`;
  }

  const selectedPaymentMethod = normalizePaymentMethod(draft.metode_pembayaran || getSelectedPaymentMethod());
  bookingSummary.innerHTML += `<li class="list-group-item confirm-method-row"><span>Metode Pembayaran:</span> <strong id="bookingPaymentMethodText">${getPaymentMethodLabel(selectedPaymentMethod)}</strong></li>`;

  const user = getLoggedUser();
  const userSummary = document.getElementById("userSummary");
  if (!userSummary) return;

  userSummary.innerHTML = "";
  if (user) {
    userSummary.innerHTML += `<li class="list-group-item">Nama: ${user.name}</li>`;
    userSummary.innerHTML += `<li class="list-group-item">Email: ${user.email}</li>`;
    userSummary.innerHTML += `<li class="list-group-item">Nomor Telepon: ${user.phone || "-"}</li>`;
  } else {
    userSummary.innerHTML += `<li class="list-group-item text-danger">Pengguna belum login! Silakan login terlebih dahulu.</li>`;
  }
}

function initConfirmBooking() {
  const confirmBtn = document.getElementById("confirmBooking");
  if (!confirmBtn) return;

  confirmBtn.addEventListener("click", () => {
    const draft = JSON.parse(sessionStorage.getItem("bookingDraft") || "{}");
    const user = getLoggedUser();

    if (!user) {
      alert("Anda harus login untuk melakukan booking!");
      window.location.href = "/login";
      return;
    }

    if (!draft.date || !draft.times || draft.times.length === 0) {
      alert("Data booking belum lengkap. Silakan pilih tanggal dan jam terlebih dahulu.");
      window.location.href = "/booking-schedule";
      return;
    }

    draft.times.sort();
    const jamMulai = draft.times[0].split(" - ")[0];
    const jamSelesai = draft.times[draft.times.length - 1].split(" - ")[1];

    const payloadDraft = {
      facility_id: draft.facility_id,
      waktu_mulai: `${draft.date} ${jamMulai}:00`,
      waktu_selesai: `${draft.date} ${jamSelesai}:00`,
      metode_pembayaran: getSelectedPaymentMethod(),
    };

    setButtonLoading(confirmBtn, true);

    fetch("/api/bookings", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": getCsrfToken(),
        Accept: "application/json",
      },
      body: JSON.stringify({ draft: payloadDraft, user: user }),
    })
      .then(parseJsonResponse)
      .then((data) => {
        if (data.success) {
          const confirmMessage = document.getElementById("confirmMessage");
          if (confirmMessage) {
            confirmMessage.innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> Booking berhasil! Mengalihkan ke halaman pembayaran...</div>';
          }

          // 🌟 HAPUS DRAFT AGAR TIDAK DOUBLE BOOKING
          sessionStorage.removeItem("bookingDraft");

          // 🌟 ALUR BARU: Pindah ke halaman pembayaran dengan membawa ID Transaksi
          setTimeout(() => {
            window.location.href = `/pembayaran/${data.transaction_id}`;
          }, 1500); // Memberikan jeda 1.5 detik agar user sempat membaca pesan sukses
          
        } else {
          alert("Gagal menyimpan: " + (data.message || "Terjadi kesalahan."));
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert(error.message || "Terjadi kesalahan saat menyimpan booking.");
      })
      .finally(() => setButtonLoading(confirmBtn, false));
  });
}

function initPasswordToggle() {
  document.querySelectorAll(".password-toggle").forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.dataset.target;
      const target = document.getElementById(targetId);
      if (!target) return;

      const show = target.type === "password";
      target.type = show ? "text" : "password";
      button.innerHTML = show ? '<i class="fa-regular fa-eye-slash"></i>' : '<i class="fa-regular fa-eye"></i>';
    });
  });
}

function initRegisterForm() {
  const registerForm = document.getElementById("registerForm");
  if (!registerForm) return;

  registerForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const submitBtn = registerForm.querySelector("button[type='submit']");
    const name = document.getElementById("regName")?.value.trim();
    const phone = document.getElementById("regPhone")?.value.trim();
    const email = document.getElementById("regEmail")?.value.trim();
    const password = document.getElementById("regPassword")?.value;
    const passwordConfirm = document.getElementById("regPasswordConfirm")?.value;

    if (!name || !phone || !email || !password || !passwordConfirm) {
      showAuthMessage("Semua field wajib diisi.", "error");
      return;
    }

    if (password.length < 6) {
      showAuthMessage("Password minimal 6 karakter.", "error");
      return;
    }

    if (password !== passwordConfirm) {
      showAuthMessage("Konfirmasi password tidak cocok!", "error");
      return;
    }

    setButtonLoading(submitBtn, true);

    try {
      const response = await fetch("/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": getCsrfToken(),
          Accept: "application/json",
        },
        body: JSON.stringify({ nama: name, no_hp: phone, email: email, password: password }),
      });

      const data = await parseJsonResponse(response);
      showAuthMessage(data.message || "Registrasi berhasil! Silakan login.", "success");
      setTimeout(() => {
        window.location.href = "/login";
      }, 900);
    } catch (error) {
      console.error("Register error:", error);
      showAuthMessage(error.message || "Registrasi gagal.", "error");
    } finally {
      setButtonLoading(submitBtn, false);
    }
  });
}

function initLoginForm() {
  const loginForm = document.getElementById("loginForm");
  if (!loginForm) return;

  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const submitBtn = loginForm.querySelector("button[type='submit']");
    const email = document.getElementById("loginEmail")?.value.trim();
    const password = document.getElementById("loginPassword")?.value;

    if (!email || !password) {
      showAuthMessage("Email dan password wajib diisi.", "error");
      return;
    }

    setButtonLoading(submitBtn, true);

    try {
      const response = await fetch("/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": getCsrfToken(),
          Accept: "application/json",
        },
        body: JSON.stringify({ email: email, password: password }),
      });

      const data = await parseJsonResponse(response);
      if (data.success) {
        setLoggedUser(data.user);
        showAuthMessage(`Selamat datang kembali, ${data.user.name}. Mengalihkan halaman...`, "success");
        setTimeout(() => {
          window.location.href = data.redirect || "/";
        }, 650);
      }
    } catch (error) {
      console.error("Login error:", error);
      showAuthMessage(error.message || "Email atau password salah.", "error");
    } finally {
      setButtonLoading(submitBtn, false);
    }
  });
}

function initHeroImageSlider() {
  const hero = document.querySelector(".hero-slider");
  if (!hero) return;

  const slides = Array.from(hero.querySelectorAll(".hero-slide"));
  const indicators = Array.from(hero.querySelectorAll(".hero-indicator"));
  if (slides.length <= 1) return;

  let currentIndex = slides.findIndex((slide) => slide.classList.contains("is-active"));
  if (currentIndex < 0) currentIndex = 0;

  let timerId = null;
  const delay = 6500;

  const restartKenBurns = (slide) => {
    slide.style.animation = "none";
    // Force reflow so the zoom animation starts again every time the image becomes active.
    void slide.offsetWidth;
    slide.style.animation = "";
  };

  const setActiveSlide = (nextIndex) => {
    const normalizedIndex = (nextIndex + slides.length) % slides.length;
    if (normalizedIndex === currentIndex && slides[currentIndex].classList.contains("is-active")) {
      return;
    }

    currentIndex = normalizedIndex;

    slides.forEach((slide, index) => {
      const isActive = index === currentIndex;
      slide.classList.toggle("is-active", isActive);
      if (isActive) restartKenBurns(slide);
    });

    indicators.forEach((indicator, index) => {
      indicator.classList.toggle("is-active", index === currentIndex);
    });
  };

  const startSlider = () => {
    window.clearInterval(timerId);
    timerId = window.setInterval(() => {
      setActiveSlide(currentIndex + 1);
    }, delay);
  };

  indicators.forEach((indicator, index) => {
    indicator.addEventListener("click", () => {
      setActiveSlide(index);
      startSlider();
    });
  });

  slides.forEach((slide, index) => {
    slide.classList.toggle("is-active", index === currentIndex);
  });
  restartKenBurns(slides[currentIndex]);
  indicators.forEach((indicator, index) => {
    indicator.classList.toggle("is-active", index === currentIndex);
  });

  startSlider();
}

function initNavbarScrollState() {
  const navbar = document.querySelector(".app-navbar");
  if (!navbar) return;

  const syncNavbar = () => {
    navbar.classList.toggle("is-scrolled", window.scrollY > 20);
  };

  syncNavbar();
  window.addEventListener("scroll", syncNavbar, { passive: true });
}

function initGorgazaScrollPopAnimation() {
  const isLandingPage = document.body.classList.contains("frontend-page") || document.querySelector(".hero");
  if (!isLandingPage) return;

  const selectors = [
    ".section-title",
    ".section-kicker",
    ".facility-detail .col-lg-6",
    ".gallery-grid img",
    ".feature-box",
    ".stat-box",
    ".price-section .col-md-6",
    ".price-card",
    ".menu-card",
    ".cafe-coming-soon",
    ".schedule-section .col-lg-5",
    ".schedule-section .col-lg-7",
    ".schedule-card",
    ".map-iframe",
    "footer p"
  ];

  const items = [];
  selectors.forEach((selector) => {
    document.querySelectorAll(selector).forEach((element) => {
      if (
        !items.includes(element) &&
        !element.closest(".hero") &&
        !element.closest(".navbar") &&
        !element.closest(".modal")
      ) {
        items.push(element);
      }
    });
  });

  if (!items.length) return;

  items.forEach((element, index) => {
    element.classList.remove(
      "reveal-on-scroll",
      "is-visible",
      "smooth-reveal",
      "smooth-reveal-fast",
      "reveal-show",
      "scroll-pop",
      "pop-show"
    );

    element.classList.add("gg-scroll-pop");
    element.classList.remove("gg-pop-show");

    const parent = element.parentElement;
    const siblingItems = parent ? Array.from(parent.children).filter((child) => items.includes(child)) : [];
    const siblingIndex = siblingItems.length ? siblingItems.indexOf(element) : index;
    const delay = Math.min((siblingIndex % 4) * 120, 360);

    element.style.setProperty("--gg-pop-delay", `${delay}ms`);
  });

  const showElement = (element) => {
    element.classList.add("gg-pop-show");
  };

  const revealByPosition = () => {
    const trigger = window.innerHeight - 90;

    items.forEach((element) => {
      if (element.classList.contains("gg-pop-show")) return;

      const rect = element.getBoundingClientRect();
      if (rect.top < trigger) {
        showElement(element);
      }
    });
  };

  // Browser perlu 1 frame untuk menerapkan posisi awal sebelum animasi show.
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      revealByPosition();

      window.addEventListener("scroll", revealByPosition, { passive: true });
      window.addEventListener("resize", revealByPosition);
    });
  });
}
document.addEventListener("DOMContentLoaded", () => {
  initCalendar();
  initFacilitySwitcher();
  initBookingFlow();
  initBookingSummary();
  initPaymentMethodChoice();
  initConfirmBooking();
  initPasswordToggle();
  initRegisterForm();
  initLoginForm();
  initHeroImageSlider();
  initGorgazaScrollPopAnimation();
  initNavbarScrollState();
});
