@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials._sidebar')
            </div>
            <div class="col-9">
                @card
                @slot('header', 'Registrar compra')

                <form method="POST" action="{{ route('purchases.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-md-right">
                            Producto
                            <span class="text-danger">*</span>
                        </label>

                        @if($products->isNotEmpty())
                            <div class="col-md-6">
                                <select class="form-control" id="product_id" name="product_id">
                                    @foreach($products as $product)
                                        <option value="{{ old('product_id', $product->id) }}">{{ $product->name  .' Proveedor: '. $product->provider->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('product_id'))
                                    <strong class="text-danger">{{ $errors->first('product_id') }}</strong>
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
                        'required' => true,
                    ])

                    @input([
                        'label' => 'Precio',
                        'name' => 'price',
                        'type' => 'number',
                        'required' => true,
                    ])

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                Registar
                            </button>
                        </div>
                    </div>
                </form>
                @endcard
            </div>
        </div>
    </div>
@endsection