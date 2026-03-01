@props(['name', 'label' => null, 'required' => false, 'options' => []])

<div class="form-group">
    @if($label)
    <label for="{{ $name }}" class="form-label">
        {{ $label }} {!! $required ? '<span style="color: #f87171;">*</span>' : '' !!}
    </label>
    @endif

    <select name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-input']) }}>
        {{ $slot }}
    </select>

    @error($name)
    <p class="form-error">{{ $message }}</p>
    @enderror
</div>
