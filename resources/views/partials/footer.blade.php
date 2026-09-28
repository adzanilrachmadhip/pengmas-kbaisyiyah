<footer class="bg-forest-900 text-sand-100">
  <div class="max-w-6xl mx-auto px-6 lg:px-8 py-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
    <div class="lg:col-span-2">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-9 h-9 rounded-full bg-sand-50/10 flex items-center justify-center shrink-0">
          <x-icon name="logo" :size="16" stroke="#f4eee0" />
        </span>
        <span class="font-bold text-sand-50">{{ $settings->site_name }}</span>
      </div>
      <p class="text-sm text-sand-100/60 leading-relaxed max-w-sm">
        {{ $settings->tagline }} di bawah naungan Pimpinan Cabang &apos;Aisyiyah Dau, Kabupaten Malang &mdash;
        mendampingi tumbuh kembang anak usia dini secara islami dan menyenangkan.
      </p>
    </div>
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-sand-100/50 mb-4">Menu</p>
      <ul class="space-y-2 text-sm text-sand-100/70">
        <li><a href="{{ route('home') }}" class="hover:text-sand-50">Home</a></li>
        <li><a href="{{ route('about') }}" class="hover:text-sand-50">About Us</a></li>
        <li><a href="{{ route('gallery') }}" class="hover:text-sand-50">Gallery</a></li>
        <li><a href="{{ route('artikel.index') }}" class="hover:text-sand-50">Artikel</a></li>
      </ul>
    </div>
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-sand-100/50 mb-4">Kontak</p>
      <ul class="space-y-2 text-sm text-sand-100/70">
        @if ($settings->address)
          <li>{{ $settings->address }}</li>
        @endif
        @if ($settings->phone)
          <li>{{ $settings->phone }}</li>
        @endif
        @if ($settings->instagram_url)
          <li><a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener" class="hover:text-sand-50">{{ $settings->instagram_handle }}</a></li>
        @endif
      </ul>
    </div>
  </div>
  <div class="border-t border-sand-50/10">
    <div class="max-w-6xl mx-auto px-6 lg:px-8 py-6 flex flex-wrap items-center justify-between gap-3 text-xs text-sand-100/45">
      <span>&copy; {{ now()->year }} {{ $settings->site_name }}. Bagian dari Pimpinan Cabang &apos;Aisyiyah Dau, Kabupaten Malang.</span>
      <a href="{{ route('login') }}" class="text-sand-100/40 hover:text-sand-100/70">Login Admin</a>
    </div>
  </div>
</footer>
