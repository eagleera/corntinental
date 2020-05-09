@extends('layouts.app')

@section('content')
<div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
        <p class="text-3xl font-bold">Editar información de usuario</p>
        <form method="POST" action="{{ route('post_edit_user') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                    <input class="input @error('name') is-invalid @enderror" type="text" placeholder="Daniel" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label">Correo</label>
                <div class="control">
                    <input class="input @error('email') is-invalid @enderror" type="email" placeholder="danielaguilera@gg.com" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <button class="button is-primary is-fullwidth h-full text-2xl font-bold">
                Editar información
            </button>
        </form>
    </div>
</div>
@endsection
