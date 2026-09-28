@php
    $aboutRoutes = ['about', 'about.struktur-organisasi', 'about.sdm'];
@endphp
<header class="fixed top-0 inset-x-0 z-50 bg-sand-50/95 backdrop-blur border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">
    <a href="{{ route('home') }}" class="flex items-center gap-3">
      <span class="w-10 h-10 rounded-full bg-forest-700 flex items-center justify-center shrink-0">
        <x-icon name="logo" :size="18" stroke="#f4eee0" />
      </span>
      <span class="leading-tight">
        <span class="block font-bold text-[15px] tracking-tight text-forest-800">{{ $settings->site_name }}</span>
        <span class="block text-[11px] uppercase tracking-[0.14em] text-forest-500">{{ $settings->tagline }}</span>
      </span>
    </a>

    <nav class="hidden md:flex items-center gap-10 text-[13px] font-semibold tracking-wide uppercase">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-forest-500' : 'text-forest-800 hover:text-forest-500 transition-colors' }}">Home</a>

      <div class="relative">
        <button type="button" id="aboutDropdownToggle" aria-expanded="false" aria-haspopup="true"
          class="flex items-center gap-1.5 {{ request()->routeIs($aboutRoutes) ? 'text-forest-500' : 'text-forest-800 hover:text-forest-500 transition-colors' }}">
          About Us
          <x-icon name="chevron-down" :size="13" :stroke-width="'2'" />
        </button>
        <div id="aboutDropdownPanel" class="hidden absolute left-0 top-full mt-3 w-72 bg-sand-50 border border-sand-200 shadow-lg py-2">
          <a href="{{ route('about') }}" class="block px-5 py-3 text-[13px] normal-case font-semibold tracking-normal text-forest-800 hover:bg-sand-100">About KB &apos;Aisyiyah 2 Dau</a>
          <a href="{{ route('about.struktur-organisasi') }}" class="block px-5 py-3 text-[13px] normal-case font-semibold tracking-normal text-forest-800 hover:bg-sand-100">Struktur Organisasi</a>
          <a href="{{ route('about.sdm') }}" class="block px-5 py-3 text-[13px] normal-case font-semibold tracking-normal text-forest-800 hover:bg-sand-100">Sumber Daya Manusia</a>
        </div>
      </div>

      <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'text-forest-500' : 'text-forest-800 hover:text-forest-500 transition-colors' }}">Gallery</a>
      <a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('artikel.*') ? 'text-forest-500' : 'text-forest-800 hover:text-forest-500 transition-colors' }}">Artikel</a>
    </nav>

    <a href="{{ route('contact') }}" class="hidden md:inline-flex items-center gap-2 bg-forest-700 hover:bg-forest-800 text-sand-50 text-[13px] font-semibold uppercase tracking-wide px-5 py-2.5 rounded-sm transition-colors">
      Hubungi Kami
    </a>

    <button id="menuBtn" aria-label="Buka menu" class="md:hidden w-10 h-10 flex items-center justify-center text-forest-800">
      <x-icon id="iconOpen" name="menu" :size="24" :stroke-width="'1.8'" />
      <x-icon id="iconClose" name="close" :size="24" :stroke-width="'1.8'" class="hidden" />
    </button>
  </div>

  <div id="mobileMenu" class="hidden md:hidden border-t border-sand-200 bg-sand-50">
    <nav class="flex flex-col px-6 py-4 gap-1 text-sm font-semibold uppercase tracking-wide text-forest-800">
      <a href="{{ route('home') }}" class="py-3 border-b border-sand-200 {{ request()->routeIs('home') ? 'text-forest-500' : '' }}">Home</a>

      <div class="border-b border-sand-200">
        <button type="button" id="mobileAboutToggle" class="w-full flex items-center justify-between py-3">
          <span>About Us</span>
          <x-icon name="chevron-down" :size="14" :stroke-width="'2'" class="transition-transform" />
        </button>
        <div id="mobileAboutPanel" class="hidden pb-3 pl-4 flex flex-col gap-1 normal-case font-medium text-[13px]">
          <a href="{{ route('about') }}" class="py-2">About KB &apos;Aisyiyah 2 Dau</a>
          <a href="{{ route('about.struktur-organisasi') }}" class="py-2">Struktur Organisasi</a>
          <a href="{{ route('about.sdm') }}" class="py-2">Sumber Daya Manusia</a>
        </div>
      </div>

      <a href="{{ route('gallery') }}" class="py-3 border-b border-sand-200">Gallery</a>
      <a href="{{ route('artikel.index') }}" class="py-3">Artikel</a>
    </nav>
  </div>
</header>
