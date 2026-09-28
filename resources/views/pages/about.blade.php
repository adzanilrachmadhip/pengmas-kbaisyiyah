<x-layouts.app title="About Us">

<!-- ============ PAGE HEADER ============ -->
<section class="pt-40 pb-16 lg:pt-48 lg:pb-20 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <p class="text-xs text-ink/45 mb-5"><a href="{{ route('home') }}" class="hover:text-forest-700">Home</a> / <span class="text-forest-700">About Us</span></p>
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">About Us</p>
    <x-ecms.text section="about" key="page_title" tag="h1" class="font-extrabold text-3xl sm:text-5xl text-forest-800 max-w-2xl" />
  </div>
</section>

<!-- ============ SEJARAH & NAUNGAN ============ -->
<section class="py-24 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8 grid lg:grid-cols-12 gap-14">
    <div class="lg:col-span-7">
      <x-ecms.text section="about" key="sejarah_eyebrow" tag="p" class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4" />
      <x-ecms.text section="about" key="sejarah_title" tag="h2" class="font-extrabold text-2xl sm:text-3xl text-forest-800 mb-6" />
      <x-ecms.richtext section="about" key="sejarah_paragraf_1" tag="p" class="text-[15px] leading-relaxed text-ink/75 mb-5" />
      <x-ecms.richtext section="about" key="sejarah_paragraf_2" tag="p" class="text-[15px] leading-relaxed text-ink/75 mb-5" />
      <x-ecms.richtext section="about" key="sejarah_paragraf_3" tag="p" class="text-[15px] leading-relaxed text-ink/75" />
    </div>
    <div class="lg:col-span-5">
      <div class="border border-sand-300 p-8 bg-white">
        <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-3">Visi</p>
        <p class="text-lg leading-relaxed font-medium text-forest-800 mb-8">
          &ldquo;{{ ecms('about.visi') }}&rdquo;
        </p>
        <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">Misi</p>
        <ul class="space-y-3 text-[14px] text-ink/75">
          @foreach ($missionPoints as $point)
            <li class="flex gap-3"><span class="text-sand-600 mt-1">&mdash;</span><span>{{ $point->content }}</span></li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ ASPEK PERKEMBANGAN ============ -->
<section class="py-24 border-b border-sand-200 bg-forest-800 text-sand-50">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="max-w-2xl mb-14">
      <x-ecms.text section="about" key="perkembangan_eyebrow" tag="p" class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-300 mb-4" />
      <x-ecms.text section="about" key="perkembangan_title" tag="h2" class="font-extrabold text-2xl sm:text-3xl" />
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-sand-50/15 border border-sand-50/15">
      @foreach ($developmentAspects as $aspect)
        <div class="bg-forest-800 p-7">
          <p class="font-semibold text-sm mb-2">{{ $aspect->title }}</p>
          <p class="text-xs text-sand-100/70 leading-relaxed">{{ $aspect->description }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ============ FASILITAS ============ -->
<section class="py-24 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="max-w-2xl mb-14">
      <x-ecms.text section="about" key="fasilitas_eyebrow" tag="p" class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4" />
      <x-ecms.text section="about" key="fasilitas_title" tag="h2" class="font-extrabold text-2xl sm:text-3xl text-forest-800" />
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-px bg-sand-200 border border-sand-200">
      @foreach ($facilities as $facility)
        <div class="bg-sand-50 p-7">
          <h3 class="font-bold text-forest-800 mb-2 text-sm">{{ $facility->title }}</h3>
          <p class="text-xs leading-relaxed text-ink/65">{{ $facility->description }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ============ LINK SDM ============ -->
<section class="py-24 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="border border-sand-300 bg-white p-10 sm:p-14 grid lg:grid-cols-12 gap-10 items-center">
      <div class="lg:col-span-8">
        <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">Tenaga Pendidik</p>
        <h2 class="font-extrabold text-2xl sm:text-3xl text-forest-800 mb-3">Kenali Sumber Daya Manusia Kami</h2>
        <p class="text-[15px] text-ink/70 max-w-xl">Lihat daftar tenaga pendidik dan staf yang mendampingi tumbuh kembang anak di KB &apos;Aisyiyah 2 Dau.</p>
      </div>
      <div class="lg:col-span-4 flex lg:justify-end">
        <a href="{{ route('about.sdm') }}" class="inline-flex items-center gap-2 bg-forest-700 hover:bg-forest-800 text-sand-50 text-sm font-semibold uppercase tracking-wide px-7 py-3.5 rounded-sm transition-colors">
          Lihat Sumber Daya Manusia
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="py-24">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="border border-sand-300 bg-white p-10 sm:p-14 grid lg:grid-cols-12 gap-10 items-center">
      <div class="lg:col-span-8">
        <x-ecms.text section="about" key="cta_title" tag="h2" class="font-extrabold text-2xl sm:text-3xl text-forest-800 mb-3" />
        <x-ecms.text section="about" key="cta_body" tag="p" class="text-[15px] text-ink/70 max-w-xl" />
      </div>
      <div class="lg:col-span-4 flex lg:justify-end">
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-forest-700 hover:bg-forest-800 text-sand-50 text-sm font-semibold uppercase tracking-wide px-7 py-3.5 rounded-sm transition-colors">
          Hubungi Kami
        </a>
      </div>
    </div>
  </div>
</section>

</x-layouts.app>
