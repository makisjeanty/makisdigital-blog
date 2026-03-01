@props(['name', 'label' => null, 'type' => 'text', 'value' => null, 'required' => false, 'placeholder' => null])

<div class="form-group">
    @if($label)
    <label for="{{ $name }}" class="form-label">
        {{ $label }} {!! $required ? '<span style="color: #f87171;">*</span>' : '' !!}
    </label>
    @endif

    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ old($name, $value) }}"
           {{ $required ? 'required' : '' }}
           placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => 'form-input']) }}>

    @error($name)
    <p class="form-error">{{ $message }}</p>
    @enderror
</div>
