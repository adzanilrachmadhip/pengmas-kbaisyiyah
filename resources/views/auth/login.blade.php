<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — {{ $settings->site_name }}</title>
<meta name="description" content="Masuk ke panel admin KB 'Aisyiyah 2 Dau untuk mengelola konten situs.">
@fonts
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-50 text-ink font-sans antialiased">

<div class="min-h-screen grid lg:grid-cols-2">

  <!-- Panel brand -->
  <div class="hidden lg:flex flex-col justify-between bg-forest-800 text-sand-50 p-14">
    <a href="{{ route('home') }}" class="flex items-center gap-3">
      <span class="w-10 h-10 rounded-full bg-sand-50/10 flex items-center justify-center shrink-0">
        <x-icon name="logo" :size="18" stroke="#f4eee0" />
      </span>
      <span class="leading-tight">
        <span class="block font-bold text-[15px]">KB &apos;Aisyiyah 2 Dau</span>
        <span class="block text-[11px] uppercase tracking-[0.14em] text-sand-300">Panel Admin</span>
      </span>
    </a>

    <div class="max-w-sm">
      <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-300 mb-5">Kelola Konten Situs</p>
      <h1 class="font-extrabold text-3xl leading-tight mb-6">Satu Panel untuk Mengelola Seluruh Halaman</h1>
      <p class="text-sand-100/80 text-sm leading-relaxed">
        Perbarui konten Home, About Us, Gallery, dan Artikel KB &apos;Aisyiyah 2 Dau dari satu tempat yang sama.
      </p>
    </div>

    <a href="{{ route('home') }}" class="text-sand-100/60 hover:text-sand-50 text-xs font-semibold uppercase tracking-wide inline-flex items-center gap-2">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
      Kembali ke Beranda
    </a>
  </div>

  <!-- Panel form -->
  <div class="flex items-center justify-center p-8 sm:p-14">
    <div class="w-full max-w-sm">

      <div class="lg:hidden flex items-center gap-3 mb-12">
        <span class="w-10 h-10 rounded-full bg-forest-700 flex items-center justify-center shrink-0">
          <x-icon name="logo" :size="18" stroke="#f4eee0" />
        </span>
        <span class="leading-tight">
          <span class="block font-bold text-[15px] text-forest-800">KB &apos;Aisyiyah 2 Dau</span>
          <span class="block text-[11px] uppercase tracking-[0.14em] text-forest-500">Panel Admin</span>
        </span>
      </div>

      <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">Login Admin</p>
      <h2 class="font-extrabold text-2xl sm:text-3xl text-forest-800 mb-2">Selamat Datang Kembali</h2>
      <p class="text-sm text-ink/60 mb-10">Masuk untuk mengelola konten situs KB &apos;Aisyiyah 2 Dau.</p>

      @if (session('status'))
        <div class="mb-6 border border-forest-300 bg-forest-50 text-forest-800 text-sm px-4 py-3">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf
        <div>
          <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-forest-800 mb-2">Email</label>
          <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}" placeholder="admin@kbaisyiyah2dau.local"
            class="w-full border border-sand-300 bg-white px-4 py-3 text-sm focus:outline-none focus:border-forest-600">
          @error('email')
            <p class="mt-2 text-xs text-red-700">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-forest-800 mb-2">Kata Sandi</label>
          <div class="flex border border-sand-300 bg-white focus-within:border-forest-600">
            <input id="password" name="password" type="password" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
              class="w-full px-4 py-3 text-sm focus:outline-none">
            <button type="button" id="togglePassword" class="shrink-0 px-4 text-[11px] font-semibold uppercase tracking-wide text-forest-700 hover:text-forest-500">Tampilkan</button>
          </div>
          @error('password')
            <p class="mt-2 text-xs text-red-700">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex items-center justify-between text-xs">
          <label class="flex items-center gap-2 text-ink/60">
            <input type="checkbox" name="remember" class="w-4 h-4 border border-sand-400 accent-forest-700">
            Ingat saya
          </label>
        </div>

        <button type="submit" class="w-full bg-forest-700 hover:bg-forest-800 text-sand-50 text-sm font-semibold uppercase tracking-wide px-7 py-3.5 rounded-sm transition-colors">
          Masuk
        </button>
      </form>

    </div>
  </div>

</div>

</body>
</html>
