<div class="card {{ $type ?? false ? 'card--' . $type : '' }} {{ $classes ?? '' }}">
  @if ($heading ?? false)
    <h3 class="card__heading">{{ $heading }}</h3>
  @endif
  {{ $slot }}
</div>
