@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials._sidebar')
            </div>
            <div class="col-9">
                @card
                @slot('header')
                    Todas las transacciónes
                    <div class="float-right">
                        {{ $transactions->links() }}
                    </div>
                @endslot

                @slot('header_style', 'text-muted')

                @slot('body_style', 'p-0 pt-0')

                @table
                    @if ($transactions->count()) @slot('columns', ['#', 'Producto', 'Descripcion', 'Fechas']) @endif

                @forelse($transactions as $transaction)
                    <tr>
                        <td>
                            {{ $transaction->id }}
                        </td>
                        <td>
                            <strong>{{ $transaction->product->name }}</strong>
                            <br>
                            Cantidad: <span class="badge badge-primary">{{ $transaction->quantity }}</span>
                        </td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            <strong>Creación: </strong> {{ $transaction->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center bg-secondary border-0 pb-5 pt-5">
                            <em>No hay datos registrados para esta tabla</em>
                            <br>
                            @can('create', \App\Transaction::class)
                                <a href="{{ url('/transactions/create') }}" class="btn btn-primary mt-4">
                                    <i class="fas fa-plus"></i>
                                    Registrar transacción
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