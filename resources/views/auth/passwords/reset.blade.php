@extends('layouts.app')

@section('content')
<div class="container">
<div class="h-full card rounded-md p-6 has-background-light">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="field">
                <label class="label">Correo</label>
                <div class="control">
                    <input class="input @error('email') is-invalid @enderror" type="email" placeholder="danielaguilera@gg.com" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label">Contraseña</label>
                <div class="control">
                    <input class="input @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
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
                Restablecer contraseña
            </button>
        </form>
    </div>
</div>
@endsection
