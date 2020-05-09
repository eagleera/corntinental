@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
            <div class="column is-12 h-full ">
                    <div class="border-4 border-gray-600 h-full rounded-md p-8 relative">
                        <p class="text-xl font-bold">Hola {{ Auth::user()->name }}</p>
                        <p class="mt-2 ">Lista de usuarios</p>
                        @if (count($users) === 0)
                            <p>Aún no tienes usuarios usando la plataforma :(</p>
                        @else
                        <div class="table-container">
                            <table class="table is-fullwidth is-hoverable is-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr @foreach ($users as $user)>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <a href="{{route('edit_user', ['id' => $user->id])}}">
                                        <i class="fas fa-user-edit has-text-link"></i>
                                    </a>
                                </td>
                                <td>
                                    <form method="POST" action="/admin/user/{{$user->id}}">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash has-text-danger"></i>
                                            </button>
                                    </form>
                                </td>
                                </tr @endforeach>
                            </tbody>
                            </table>
                        </div>
                        @endif
                        @auth
                            <a
                                class="has-text-link absolute bottom-0 right-0 p-2"
                                href="{{ url("logout") }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            >
                                Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endauth
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection