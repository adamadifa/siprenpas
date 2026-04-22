@props([
    'name',
    'label',
    'data',
    'key',
    'textShow',
    'selected' => '',
    'kode' => false,
    'upperCase' => false,
    'select2' => '',
    'required' => false,
])



<div class="form-group mb-3">
    <label for="{{ $name }}" style="font-weight: 600" class="form-label">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select {{ $select2 }}">
        <option value="">{{ $label }}</option>
        @foreach ($data as $d)
            <option {{ $d->$key == $selected ? 'selected' : '' }} value="{{ $d->$key }}">
                {{ $kode ? $d->$key . ' - ' : '' }}
                {{ $upperCase ? strtoupper(strtolower($d->$textShow)) : ucwords(strtolower($d->$textShow)) }}
            </option>
        @endforeach
    </select>
</div>
