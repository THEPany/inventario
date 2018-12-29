@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">@include('partials._sidebar')</div>
            <div class="col-md-9">
                @card
                    @slot('header')
                        Todas las sucursales
                        <div class="float-right">{{ $branchOffices->links() }}</div>
                    @endslot
                    @slot('header_style', 'text-muted')

                    @slot('body_style', 'p-0 pt-0')

                    @table
                        {{--@slot('columns', ['Sucursal','Fechas', 'Acciones'])--}}

                        @forelse($branchOffices as $branchOffice)
                            <tr>
                                <td>
                                    <a href="{{ url("{$branchOffice->slug}/dashboard") }}">
                                        <strong>{{ $branchOffice->name }}</strong></td>
                                    </a>
                                <td>
                                    <strong>Creación: </strong> {{ $branchOffice->created_at->format('d/m/Y') }}
                                    <br>
                                    <strong>Modificación: </strong> {{ $branchOffice->updated_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    @can('update', $branchOffice)
                                        <a href="{{ route('branchOffice.edit', $branchOffice) }}" class="btn btn-primary" >
                                            Editar
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center bg-secondary border-0 pb-5 pt-5">
                                    <em>No hay datos registrados para esta tabla</em>
                                    <br>
                                    @can('create', App\BranchOffice::class)
                                        <a href="{{ url('/branch/office/create') }}" class="btn btn-primary mt-4">
                                            <i class="fas fa-plus"></i>
                                            Crear sucursal
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