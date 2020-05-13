@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
        @if (isset($errors) && count($errors))
            <div class="notification is-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('join_room') }}">
            @csrf
            {{ method_field('PUT') }}
            <div class="field">
                <label class="label">Salas disponibles</label>
                <div class="select is-fullwidth form-controlp">
                    <select name="room_id" required>
                        <option selected disabled>Selecciona una opción...</option>
                        @foreach ($rooms as $room)
                            <option value={{ $room }}>
                                {{ $room }}
                            </option>
                        @endforeach>
                    </select>
                </div>
            </div>
            <div class="field">
                <label class="label">Contraseña de la sala</label>
                <div class="control">
                    <input class="input" type="password" placeholder="5 digitos" name="password" value="{{ old('password') }}" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Tu nombre en la sala</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Daniel..." name="alias" value="{{ old('alias') }}" required>
                </div>
            </div>
            <button class="button is-primary is-fullwidth h-full text-2xl font-bold">
                Entrar a la sala
            </button>
        </form>
    </div>
</div>
@endsection
