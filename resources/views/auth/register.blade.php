@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                    <input class="input @error('name') is-danger @enderror" type="text" placeholder="Daniel..." name="name" value="{{ old('name') }}" required autocomplete="email" autofocus>
                </div>
                @error('name')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label">Correo</label>
                <div class="control">
                    <input class="input @error('email') is-danger @enderror" type="email" placeholder="danielaguilera@gg.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label">Contraseña</label>
                <div class="control">
                    <input class="input @error('password') is-danger @enderror" type="password" name="password" required autocomplete="current-password">
                </div>
                @error('password')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label">Confirmar contraseña</label>
                <div class="control">
                    <input class="input @error('password') is-danger @enderror" type="password" name="password_confirmation" required autocomplete="current-password">
                </div>
            </div>
            <button class="button is-primary is-fullwidth h-full text-2xl font-bold" type="submit">
                Registrarme
            </button>
            <p class="mt-3 text-center">
                <a class="has-text-link" href="{{ route('login') }}">
                    ¿Ya tienes una cuenta? Inicia sesión
                </a>
            <p>
        </form>
    </div>
</div>
@endsection
