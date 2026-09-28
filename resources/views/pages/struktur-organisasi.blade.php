<x-layouts.app title="Struktur Organisasi">

<!-- ============ PAGE HEADER ============ -->
<section class="pt-40 pb-16 lg:pt-48 lg:pb-20 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <p class="text-xs text-ink/45 mb-5">
      <a href="{{ route('home') }}" class="hover:text-forest-700">Home</a> /
      <a href="{{ route('about') }}" class="hover:text-forest-700">About Us</a> /
      <span class="text-forest-700">Struktur Organisasi</span>
    </p>
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">About Us</p>
    <x-ecms.text section="struktur_organisasi" key="page_title" tag="h1" class="font-extrabold text-3xl sm:text-5xl text-forest-800 max-w-2xl mb-6" />
    <x-ecms.richtext section="struktur_organisasi" key="intro_text" tag="p" class="text-[15px] text-ink/70 max-w-xl" />
  </div>
</section>

<!-- ============ BAGAN STRUKTUR ============ -->
<section class="py-24">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="border border-sand-300 bg-white p-5">
      <x-ecms.image section="struktur_organisasi" key="struktur_image" alt="Bagan Struktur Organisasi" class="w-full object-contain">
        <div class="aspect-video bg-forest-100 border border-forest-200 flex flex-col items-center justify-center gap-3 text-center px-6">
          <x-icon name="people" :size="30" stroke="#264a34" :stroke-width="'1.4'" />
          <p class="text-[11px] uppercase tracking-[0.14em] text-forest-700 font-semibold">Bagan Struktur Organisasi</p>
          <p class="text-xs text-forest-600 max-w-sm">Gambar bagan belum diunggah &mdash; lengkapi melalui panel admin.</p>
        </div>
      </x-ecms.image>
    </div>
    <x-ecms.text section="struktur_organisasi" key="image_caption" tag="p" class="text-xs text-ink/50 mt-4" />
  </div>
</section>

</x-layouts.app>
