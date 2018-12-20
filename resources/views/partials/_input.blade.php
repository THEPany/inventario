<div class="form-group row">
    <label class="{{ $label_class ?? 'col-sm-4 col-form-label text-md-right' }}">
        {{ __($label) }}

        @isset($required)
            <span class="text-danger">*</span>
        @endisset
    </label>

    <div class="col-md-6">
        <input
                @isset($name)
                name="{{ $name }}"
                @endisset

                @isset($onkeyup)
                onkeyup="{{$onkeyup}}"
                @endisset

                @isset($step)
                step="{{$step}}"
                @endisset

                @isset($value)
                value="{{ old($name, $value) }}"
                @else
                value="{{ old($name) }}"
                @endisset

                @isset($readonly)
                readonly="{{$readonly}}"
                @endisset

                @isset($readonly)
                readonly="true"
                @endisset

                type="{{ $type ?? 'text' }}"

                placeholder="@isset($placeholder) {{ __($placeholder) }} @else {{ __($label) }} @endisset"

                class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }} {{ $input_classes ?? '' }}"

                @isset($required) required @endisset

                @isset($autofocus) autofocus @endisset

                @isset($phonemask) data-inputmask='"mask": "(999) 999-9999"' data-mask @endisset

                autocomplete="nope">

        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>