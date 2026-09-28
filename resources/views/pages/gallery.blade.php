<x-layouts.app title="Gallery">

<section class="pt-40 pb-16 lg:pt-48 lg:pb-20 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <p class="text-xs text-ink/45 mb-5"><a href="{{ route('home') }}" class="hover:text-forest-700">Home</a> / <span class="text-forest-700">Gallery</span></p>
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">Gallery</p>
    <x-ecms.text section="gallery" key="page_title" tag="h1" class="font-extrabold text-3xl sm:text-5xl text-forest-800 max-w-2xl mb-6" />
    <p class="text-[15px] text-ink/70 max-w-xl">
      {{ ecms('gallery.intro_text') }}
      @if ($settings->instagram_url)
        Kunjungi akun Instagram resmi kami
        <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener" class="text-forest-700 underline underline-offset-2 font-semibold">{{ $settings->instagram_handle }}</a>.
      @endif
    </p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">

    <div class="flex flex-wrap gap-3 mb-12">
      <button type="button" class="filter-btn bg-forest-700 text-sand-50 text-xs font-semibold uppercase tracking-wide px-5 py-2.5" data-filter="all">Semua</button>
      @foreach ($categories as $category)
        <button type="button" class="filter-btn border border-sand-300 text-ink/70 text-xs font-semibold uppercase tracking-wide px-5 py-2.5" data-filter="{{ $category->slug }}">{{ $category->name }}</button>
      @endforeach
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
      @foreach ($photos as $i => $photo)
        <div class="gallery-card {{ $i % 2 === 0 ? 'bg-forest-100 border border-forest-200' : 'bg-sand-200 border border-sand-300' }} aspect-square flex flex-col items-center justify-center gap-2 text-center px-4" data-category="{{ $photo->category?->slug }}">
          @if ($photo->image_path)
            <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover">
          @else
            <x-icon name="camera" :size="22" :stroke="$i % 2 === 0 ? '#2f5d40' : '#9c7838'" />
            <p class="text-xs font-semibold {{ $i % 2 === 0 ? 'text-forest-700' : 'text-sand-700' }}">{{ $photo->caption }}</p>
          @endif
        </div>
      @endforeach
    </div>

    @if ($photos->isEmpty())
      <p class="text-sm text-ink/50">Belum ada foto kegiatan yang ditambahkan.</p>
    @endif
  </div>
</section>

</x-layouts.app>
