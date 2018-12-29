@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials._tenant_sidebar')
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4">
                        @card
                        @slot('card_style', 'mb-3')
                        @slot('header', 'Todos los proveedores')
                        @slot('body_style', 'bg-white')
                        <h1>{{ $providers_count }}</h1>
                        @can('tenant-create', App\Provider::class)
                            @slot('footer')
                                <div class="text-center">
                                    <a class="btn btn-link font-weight-bold text-black-50" href="{{ url("/{$branchOffice->slug}/providers/create") }}">Ver Mas <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endslot
                        @endcan
                        @slot('footer_style', 'p-0 m-0')
                        @endcard
                    </div>
                    <div class="col-md-4">
                        @card
                        @slot('card_style', 'mb-3')
                        @slot('header', 'Todos los productos')
                        @slot('body_style', 'bg-white')
                        <h1>{{ $products_count }}</h1>
                        @can('tenant-create', App\Product::class)
                            @slot('footer')
                                <div class="text-center">
                                    <a class="btn btn-link font-weight-bold text-black-50" href="{{  url("/{$branchOffice->slug}/products/create")  }}">Ver Mas <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endslot
                        @endcan
                        @slot('footer_style', 'p-0 m-0')
                        @endcard
                    </div>
                    <div class="col-md-4">
                        @card
                        @slot('card_style', 'mb-3')
                        @slot('header', 'Nuevas compras')
                        @slot('body_style', 'bg-white')
                        <h1>{{ $purchases_count }}</h1>
                        @can('tenant-create', App\Purchase::class)
                            @slot('footer')
                                <div class="text-center">
                                    <a class="btn btn-link font-weight-bold text-black-50" href="{{ url("/{$branchOffice->slug}/purchases") }}">Ver Mas <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endslot
                        @endcan
                        @slot('footer_style', 'p-0 m-0')
                        @endcard
                    </div>
                    <div class="col-md-4">
                        @card
                        @slot('header', 'Nuevas transacciónes')
                        @slot('body_style', 'bg-white')
                        <h1>{{ $transactions_count }}</h1>
                        @can('tenant-create', App\Transaction::class)
                            @slot('footer')
                                <div class="text-center">
                                    <a class="btn btn-link font-weight-bold text-black-50" href="{{ url("/{$branchOffice->slug}/transactions") }}">Ver Mas <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endslot
                        @endcan
                        @slot('footer_style', 'p-0 m-0')
                        @endcard
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection