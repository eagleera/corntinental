<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />
        <title>Corntinental</title>
    </head>
    <body class="h-screen pattern-cross-dots-xl has-background-grey-darker has-text-danger p-16">
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
                <div class="border-4 border-gray-600 h-full rounded-md p-8">
                    <div>
                        <p class="font-bold text-4xl">Hola!</p>
                        <p class="text-3xl">Para empezar a llevar la cuenta de tus juegos y puntuaciones inicia sesión o crea una cuenta!</p>
                    </div>
                    <div class="columns mt-16 is-multiline">
                        <div class="column is-12">
                            <button class="button is-primary is-fullwidth h-full text-xl font-bold">
                                Iniciar sesión
                            </button>
                        </div>
                        <div class="column is-12">
                            <button class="button is-danger is-fullwidth h-full text-xl font-bold">
                                Crear una cuenta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
    <script type="text/javascript" src="{{ URL::to('js/app.js') }}"></script>
</html>
