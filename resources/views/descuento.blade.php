<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>14 Febrero</title>
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="flex items-center justify-center h-screen">
            <div class="rounded overflow-hidden shadow-lg p-4">
                @isset($costo)
                <p class="text-2xl my-4">Costo: ${{ $costo }}</p>
                <p class="text-2xl my-4">Descuento: ${{ $descuento }}</p>
                <p class="text-2xl my-4">Total: ${{ $total }}</p>
                @endisset
                <form class="w-full" method="POST" action="descuento">
                    @csrf
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Costo del articulo
                        </label>
                        </div>
                        <div class="md:w-2/3">
                        <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-green-500" type="text" name="costo">
                        </div>
                    </div>
                    <div class="md:flex md:items-center">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/3">
                        <button class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Calcular
                        </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
