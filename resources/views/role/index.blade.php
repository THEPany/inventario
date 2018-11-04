@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials._sidebar')
            </div>
            <div class="col-9">
                @card
                @slot('header')
                    Listado de roles'
                    <div class="p-2 float-right">
                        {{ $roles->links() }}
                    </div>
                @endslot

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
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    @can('update', $role)
                                        <a class="dropdown-item" href="{{ route('roles.edit', $role) }}">
                                            <i class="fa fa-pencil-alt"></i>
                                            Editar
                                        </a>
                                    @endcan

                                    @can('delete', $role)
                                        <a class="dropdown-item" href="{{ route('roles.destroy', $role) }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('roles-delete-{{$role->id}}').submit();">
                                            <i class="fa fa-trash"></i>
                                            Eliminar
                                        </a>
                                        <form id="roles-delete-{{$role->id}}" action="{{ route('roles.destroy', $role) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endcan
                                </div>
                            </div>



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

                @endcard
            </div>
        </div>
    </div>
@endsection