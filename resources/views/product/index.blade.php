@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">@include('partials._sidebar')</div>
            <div class="col-md-9">
                @card
                    @slot('header')
                        Todos los productos
                        <div class="float-right">
                            {{ $products->links() }}
                        </div>
                    @endslot

                    @slot('header_style', 'text-muted')

                    @slot('body_style', 'p-0 pt-0')

                    @table
                        @if($products->count())
                            @slot('columns', ['Producto', 'Cantidad', 'Descripcion', 'Fechas', 'Acciones'])
                        @endif
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    <br>
                                    RD$ {{ number_format($product->price) }}
                                </td>
                                <td>
                                    @if($product->stock > $product->min_stock)
                                        <span class="badge badge-success text-white">{{ $product->stock }}</span>
                                    @elseif($product->stock <= $product->min_stock && $product->stock >= 1)
                                        <span class="badge badge-warning">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td title="{{ $product->description }}">
                                    {{ str_limit($product->description, 50 , '...') }}
                                </td>
                                <td>
                                    <strong>Creación: </strong> {{ $product->created_at->format('d/m/Y') }}
                                    <br>
                                    <strong>Modificación: </strong> {{ $product->updated_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    @can('update', $product)
                                        <a href="{{ url("/products/{$product->id}/edit") }}" class="btn btn-primary" >
                                            Editar
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center bg-secondary border-0 pb-5 pt-5">
                                <em>No hay datos registrados para esta tabla</em>
                                <br>
                                @can('create', App\Product::class)
                                    <a href="{{ url('/products/create') }}" class="btn btn-primary mt-4">
                                        <i class="fas fa-plus"></i>
                                        Crear producto
                                    </a>
                                @endcan
                            </td>
                        </tr>
                        @endforelse

                    @endtable

                @endcard
            </div>
        </div>
    </div>
@endsection