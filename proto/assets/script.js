/* ============================================================
   KB 'Aisyiyah 2 Dau — script.js
   Perilaku antarmuka bersama untuk seluruh halaman situs.
   Catatan: halaman login & dashboard admin di sini adalah
   PROTOTIPE ANTARMUKA (front-end saja). Tidak ada proses
   autentikasi maupun penyimpanan data sungguhan — perlu
   dihubungkan ke backend/CMS sebelum dipakai produksi.
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ---------- 1. Toggle menu mobile (semua halaman publik) ---------- */
  var menuBtn = document.getElementById('menuBtn');
  var mobileMenu = document.getElementById('mobileMenu');
  var iconOpen = document.getElementById('iconOpen');
  var iconClose = document.getElementById('iconClose');

  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', function () {
      mobileMenu.classList.toggle('hidden');
      if (iconOpen) iconOpen.classList.toggle('hidden');
      if (iconClose) iconClose.classList.toggle('hidden');
    });
    mobileMenu.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
        if (iconOpen) iconOpen.classList.remove('hidden');
        if (iconClose) iconClose.classList.add('hidden');
      });
    });
  }

  /* ---------- 2. Filter galeri (gallery.html) ---------- */
  var filterBtns = document.querySelectorAll('.filter-btn');
  var galleryCards = document.querySelectorAll('.gallery-card');

  if (filterBtns.length && galleryCards.length) {
    filterBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var target = btn.getAttribute('data-filter');

        filterBtns.forEach(function (b) {
          b.classList.remove('bg-forest-700', 'text-sand-50');
          b.classList.add('border', 'border-sand-300', 'text-ink/70');
        });
        btn.classList.add('bg-forest-700', 'text-sand-50');
        btn.classList.remove('border', 'border-sand-300', 'text-ink/70');

        galleryCards.forEach(function (card) {
          var cat = card.getAttribute('data-category');
          var show = target === 'all' || target === cat;
          card.style.display = show ? '' : 'none';
        });
      });
    });
  }

  /* ---------- 3. Form kontak -> kirim via email klien (contact.html) ---------- */
  var contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var name = document.getElementById('cf-name').value.trim();
      var phone = document.getElementById('cf-phone').value.trim();
      var message = document.getElementById('cf-message').value.trim();

      var subject = encodeURIComponent('Pesan dari Website — ' + (name || 'Orang Tua/Wali'));
      var body = encodeURIComponent(
        'Nama: ' + name + '\n' +
        'No. WhatsApp: ' + phone + '\n\n' +
        'Pesan:\n' + message
      );
      window.location.href = 'mailto:kbaisyiyah2dau@email.com?subject=' + subject + '&body=' + body;
    });
  }

  /* ---------- 4. Tampil/sembunyi kata sandi (login.html) ---------- */
  var togglePassword = document.getElementById('togglePassword');
  var passwordInput = document.getElementById('password');
  if (togglePassword && passwordInput) {
    togglePassword.addEventListener('click', function () {
      var isHidden = passwordInput.type === 'password';
      passwordInput.type = isHidden ? 'text' : 'password';
      togglePassword.textContent = isHidden ? 'Sembunyikan' : 'Tampilkan';
    });
  }

  /* ---------- 5. Form login -> redirect demo ke dashboard (login.html) ---------- */
  var loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      window.location.href = 'admin-dashboard.html';
    });
  }

  /* ---------- 6. Navigasi panel dashboard (admin-dashboard.html) ---------- */
  var dashLinks = document.querySelectorAll('.dash-nav-link');
  var dashPanels = document.querySelectorAll('.dash-panel');
  var dashTitle = document.getElementById('dashPanelTitle');

  if (dashLinks.length && dashPanels.length) {
    dashLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        var target = link.getAttribute('data-panel');

        dashLinks.forEach(function (l) {
          l.classList.remove('bg-sand-50/10', 'text-sand-50');
          l.classList.add('text-sand-100/70');
        });
        link.classList.add('bg-sand-50/10', 'text-sand-50');
        link.classList.remove('text-sand-100/70');

        dashPanels.forEach(function (panel) {
          panel.classList.toggle('hidden', panel.getAttribute('data-panel') !== target);
        });

        if (dashTitle) dashTitle.textContent = link.getAttribute('data-label') || '';

        var mobileSidebar = document.getElementById('dashSidebar');
        if (mobileSidebar && window.innerWidth < 1024) mobileSidebar.classList.add('-translate-x-full');
      });
    });
  }

  /* ---------- 7. Toggle sidebar dashboard di mobile ---------- */
  var dashMenuBtn = document.getElementById('dashMenuBtn');
  var dashSidebar = document.getElementById('dashSidebar');
  if (dashMenuBtn && dashSidebar) {
    dashMenuBtn.addEventListener('click', function () {
      dashSidebar.classList.toggle('-translate-x-full');
    });
  }

  /* ---------- 8. Notifikasi toast untuk tombol "Simpan Perubahan" ---------- */
  var toast = document.getElementById('dashToast');
  var toastTimer;
  function showToast(text) {
    if (!toast) return;
    toast.textContent = text;
    toast.classList.remove('translate-y-24', 'opacity-0');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () {
      toast.classList.add('translate-y-24', 'opacity-0');
    }, 2600);
  }

  document.querySelectorAll('.save-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      showToast('Perubahan tersimpan — mode demo, belum terhubung ke database.');
    });
  });

  /* ---------- 9. Hapus / tambah kartu foto di panel Kelola Gallery ---------- */
  document.querySelectorAll('.remove-photo-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var card = btn.closest('.photo-card');
      if (card) card.remove();
      showToast('Foto dihapus dari daftar — mode demo.');
    });
  });

  var addPhotoBtn = document.getElementById('addPhotoBtn');
  var photoGrid = document.getElementById('photoGrid');
  if (addPhotoBtn && photoGrid) {
    addPhotoBtn.addEventListener('click', function () {
      var card = document.createElement('div');
      card.className = 'photo-card border border-sand-300 bg-sand-50 p-3';
      card.innerHTML =
        '<div class="aspect-square bg-sand-200 border border-sand-300 flex items-center justify-center mb-3">' +
        '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9c7838" stroke-width="1.5"><rect x="3" y="5" width="18" height="14" rx="1"/><circle cx="9" cy="10" r="2"/><path d="m21 15-4-4-9 8"/></svg>' +
        '</div>' +
        '<input type="text" value="Foto Baru" class="w-full text-xs font-semibold border border-sand-300 px-2 py-1.5 mb-2 bg-white">' +
        '<div class="flex gap-2">' +
        '<button type="button" class="flex-1 text-[11px] font-semibold uppercase tracking-wide border border-forest-700 text-forest-700 py-1.5">Ganti</button>' +
        '<button type="button" class="remove-photo-btn flex-1 text-[11px] font-semibold uppercase tracking-wide border border-sand-400 text-ink/60 py-1.5">Hapus</button>' +
        '</div>';
      photoGrid.insertBefore(card, addPhotoBtn.parentElement);
      card.querySelector('.remove-photo-btn').addEventListener('click', function () {
        card.remove();
        showToast('Foto dihapus dari daftar — mode demo.');
      });
      showToast('Foto baru ditambahkan — mode demo.');
    });
  }

});
