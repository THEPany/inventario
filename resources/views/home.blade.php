@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="font-weight-bold text-muted text-center">Scursales</h3>
            <div class="row">
                <a class="col-md-3"  href="{{ url('/dashboard') }}" style="color: #1b1e21; font-weight: bold">
                    @card
                    @slot('body_style', 'bg-white text-center ')
                    <i class="far fa-building  fa-3x"></i>
                    <br>
                    Sucursal {{ config('app.name') }}
                    @endcard
                </a>
                @foreach($branchOffices as $branchOffice)
                    <a class="col-md-3"  href="{{ url("/{$branchOffice->slug}/dashboard") }}" style="color: #1b1e21; font-weight: bold">
                        @card
                            @slot('body_style', 'bg-white text-center ')
                            <i class="far fa-building  fa-3x"></i>
                            <br>
                            Sucursal {{ $branchOffice->name }}
                        @endcard
                    </a>
                @endforeach

                {{ $branchOffices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
