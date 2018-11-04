@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials._sidebar')
            </div>
            <div class="col-md-9">
                @card
                    @slot('header', 'Registrar transacciónes')

                    <transaction-main :products="{{ $products }}"
                                      :branch-offices="{{ $branchOffices }}">
                    </transaction-main>
                @endcard
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endpush