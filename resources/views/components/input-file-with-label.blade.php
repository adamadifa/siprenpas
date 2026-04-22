@props(['name' => '', 'label' => '', 'value' => '', 'required' => false])
<div class="form-group mb-3">
    <label for="{{ $name }}" style="font-weight: 600" class="form-label">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input class="form-control" type="file" id="{{ $name }}" name="{{ $name }}">
</div>
