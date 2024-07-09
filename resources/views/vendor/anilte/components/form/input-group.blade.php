<div class="form-group">
    <label for="{{ $id }}">
        {{ $label }} @if (isset($required) && $required)<span class="text-danger">*</span>@endif
    </label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text bg-gradient-blue">
                <i class="{{ $icon }}"></i>
            </div>
        </div>
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            class="form-control"
            placeholder="{{ $placeholder }}"
            @if (isset($required) && $required)
                required="required"
            @endif
        />

        @error($name)
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror

    </div>
</div>
