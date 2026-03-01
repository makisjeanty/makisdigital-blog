@props(['name', 'label' => null, 'value' => null, 'required' => false, 'rows' => 4, 'placeholder' => null])

<div class="form-group">
    @if($label)
    <label for="{{ $name }}" class="form-label">
        {{ $label }} {!! $required ? '<span style="color: #f87171;">*</span>' : '' !!}
    </label>
    @endif

    <textarea name="{{ $name }}"
              id="{{ $name }}"
              rows="{{ $rows }}"
              {{ $required ? 'required' : '' }}
              placeholder="{{ $placeholder }}"
              {{ $attributes->merge(['class' => 'form-textarea']) }}>{{ old($name, $value) }}</textarea>

    @error($name)
    <p class="form-error">{{ $message }}</p>
    @enderror
</div>
