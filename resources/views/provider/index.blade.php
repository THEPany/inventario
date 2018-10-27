@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials._sidebar')
            </div>
            <div class="col-md-8">
                @card
                @slot('header', 'Todos los proveedores')

                @slot('body_style', 'p-0 pt-4')

                    @table
                        @slot('columns', ['Proveedores','Fechas', 'Acciones'])

                    @forelse($providers as $provider)
                        <tr>
                            <td>
                                <strong>{{ $provider->name }}</strong>
                                <br>
                                <small>{{ $provider->phone }}</small>
                            </td>
                            <td>
                                <strong>Creación: </strong> {{ $provider->created_at->format('d/m/Y') }}
                                <br>
                                <strong>Modificación: </strong> {{ $provider->updated_at->format('d/m/Y') }}
                            </td>
                            <td>
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
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            <em>No hay datos registrados para esta tabla</em>
                        </td>
                    </tr>
                    @endforelse
                    @endtable

                    {{ $providers->links() }}

                @endcard
            </div>
        </div>
    </div>
@endsection