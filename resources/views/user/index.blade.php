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
                    Todos los usuarios
                    <div class="float-right">
                        {{ $users->links() }}
                    </div>
                @endslot
                @slot('header_style', 'text-muted')

                @slot('body_style', 'p-0 pt-0')

                @table
               {{-- @slot('columns', ['#','Nombre', 'Correo Electrónico', 'Acciones'])--}}

                @forelse($users  as $user)
                    <tr>
                        <th>{{ $user->id }}</th>
                        <td>
                            {{ $user->name }}
                            <br>
                            @foreach ($user->roles->pluck('title') as $role)
                                <span class="badge badge-primary">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @can('update', $user)
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary" >
                                    <i class="fas fa-pencil-alt"></i>
                                    Editar
                                </a>
                            @endcan

                            @can('delete', $user)
                                <a class="btn btn-outline-danger" href="{{ route('users.destroy', $user) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('users-delete-{{$user->id}}').submit();">
                                    <i class="fa fa-trash"></i>
                                    Eliminar
                                </a>
                                <form id="users-delete-{{$user->id}}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <th colspan="4"> No hay usuarios registrados</th>
                @endforelse

                @endtable

                @endcard
            </div>
        </div>
    </div>
@endsection