<div class="input input--textarea">
  @if ($label ?? false)
    <label for="{{ $id ?? '' }}" class="input__label">
      {{ $label }}
      @if ($required ?? false)
      @else
        (optional)
      @endif
    </label>
  @endif
  <textarea id="{{ $id ?? '' }}"
            name="{{ $name ?? '' }}"
            {{ $required ?? false ? 'required' : '' }}
            placeholder="{{ $placeholder ?? '' }}"
  >{{ $value ?? '' }}</textarea>
  @if ($name ?? false && $errors->has($name))
    <span><strong>{{ $errors->first($name) }}</strong></span>
  @endif
</div>
