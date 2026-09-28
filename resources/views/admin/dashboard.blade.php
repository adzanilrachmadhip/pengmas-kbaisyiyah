<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin — KB &apos;Aisyiyah 2 Dau</title>
@fonts
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-50 text-ink font-sans antialiased">

<div class="lg:flex min-h-screen">

  <!-- ============ SIDEBAR ============ -->
  <aside id="dashSidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-72 bg-forest-800 text-sand-50 flex flex-col transition-transform -translate-x-full lg:translate-x-0">
    <div class="h-20 flex items-center gap-3 px-6 border-b border-sand-50/10 shrink-0">
      <span class="w-9 h-9 rounded-full bg-sand-50/10 flex items-center justify-center shrink-0">
        <x-icon name="logo" :size="16" stroke="#f4eee0" />
      </span>
      <span class="leading-tight">
        <span class="block font-bold text-[14px]">KB &apos;Aisyiyah 2 Dau</span>
        <span class="block text-[10px] uppercase tracking-[0.14em] text-sand-300">Panel Admin</span>
      </span>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
      <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-sand-100/40 mb-2">Menu</p>
      @php
        $navItems = [
            'overview' => 'Dashboard',
            'home' => 'Kelola Home',
            'about' => 'Kelola About Us',
            'struktur' => 'Kelola Struktur Organisasi',
            'sdm' => 'Kelola Sumber Daya Manusia',
            'gallery' => 'Kelola Gallery',
            'artikel' => 'Kelola Artikel',
            'messages' => 'Pesan Masuk',
            'settings' => 'Pengaturan Situs',
        ];
      @endphp
      @foreach ($navItems as $panel => $label)
        <button type="button" data-panel="{{ $panel }}" class="dash-nav-link w-full text-left px-3 py-3 text-sm font-semibold flex items-center gap-3 {{ $loop->first ? 'bg-sand-50/10 text-sand-50' : 'text-sand-100/70' }}">
          {{ $label }}
          @if ($panel === 'messages' && $stats['unread_messages'] > 0)
            <span class="ml-auto bg-forest-600 text-sand-50 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $stats['unread_messages'] }}</span>
          @endif
        </button>
      @endforeach

      <div class="pt-6 mt-6 border-t border-sand-50/10 space-y-1">
        <a href="{{ route('home') }}" target="_blank" class="w-full text-left px-3 py-3 text-sm font-semibold flex items-center gap-3 text-sand-100/70 hover:text-sand-50">
          Lihat Situs
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-3 py-3 text-sm font-semibold flex items-center gap-3 text-sand-100/70 hover:text-sand-50">
            Keluar
          </button>
        </form>
      </div>
    </nav>
  </aside>

  <!-- ============ MAIN ============ -->
  <div class="flex-1 min-w-0">
    <header class="h-20 bg-white border-b border-sand-200 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-20">
      <div class="flex items-center gap-4">
        <button id="dashMenuBtn" class="lg:hidden w-9 h-9 flex items-center justify-center text-forest-800">
          <x-icon name="menu" :size="22" :stroke-width="'1.8'" />
        </button>
        <h1 id="dashPanelTitle" class="font-extrabold text-lg sm:text-xl text-forest-800">Dashboard</h1>
      </div>
      <div class="flex items-center gap-3">
        <span class="hidden sm:block text-sm text-ink/60">{{ $admin->name }}</span>
        <span class="w-9 h-9 rounded-full bg-forest-700 text-sand-50 flex items-center justify-center text-xs font-bold shrink-0">{{ mb_substr($admin->name, 0, 1) }}</span>
      </div>
    </header>

    <main class="p-6 lg:p-10">

      <!-- ===== PANEL: OVERVIEW ===== -->
      <section class="dash-panel" data-panel="overview">
        <p class="text-sm text-ink/60 mb-8">Ringkasan konten situs KB &apos;Aisyiyah 2 Dau.</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
          <div class="border border-sand-300 bg-white p-6">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-ink/45 mb-2">Halaman Aktif</p>
            <p class="text-3xl font-extrabold text-forest-800">{{ $stats['active_pages'] }}</p>
          </div>
          <div class="border border-sand-300 bg-white p-6">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-ink/45 mb-2">Foto Galeri</p>
            <p class="text-3xl font-extrabold text-forest-800">{{ $stats['gallery_photos'] }}</p>
          </div>
          <div class="border border-sand-300 bg-white p-6">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-ink/45 mb-2">Pesan Masuk (Baru)</p>
            <p class="text-3xl font-extrabold text-forest-800">{{ $stats['unread_messages'] }}</p>
          </div>
          <div class="border border-sand-300 bg-white p-6">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-ink/45 mb-2">Terakhir Diperbarui</p>
            <p class="text-lg font-extrabold text-forest-800">{{ $stats['last_updated']?->translatedFormat('d M Y') ?? '—' }}</p>
          </div>
        </div>
      </section>

      <!-- ===== PANEL: PESAN MASUK ===== -->
      <section class="dash-panel hidden" data-panel="messages">
        <p class="text-sm text-ink/60 mb-8">Pesan yang dikirim pengunjung melalui formulir Contact Us.</p>
        <div class="border border-sand-300 bg-white divide-y divide-sand-200">
          @forelse ($messages as $message)
            <div class="p-6 flex flex-col sm:flex-row sm:items-start gap-4">
              <div class="flex-1">
                <div class="flex items-center gap-3 mb-1">
                  <p class="font-bold text-forest-800 text-sm">{{ $message->name }}</p>
                  @if ($message->status === 'new')
                    <span class="bg-forest-700 text-sand-50 text-[10px] font-semibold uppercase px-2 py-0.5">Baru</span>
                  @endif
                </div>
                <p class="text-xs text-ink/50 mb-3">{{ $message->phone }} &middot; {{ $message->created_at->translatedFormat('d M Y, H:i') }}</p>
                <p class="text-sm text-ink/70">{{ $message->message }}</p>
              </div>
            </div>
          @empty
            <p class="p-6 text-sm text-ink/50">Belum ada pesan masuk.</p>
          @endforelse
        </div>
      </section>

      <!-- ===== PANEL LAINNYA (placeholder) ===== -->
      @foreach (['home' => 'Home', 'about' => 'About Us', 'struktur' => 'Struktur Organisasi', 'sdm' => 'Sumber Daya Manusia', 'gallery' => 'Gallery', 'artikel' => 'Artikel', 'settings' => 'Pengaturan Situs'] as $panel => $label)
        <section class="dash-panel hidden" data-panel="{{ $panel }}">
          <div class="border border-dashed border-sand-400 bg-white p-10 text-center">
            <p class="text-sm text-ink/60">Formulir pengelolaan konten {{ $label }} akan tersedia di sini.</p>
          </div>
        </section>
      @endforeach

    </main>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var dashLinks = document.querySelectorAll('.dash-nav-link');
    var dashPanels = document.querySelectorAll('.dash-panel');
    var dashTitle = document.getElementById('dashPanelTitle');
    var labels = @json($navItems);

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
        if (dashTitle) dashTitle.textContent = labels[target] || '';
        var mobileSidebar = document.getElementById('dashSidebar');
        if (mobileSidebar && window.innerWidth < 1024) mobileSidebar.classList.add('-translate-x-full');
      });
    });

    var dashMenuBtn = document.getElementById('dashMenuBtn');
    var dashSidebar = document.getElementById('dashSidebar');
    if (dashMenuBtn && dashSidebar) {
      dashMenuBtn.addEventListener('click', function () {
        dashSidebar.classList.toggle('-translate-x-full');
      });
    }
  });
</script>

</body>
</html>
