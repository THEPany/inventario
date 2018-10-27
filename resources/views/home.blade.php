@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="font-weight-bold">Sucursal principal</h3>
            <div class="list-group text-center">
                <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action">Sucursal {{ config('app.name') }}</a>
            </div>

            @if($branchOffices->isNotEmpty())
                <h3 class="font-weight-bold pt-5">Sucursal secundarias</h3>
                <div class="list-group text-center">
                    @foreach($branchOffices as $branchOffice)
                        <a href="{{ url("/{$branchOffice->slug}/dashboard") }}" class="list-group-item list-group-item-action">Sucursal {{ $branchOffice->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
