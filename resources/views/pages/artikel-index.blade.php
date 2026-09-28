@php
    $highlighted = $articles->firstWhere('is_highlight', true);
@endphp
<x-layouts.app title="Artikel">

<section class="pt-40 pb-16 lg:pt-48 lg:pb-20 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <p class="text-xs text-ink/45 mb-5"><a href="{{ route('home') }}" class="hover:text-forest-700">Home</a> / <span class="text-forest-700">Artikel</span></p>
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">Artikel</p>
    <x-ecms.text section="artikel" key="page_title" tag="h1" class="font-extrabold text-3xl sm:text-5xl text-forest-800 max-w-2xl mb-6" />
    <x-ecms.text section="artikel" key="intro_text" tag="p" class="text-[15px] text-ink/70 max-w-xl" />
  </div>
</section>

<section class="py-16">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">

    @if ($highlighted)
      <a href="{{ route('artikel.show', $highlighted) }}" class="group grid lg:grid-cols-12 gap-0 border border-sand-300 bg-white mb-12">
        <div class="lg:col-span-6 aspect-video lg:aspect-auto bg-forest-100 border-b lg:border-b-0 lg:border-r border-forest-200 flex flex-col items-center justify-center gap-2 text-center px-6">
          @if ($highlighted->cover_image)
            <img src="{{ Storage::url($highlighted->cover_image) }}" alt="{{ $highlighted->title }}" class="w-full h-full object-cover">
          @else
            <x-icon name="camera" :size="26" stroke="#2f5d40" />
            <p class="text-xs font-semibold text-forest-700">{{ $highlighted->title }}</p>
          @endif
        </div>
        <div class="lg:col-span-6 p-8 sm:p-10 flex flex-col justify-center">
          <span class="inline-flex w-fit items-center gap-2 bg-forest-700 text-sand-50 text-[10px] font-semibold uppercase tracking-wide px-3 py-1.5 mb-4">Sorotan</span>
          <p class="text-xs text-ink/45 mb-3">{{ $highlighted->published_at?->translatedFormat('d F Y') }}</p>
          <h2 class="font-extrabold text-2xl sm:text-3xl text-forest-800 mb-3 group-hover:text-forest-600 transition-colors">{{ $highlighted->title }}</h2>
          <p class="text-[15px] text-ink/70 mb-6">{{ $highlighted->excerpt }}</p>
          <span class="inline-flex items-center gap-2 text-forest-700 text-sm font-semibold uppercase tracking-wide">
            Read More
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </span>
        </div>
      </a>
    @endif

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($articles->where('id', '!=', $highlighted?->id) as $i => $article)
        <a href="{{ route('artikel.show', $article) }}" class="group border border-sand-300 bg-white flex flex-col">
          <div class="aspect-video {{ $i % 2 === 0 ? 'bg-forest-100 border-b border-forest-200' : 'bg-sand-200 border-b border-sand-300' }} flex flex-col items-center justify-center gap-2 text-center px-4">
            @if ($article->cover_image)
              <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            @else
              <x-icon name="camera" :size="20" :stroke="$i % 2 === 0 ? '#2f5d40' : '#9c7838'" />
            @endif
          </div>
          <div class="p-6 flex flex-col flex-1">
            <p class="text-xs text-ink/45 mb-2">{{ $article->published_at?->translatedFormat('d F Y') }}</p>
            <h3 class="font-bold text-forest-800 mb-2 group-hover:text-forest-600 transition-colors">{{ $article->title }}</h3>
            <p class="text-xs leading-relaxed text-ink/65 mb-4 flex-1">{{ \Illuminate\Support\Str::limit($article->excerpt, 110) }}</p>
            <span class="inline-flex items-center gap-1.5 text-forest-700 text-[11px] font-semibold uppercase tracking-wide">
              Read More
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>
      @endforeach
    </div>

    @if ($articles->isEmpty())
      <p class="text-sm text-ink/50">Belum ada artikel yang dipublikasikan.</p>
    @endif

    <div class="mt-12">
      {{ $articles->links() }}
    </div>
  </div>
</section>

</x-layouts.app>
