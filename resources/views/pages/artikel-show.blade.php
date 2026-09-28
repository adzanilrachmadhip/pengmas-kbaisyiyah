<x-layouts.app :title="$article->title" :description="$article->excerpt">

<section class="pt-40 pb-12 lg:pt-48 lg:pb-16 border-b border-sand-200">
  <div class="max-w-3xl mx-auto px-6 lg:px-8">
    <p class="text-xs text-ink/45 mb-5">
      <a href="{{ route('home') }}" class="hover:text-forest-700">Home</a> /
      <a href="{{ route('artikel.index') }}" class="hover:text-forest-700">Artikel</a> /
      <span class="text-forest-700">{{ \Illuminate\Support\Str::limit($article->title, 40) }}</span>
    </p>
    @if ($article->is_highlight)
      <span class="inline-flex w-fit items-center gap-2 bg-forest-700 text-sand-50 text-[10px] font-semibold uppercase tracking-wide px-3 py-1.5 mb-4">Sorotan</span>
    @endif
    <p class="text-xs text-ink/45 mb-4">{{ $article->published_at?->translatedFormat('d F Y') }}</p>
    <h1 class="font-extrabold text-3xl sm:text-4xl text-forest-800">{{ $article->title }}</h1>
  </div>
</section>

<section class="py-16">
  <div class="max-w-3xl mx-auto px-6 lg:px-8">
    <div class="aspect-video bg-forest-100 border border-forest-200 flex flex-col items-center justify-center gap-2 text-center px-6 mb-10">
      @if ($article->cover_image)
        <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
      @else
        <x-icon name="camera" :size="26" stroke="#2f5d40" />
        <p class="text-xs font-semibold text-forest-700">{{ $article->title }}</p>
      @endif
    </div>

    {{-- Body is admin-authored rich text; sanitized with mews/purifier once
         the rich-text editor ships (Step 5). --}}
    <div class="prose prose-sm sm:prose-base max-w-none text-ink/80 leading-relaxed [&>p]:mb-4">
      {!! $article->body !!}
    </div>

    <a href="{{ route('artikel.index') }}" class="inline-flex items-center gap-2 mt-12 text-forest-700 hover:text-forest-500 text-sm font-semibold uppercase tracking-wide">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
      Kembali ke Artikel
    </a>
  </div>
</section>

@if ($related->isNotEmpty())
<section class="py-16 border-t border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-8">Artikel Lainnya</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($related as $i => $item)
        <a href="{{ route('artikel.show', $item) }}" class="group border border-sand-300 bg-white flex flex-col">
          <div class="aspect-video {{ $i % 2 === 0 ? 'bg-forest-100 border-b border-forest-200' : 'bg-sand-200 border-b border-sand-300' }} flex items-center justify-center">
            @if ($item->cover_image)
              <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
            @else
              <x-icon name="camera" :size="20" :stroke="$i % 2 === 0 ? '#2f5d40' : '#9c7838'" />
            @endif
          </div>
          <div class="p-6">
            <p class="text-xs text-ink/45 mb-2">{{ $item->published_at?->translatedFormat('d F Y') }}</p>
            <h3 class="font-bold text-forest-800 text-sm group-hover:text-forest-600 transition-colors">{{ $item->title }}</h3>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

</x-layouts.app>
