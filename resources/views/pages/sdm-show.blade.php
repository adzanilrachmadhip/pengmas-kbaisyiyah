{{-- Staff/guru detail page. Deliberately professional-info only: name,
     role, photo, education history — no address/contact/location data. --}}
<x-layouts.app :title="$member->name">

<section class="pt-40 pb-16 lg:pt-48 lg:pb-20 border-b border-sand-200">
  <div class="max-w-4xl mx-auto px-6 lg:px-8">
    <p class="text-xs text-ink/45 mb-5">
      <a href="{{ route('home') }}" class="hover:text-forest-700">Home</a> /
      <a href="{{ route('about') }}" class="hover:text-forest-700">About Us</a> /
      <a href="{{ route('about.sdm') }}" class="hover:text-forest-700">Sumber Daya Manusia</a> /
      <span class="text-forest-700">{{ $member->name }}</span>
    </p>

    <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
      @if ($member->photo_path)
        <img src="{{ Storage::url($member->photo_path) }}" alt="{{ $member->name }}" class="w-28 h-28 rounded-full object-cover border border-sand-300 shrink-0">
      @else
        <div class="w-28 h-28 rounded-full bg-forest-100 border border-forest-200 text-forest-700 flex items-center justify-center text-2xl font-bold shrink-0">
          {{ $member->initials }}
        </div>
      @endif
      <div class="text-center sm:text-left">
        <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-2">{{ $member->role }}</p>
        <h1 class="font-extrabold text-3xl sm:text-4xl text-forest-800">{{ $member->name }}</h1>
      </div>
    </div>
  </div>
</section>

<section class="py-16">
  <div class="max-w-4xl mx-auto px-6 lg:px-8">
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-sand-600 mb-6">Riwayat Pendidikan</p>

    @if ($member->educationHistories->isNotEmpty())
      <div class="border border-sand-300 bg-white divide-y divide-sand-200">
        @foreach ($member->educationHistories as $education)
          <div class="p-6">
            <p class="font-bold text-forest-800 text-sm">{{ $education->degree }}</p>
            <p class="text-sm text-ink/60 mt-1">
              {{ $education->institution }}
              @if ($education->year)
                <span class="text-ink/40">&middot; {{ $education->year }}</span>
              @endif
            </p>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-sm text-ink/50">Riwayat pendidikan belum tersedia.</p>
    @endif

    <a href="{{ route('about.sdm') }}" class="inline-flex items-center gap-2 mt-12 text-forest-700 hover:text-forest-500 text-sm font-semibold uppercase tracking-wide">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
      Kembali ke Sumber Daya Manusia
    </a>
  </div>
</section>

</x-layouts.app>
