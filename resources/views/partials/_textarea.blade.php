<div class="form-group row">
    <label class="{{ $label_class ?? 'col-sm-4 col-form-label text-md-right' }}">
        {{ __($label) }}

        @isset($required)
            <span class="text-danger">*</span>
        @endisset
    </label>

    <div class="col-md-6">
        <textarea
                type="{{ $type ?? 'text' }}"

                class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }} {{ $textarea_class ?? '' }}"

                @isset($name)
                name="{{ $name }}"
                @endisset

                placeholder="@isset($placeholder) {{ __($placeholder) }} @else {{ __($label) }} @endisset"

                @isset($required)
                required
                @endisset>{{ old($name, $value ?? '') }}</textarea>

        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
