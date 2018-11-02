@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials._sidebar')
            </div>
            <div class="col-9">
                @card
                @slot('header', 'Crear sucursal')

                <form method="POST" action="{{ route('branchOffice.update', $branchOffice) }}">
                    @method('PUT')

                    @include('branch_office._fields')

                    <div class="form-group row mb-0">
                        <div class="col-8 offset-4">
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                Crear
                            </button>
                        </div>
                    </div>
                </form>
                @endcard
            </div>
        </div>
    </div>
@endsection