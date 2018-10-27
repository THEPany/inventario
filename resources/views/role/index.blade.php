@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials._sidebar')
            </div>
            <div class="col-md-8">
                @card
                @slot('header', 'Listado de roles')

                @slot('body_style', 'p-0 pt-4')

                @table
                @slot('columns', ['#','Rol', 'Habilidades', 'Acciones'])

                @forelse($roles as $role)
                    <tr>
                        <th>{{ $role->id }}</th>
                        <td>{{ $role->title }}</td>
                        <td>
                            @foreach ($role->abilities()->pluck('title') as $ability)
                                <span class="label label-primary">{{ $ability }}</span>
                            @endforeach
                        </td>
                        <td>
                            @can('update', $role)
                                <a class="btn btn-info btn-xs" href="{{ route('roles.edit', $role) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @endcan

                            @can('delete', $role)
                                <a class="btn btn-danger btn-xs" href="{{ route('roles.destroy', $role) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('roles-delete-{{$role->id}}').submit();">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <form id="roles-delete-{{$role->id}}" action="{{ route('roles.destroy', $role) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>No hay datos registrados para esta tabla</em>
                        </td>
                    </tr>
                @endforelse

                @endtable

                {{ $roles->links() }}

                @endcard
            </div>
        </div>
    </div>
@endsection