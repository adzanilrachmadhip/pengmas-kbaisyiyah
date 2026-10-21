{{-- A single admin-editable content field bound to section_contents via
     data-ecms-* attributes. public/js/admin.js collects every
     [data-ecms-content] field inside a panel's "Simpan Perubahan" button,
     and handles [data-ecms-image] inputs immediately on change. --}}
@props(['section', 'key', 'label', 'type' => 'text'])
<div>
  <label class="block text-xs font-semibold uppercase tracking-wide text-forest-800 mb-2">{{ $label }}</label>

  @if ($type === 'image')
    @php $current = ecms("{$section}.{$key}"); @endphp
    <div class="flex items-center gap-4" data-ecms-image-field>
      <div class="w-24 h-24 border border-sand-300 bg-sand-50 flex items-center justify-center shrink-0 overflow-hidden" data-ecms-image-preview>
        @if ($current)
          <img src="{{ Storage::url($current) }}" alt="" class="w-full h-full object-cover">
        @else
          <x-icon name="camera" :size="20" stroke="#c7ab6c" />
        @endif
      </div>
      <div class="flex-1 space-y-2">
        <input type="file" accept="image/jpeg,image/png,image/webp,image/gif"
          data-ecms-image data-section="{{ $section }}" data-key="{{ $key }}"
          class="block w-full text-xs file:mr-3 file:py-2 file:px-3 file:border-0 file:bg-forest-700 file:text-sand-50 file:text-xs file:font-semibold file:uppercase">
        <p class="text-[11px] text-ink/50">{{ \App\Services\MediaService::hint() }}</p>
        @if ($current)
          <button type="button" data-ecms-image-clear data-section="{{ $section }}" data-key="{{ $key }}"
            class="text-[11px] font-semibold uppercase tracking-wide text-ink/50 hover:text-red-700">Hapus Gambar</button>
        @endif
      </div>
    </div>
  @elseif ($type === 'richtext' || $type === 'textarea')
    <textarea rows="4" data-ecms-content data-section="{{ $section }}" data-key="{{ $key }}"
      class="w-full border border-sand-300 bg-sand-50 px-4 py-3 text-sm focus:outline-none focus:border-forest-600">{{ ecms("{$section}.{$key}") }}</textarea>
  @else
    <input type="text" data-ecms-content data-section="{{ $section }}" data-key="{{ $key }}" value="{{ ecms("{$section}.{$key}") }}"
      class="w-full border border-sand-300 bg-sand-50 px-4 py-3 text-sm focus:outline-none focus:border-forest-600">
  @endif
</div>
