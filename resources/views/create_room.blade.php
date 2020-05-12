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
        <form method="POST" action="{{ route('nuevo_juego') }}">
            @csrf
            <div class="field">
                <label class="label">Tu nombre en la sala</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Daniel..." name="alias" value="{{ old('alias') }}" required>
                </div>
            </div>
            <button class="button is-primary is-fullwidth h-full text-2xl font-bold" type="submit">
                Entrar a la sala
            </button>
        </form>
    </div>
</div>
@endsection
