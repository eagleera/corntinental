@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
        @if (session('status'))
            <div class="notification is-success">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
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
            <button class="button is-primary is-fullwidth h-full text-xl font-bold" type="submit">
                Enviar al correo instrucciones de recuperación de contraseña
            </button>
        </form>
    </div>
</div>
@endsection
