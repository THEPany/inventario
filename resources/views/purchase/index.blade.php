@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials._sidebar')
            </div>
            <div class="col-md-9">
                @card
                @slot('header')
                    Todas las compras
                    <div class="float-right">
                        {{ $purchases->links() }}
                    </div>
                @endslot

                @slot('header_style', 'text-muted')

                @slot('body_style', 'p-0 pt-0')

                    @table
                        @if ($purchases->count()) @slot('columns', ['Descripcion', 'stock', 'Fechas']) @endif

                    @forelse($purchases as $purchase)
                        <tr>
                            <td>
                                <strong>{{ $purchase->description }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-success text-white">{{ $purchase->stock }}</span>
                            </td>
                            <td>
                                <strong>Creación: </strong> {{ $purchase->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center bg-secondary border-0 pb-5 pt-5">
                                <em>No hay datos registrados para esta tabla</em>
                                <br>
                                @can('create', App\Purchase::class)
                                    <a href="{{ url('/purchases/create') }}" class="btn btn-primary mt-4">
                                        <i class="fas fa-plus"></i>
                                        Registrar compra
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