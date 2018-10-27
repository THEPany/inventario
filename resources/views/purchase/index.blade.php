@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials._sidebar')
            </div>
            <div class="col-md-8">
                @card
                @slot('header', 'Todas las compras')

                    @table
                    @slot('columns', ['Descripcion', 'stock', 'Fechas'])

                    @forelse($purchases as $purchase)
                        <tr>
                            <td>
                                <strong>{{ $purchase->description }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $purchase->stock }}</span>
                            </td>
                            <td>
                                <strong>Creación: </strong> {{ $purchase->created_at->format('d/m/Y') }}
                            </td>
                           {{-- <td>
                                <div class="dropdown">
                                    <button class="btn btn-light" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <a href="{{ url("/providers/{$provider->id}/edit") }}" class="dropdown-item" >
                                            <i class="fas fa-pencil-alt"></i>
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>--}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <em>No hay datos registrados para esta tabla</em>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    @endtable

                    {{ $purchases->links() }}
                @endcard
            </div>
        </div>
    </div>
@endsection