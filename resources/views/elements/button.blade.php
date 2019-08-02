@if ($href ?? false)
  <a href="{{ $href }}"
     class="button button--{{ $type ?? 'primary' }} {{ $classes ?? '' }}"
     id="{{ $id ?? '' }}"
     target="{{ strpos($href, 'http') === 0 && strpos($href, config('app.url')) === false ? '_blank' : '_self' }}"
  >
    <span>{{ $label }}</span>
  </a>
@else
  <button class="button button--{{ $type ?? 'primary' }} {{ $classes ?? '' }}" id="{{ $id ?? '' }}">
    <span>{{ $label }}</span>
  </button>
@endif
