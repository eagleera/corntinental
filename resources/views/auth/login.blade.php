@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label class="label">Correo</label>
                <div class="control">
                    <input class="input @error('email') is-invalid @enderror" type="email" placeholder="danielaguilera@gg.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label">Contraseña</label>
                <div class="control">
                    <input class="input @error('password') is-invalid @enderror" type="password" name="password" value="{{ old('email') }}" required autocomplete="current-password">
                </div>
                @error('password')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <div class="control">
                    <label class="checkbox">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Recuerdame
                    </label>
                </div>
            </div>
            <button class="button is-primary is-fullwidth h-full text-2xl font-bold">
                Iniciar sesión
            </button>
            @if (Route::has('password.request'))
                <p class="mt-3 text-center">
                    <a class="has-text-link" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                <p>
            @endif
        </form>
    </div>
</div>
@endsection
