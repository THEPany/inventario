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
                    Listado de roles
                    <div class="p-2 float-right">
                        {{ $roles->links() }}
                    </div>
                @endslot
                @slot('header_style', 'text-muted')

                @slot('body_style', 'p-0 pt-0')

                @table
                    @if($roles->count()) @slot('columns', ['#','Rol', 'Habilidades', 'Acciones']) @endif

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
                                @can('update', $role)
                                    <a class="btn btn-primary" href="{{ route('roles.edit', $role) }}">
                                        Editar
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                @endcan

                                @can('delete', $role)
                                    <a class="btn btn-outline-danger" href="{{ route('roles.destroy', $role) }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('roles-delete-{{$role->id}}').submit();">
                                        Eliminar
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="roles-delete-{{$role->id}}" action="{{ route('roles.destroy', $role) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endcan
                            </div>



                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center bg-secondary border-0 pb-5 pt-5">
                            <em>No hay datos registrados para esta tabla</em>
                            <br>
                            @can('create', \Silber\Bouncer\Database\Role::class)
                                <a href="{{ url('/roles/create') }}" class="btn btn-primary mt-4">
                                    <i class="fas fa-plus"></i>
                                    Crear Rol
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforelse

                @endtable

                @endcard
            </div>
        </div>
    </div>
@endsection