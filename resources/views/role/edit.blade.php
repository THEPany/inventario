@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials._sidebar')
            </div>
            <div class="col-md-8">
                @card
                @slot('header', "Editar: {$role->name}")

                <form method="POST" action="{{ route('roles.update', $role) }}">
                    @method('PUT')

                    @include('role._fields')

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </form>
                @endcard
            </div>
        </div>
    </div>
@endsection