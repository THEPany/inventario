@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-3">
              @include('partials._sidebar')
          </div>
          <div class="col-9">
              @card
              @slot('header', "Editar:  {$user->name}")

              <form class="form-horizontal" action="{{ route('users.update', $user) }}" method="PUT">
                  @method('PUT')
                  @include('user._fields')

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