@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
            <div class="row">
            <div class="col-12 h-full ">
                    <div class="border-4 border-gray-600 h-full rounded-md p-8 relative">
                        <div class="columns">
                        <p class="text-2xl font-bold column">Sala de juego #{{$room->id}}</p>
                        <div class="column is-3">
                            <p>Contraseña de la sala:</p>
                            <div class="flex justify-around">
                                @foreach (str_split((string)$room->password) as $char)
                                    <p class="rounded-md has-background-white p-4 py-2 font-bold shadow-sm"> {{$char}}</p>
                                @endforeach
                            </div>
                        </div>
                        </div>
                        <p class="mt-2">Jugadores</p>
                        <div class="table-container">
                            <table class="table is-fullwidth is-hoverable is-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach ($room->guests as $guest)
                                    <th>{{ $guest->alias }}</th>    
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            </table>
                        </div>
                        @if($me->id == $room->owner_id)
                            <button class="button is-primary w-full">Comenzar juego</button>
                            <button class="button is-danger mt-4">Cerrar sala</button>
                        @endif
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection