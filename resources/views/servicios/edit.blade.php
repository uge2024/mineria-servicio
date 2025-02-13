@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Editar Servicio</h1>

    <!-- Botón de regreso -->
    <a href="{{ route('servicios.index') }}" 
       class="inline-block mb-4 text-blue-500 hover:underline">
        ← Volver a la lista de servicios
    </a>

    <!-- Formulario de edición -->
    <form action="{{ route('servicios.update', $servicio->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Campo Nombre -->
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-600">Nombre:</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                value="{{ old('nombre', $servicio->nombre) }}"
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
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
                value="{{ old('precio', $servicio->precio) }}"
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
            @error('precio')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón de actualización -->
        <button type="submit" 
            class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition">
            Actualizar Servicio
        </button>
    </form>
</div>
@endsection
