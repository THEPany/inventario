@csrf

<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Nombre del producto
        <span class="text-danger">*</span>
    </label>

    <div class="col-md-6">
        <input id="name"
               type="text"
               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
               name="name"
               value="{{ old('name', $product->name) }}"
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
        Proveedor
        <span class="text-danger">*</span>
    </label>

    @if($providers->isNotEmpty())
        <div class="col-md-6">
            <select class="form-control" id="provider_id" name="provider_id">
                @foreach($providers as $provider)
                    <option value="{{ old('provider_id', $provider->id) }}" {{ $provider->id === $product->provider_id ? 'selected' : ''  }}>{{ $provider->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('provider_id'))
                <strong class="text-danger">{{ $errors->first('provider_id') }}</strong>
            @endif
        </div>
    @else
       <div class="col-md-6">
           <div class="alert alert-warning alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <em>No hay proveedores registrados</em>
           </div>
       </div>
    @endif
</div>

<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Cantidad
        <span class="text-danger">*</span>
    </label>

    <div class="col-md-6">
        <input id="stock"
               type="number"
               class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}"
               name="stock"
               value="{{ old('stock', $product->stock) }}"
               required>

        @if ($errors->has('stock'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('stock') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Cantidad Minima
    </label>

    <div class="col-md-6">
        <input id="min_stock"
               type="number"
               class="form-control{{ $errors->has('min_stock') ? ' is-invalid' : '' }}"
               name="min_stock"
               value="{{ old('min_stock', $product->min_stock) }}">

        @if ($errors->has('min_stock'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('min_stock') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Precio
        <span class="text-danger">*</span>
    </label>

    <div class="col-md-6">
        <input id="price"
               type="number"
               class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
               name="price"
               step=.01
               value="{{ old('price', $product->price) }}">

        @if ($errors->has('price'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
        Descripcion
        <span class="text-danger">*</span>
    </label>

    <div class="col-md-6">
        <textarea id="description"
                  type="text"
                  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                  name="description"
                  required>{{ old('description', $product->description) }}</textarea>

        @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>
</div>
