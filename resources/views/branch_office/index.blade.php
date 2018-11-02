@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials._sidebar')
            </div>
            <div class="col-9">
                @card
                @slot('header', 'Todas las sucursales')

                @slot('body_style', 'p-0 pt-4')

                @table
                @slot('columns', ['Sucursal','Fechas', 'Acciones'])

                @forelse($branchOffices as $branchOffice)
                    <tr>
                        <td>
                            <strong>{{ $branchOffice->name }}</strong>
                        </td>
                        <td>
                            <strong>Creación: </strong> {{ $branchOffice->created_at->format('d/m/Y') }}
                            <br>
                            <strong>Modificación: </strong> {{ $branchOffice->updated_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <a href="{{ route('branchOffice.edit', $branchOffice) }}" class="dropdown-item" >
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

                {{ $branchOffices->links() }}

                @endcard
            </div>
        </div>
    </div>
@endsection