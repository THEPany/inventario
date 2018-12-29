@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials._tenant_sidebar')
            </div>
            <div class="col-9">
                @card
                    @slot('header')
                        Todos los proveedores
                        <div class="float-right">
                            {{ $providers->links() }}
                        </div>
                    @endslot

                    @slot('header_style', 'text-muted')

                    @slot('body_style', 'p-0 pt-0')

                    @table
                        @if ($providers->count()) @slot('columns', ['Proveedores','Fechas', 'Acciones']) @endif

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
                                    @can('tenant-edit', $provider)
                                        <a href="{{ url("/{$branchOffice->slug}/providers/{$provider->id}/edit") }}" class="btn btn-primary" >
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
                                @can('tenat-create', App\Provider::class)
                                    <a href="{{ url("/{$branchOffice->slug}/providers/create") }}" class="btn btn-primary mt-4">
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