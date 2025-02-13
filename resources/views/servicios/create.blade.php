@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-gray-700">Registrar Servicio</h1>

        <form action="{{ route('servicios.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Campo Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-600">Nombre:</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required 
                    value="{{ old('nombre') }}">
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Precio -->
            <div>
                <label for="precio" class="block text-sm font-medium text-gray-600">Precio:</label>
                <input 
                    type="number" 
                    id="precio" 
                    name="precio" 
                    step="0.01" 
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required 
                    value="{{ old('precio') }}">
                @error('precio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón de envío -->
            <button type="submit" 
                class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition">
                Guardar
            </button>
        </form>
    </div>
@endsection
