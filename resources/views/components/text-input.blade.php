<div class="input input--{{ $type ?? 'text' }}">
  @if ($label ?? false)
    <label for="{{ $id ?? '' }}" class="input__label">
      {{ $label }}
      @if ($required ?? false)
      @else
        (optional)
      @endif
    </label>
  @endif
  <input type="{{ $type ?? 'text' }}"
         id="{{ $id ?? '' }}"
         name="{{ $name ?? '' }}"
         value="{{ $value ?? '' }}"
         {{ $required ?? false ? 'required' : '' }}
         placeholder="{{ $placeholder ?? '' }}"
  >
  @if ($name ?? false && $errors->has($name))
    <span><strong>{{ $errors->first($name) }}</strong></span>
  @endif
</div>
