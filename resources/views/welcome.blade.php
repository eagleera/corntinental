@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
        <div class="columns h-full">
            <div class="column is-6 h-full">
                <div class="columns is-multiline h-full is-mobile">
                    <div class="column is-12 text-center py-16 px-32">
                        <button class="button is-danger is-fullwidth h-full text-3xl font-bold">
                            Crear un nuevo juego
                        </button>
                    </div>
                    <div class="column is-12 text-center py-16 px-32">
                        <button class="button is-primary is-fullwidth h-full text-3xl font-bold">
                            Unirse a una partida
                        </button>
                    </div>
                </div>
            </div>
            <div class="column is-6 h-full p-16">
                @guest
                    <div class="border-4 border-gray-600 h-full rounded-md p-8">
                        <div>
                            <p class="font-bold text-4xl">Hola!</p>
                            <p class="text-3xl">Para empezar a llevar la cuenta de tus juegos y puntuaciones inicia sesión o crea una cuenta!</p>
                        </div>
                        <div class="columns mt-16 is-multiline">
                            <div class="column is-12">
                                <a class="button is-primary is-fullwidth h-full text-xl font-bold" href="{{route('login')}}">
                                    Iniciar sesión
                                </a>
                            </div>
                            <div class="column is-12">
                                <a class="button is-danger is-fullwidth h-full text-xl font-bold" href="{{route('register')}}">
                                    Crear una cuenta
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border-4 border-gray-600 h-full rounded-md p-8 relative">
                        <p class="text-2xl font-bold">Tu historial de partidas</p>
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
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection