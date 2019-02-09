<div class="input-field{{ isset($class) ? (' ' . $class) : '' }}">
  <input
    id="{{ $name }}"
    name="{{ $name }}"
    @if (!empty($type) && strtolower($type) === 'date')
      type="text"
    @else
      type="{{ empty($type) ? 'text' : $type }}"
    @endif
    @if (isset($readonly) && $readonly) readonly disabled @endif
    autocomplete="off"
    class="{{ $errors -> has($name) ? 'invalid' : '' }}{{ !empty($type) && strtolower($type) === 'date' ? ' datepicker' : '' }}"
    value="{{
      !empty($old)
        ? $old
        : (
          isset($dontFlash) && $dontFlash
            ? ""
            : old($name)
        )
    }}"
    @if (isset($attributes))
      @foreach ($attributes as $attribute => $attribute_value)
        {{ $attribute }}="{{ $attribute_value }}"
      @endforeach
    @endif
  >
  <label for="{{ $name }}">{{ empty($label) ? ucfirst($name) : $label }}</label>
  @if ($errors -> has($name))
    <span class="helper-text is-danger">{{ $errors -> first($name) }}</span>
  @endif
</div>