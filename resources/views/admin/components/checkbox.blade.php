<label>
  <input
    type="checkbox"
    class="filled-in{{ isset($class) ? ' ' . $class : '' }}"
    name="{{ $name }}"
    value="{{ $value }}"
    @if (isset($checked) && $checked)checked="checked"@endif
  />
  <span>{{ $label }}</span>
</label>