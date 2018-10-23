@csrf

<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Nombre del proveedor
        <span class="text-danger">*</span>
    </label>

    <div class="col-md-6">
        <input id="name"
               type="text"
               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
               name="name"
               value="{{ old('name', $provider->name) }}"
               required
               autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Teléfono
        <span class="text-danger">*</span>
    </label>

    <div class="col-md-6">
        <input id="phone"
               type="text"
               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
               name="phone"
               value="{{ old('phone', $provider->phone) }}"
               required>

        @if ($errors->has('phone'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Dirección
        <span class="text-danger">*</span>
    </label>

    <div class="col-md-6">
        <textarea id="address"
               type="text"
               class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
               name="address"
               required>{{ old('address', $provider->address) }}</textarea>

        @if ($errors->has('address'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>
</div>