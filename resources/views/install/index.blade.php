@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center pt-5">
            <div class="col-md-8 pt-5 text-center">
               <div class="card shadow-sm">
                   <div class="card-body">
                       <a href="{{ url('/install/system') }}" class="btn btn-primary">
                           <h1 class="font-weight-bold p-0 m-0">Instalar sistema</h1>
                       </a>
                   </div>
               </div>
            </div>
        </div>
    </div>
@endsection