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

                    @slot('body_style', 'p-0 pt-4')

                    @table
                        @slot('columns', ['Producto','Cantidad', 'Fechas', 'Acciones'])

                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    <br>
                                    RD$ {{ $product->price }}
                                </td>
                                <td>
                                    @if($product->stock > $product->min_stock)
                                        <span class="badge badge-success">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>Creación: </strong> {{ $product->created_at->format('d/m/Y') }}
                                    <br>
                                    <strong>Modificación: </strong> {{ $product->updated_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <a href="{{ url("/products/{$product->id}/edit") }}" class="dropdown-item" >
                                                <i class="fas fa-pencil-alt"></i>
                                                Editar
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <em>No hay datos registrados para esta tabla</em>
                                </td>
                            </tr>
                        @endforelse

                    @endtable

                @endcard
            </div>
        </div>
    </div>
@endsection