@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials._sidebar')
            </div>
            <div class="col-9">
                @card
                @slot('header', 'Crear Roles')

                <form method="POST" action="{{ route('roles.store') }}">
                    @include('role._fields')

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
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