@csrf

@input([
    'label' => 'Nombre del producto',
    'name' => 'name',
    'value' => $product->name,
    'required' => true,
    'autofocus' => true
])

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

@input([
    'label' => 'Cantidad',
    'name' => 'stock',
    'type' => 'number',
    'value' => $product->stock,
    'required' => true,
])

@input([
    'label' => 'Cantidad Minima',
    'name' => 'min_stock',
    'type' => 'number',
    'value' => $product->min_stock,
    'required' => true,
])

@input([
    'label' => 'Precio',
    'name' => 'price',
    'type' => 'number',
    'value' => $product->price,
    'required' => true,
])

@textarea([
    'label' => 'Descripcion',
    'name' => 'description',
    'required' => true,
    'value' => $product->description,
])