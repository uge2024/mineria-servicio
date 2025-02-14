<!-- resources/views/orden_trabajo/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class=" flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-lg shadow-lg">
        <!-- Título -->
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900">
                Generar Orden de Trabajo
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                Seleccione un servicio para generar una nueva orden de trabajo.
            </p>
        </div>

        <!-- Formulario -->
        <form action="{{ route('orden_trabajo.store') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <!-- Campo: Seleccionar Boleta -->
            <div>
                <label for="boleta_id" class="block text-sm font-medium text-gray-700">
                    Seleccionar Servicio
                </label>
                <div class="mt-1 relative">
                    <select name="boleta_id" id="boleta_id"
                            class="block w-full pl-3 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md appearance-none bg-white"
                            required>
                        <option value="" disabled selected>Seleccione un Servicio</option>
                        @foreach ($boletas as $boleta)
                            <option value="{{ $boleta->id }}">
                                Boleta #{{ $boleta->numero_solicitud }} - {{ $boleta->nombre_solicitante }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Ícono de flecha para el select -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @error('boleta_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón de Envío -->
            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <!-- Ícono de envío -->
                        <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Generar Orden de Trabajo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection