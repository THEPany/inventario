@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">@include('partials._sidebar')</div>
            <div class="col-md-9">
                @card
                    @slot('header')
                        Todas las habilidades
                        <div class="float-right">{{ $abilities->links() }}</div>
                    @endslot
                    @slot('header_style', 'text-muted')

                    @slot('body_style', 'p-0 pt-0')

                <table class="table m-0">
                    <tbody>
                    @forelse($abilities  as $abilitie)
                        <tr>
                            <th>{{ $abilitie->id }}</th>
                            <td>{{ $abilitie->title }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                <em>No hay datos registrados para esta tabla</em>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @endcard
            </div>
        </div>
    </div>
@endsection