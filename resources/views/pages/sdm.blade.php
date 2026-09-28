<x-layouts.app title="Sumber Daya Manusia">

<!-- ============ PAGE HEADER ============ -->
<section class="pt-40 pb-16 lg:pt-48 lg:pb-20 border-b border-sand-200">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <p class="text-xs text-ink/45 mb-5">
      <a href="{{ route('home') }}" class="hover:text-forest-700">Home</a> /
      <a href="{{ route('about') }}" class="hover:text-forest-700">About Us</a> /
      <span class="text-forest-700">Sumber Daya Manusia</span>
    </p>
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-4">About Us</p>
    <x-ecms.text section="sdm" key="page_title" tag="h1" class="font-extrabold text-3xl sm:text-5xl text-forest-800 max-w-2xl mb-6" />
    <x-ecms.richtext section="sdm" key="intro_text" tag="p" class="text-[15px] text-ink/70 max-w-xl" />
  </div>
</section>

<!-- ============ TENAGA PENDIDIK & STAF ============ -->
<section class="py-24">
  <div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($staff as $i => $member)
        <div class="border border-sand-300 bg-white p-7 text-center">
          @if ($member->photo_path)
            <img src="{{ Storage::url($member->photo_path) }}" alt="{{ $member->name }}" class="w-16 h-16 rounded-full object-cover mx-auto mb-4">
          @else
            <div class="w-16 h-16 rounded-full {{ $i % 2 === 0 ? 'bg-forest-100 border border-forest-200 text-forest-700' : 'bg-sand-200 border border-sand-300 text-sand-700' }} mx-auto mb-4 flex items-center justify-center font-bold">
              {{ $member->initials }}
            </div>
          @endif
          <p class="font-bold text-forest-800 text-sm">{{ $member->role }}</p>
          <p class="text-xs text-ink/50 mt-1">{{ $member->name }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

</x-layouts.app>
