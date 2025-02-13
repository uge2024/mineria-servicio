@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Lista de Servicios</h1>

    <!-- Botón Agregar Servicio -->
    <div class="mb-4">
        <a href="{{ route('servicios.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            + Agregar Servicio
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla de Servicios -->
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr class="text-left border-b">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servicios as $servicio)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ $servicio->id }}</td>
                    <td class="px-4 py-2">{{ $servicio->nombre }}</td>
                    <td class="px-4 py-2">Bs.{{ number_format($servicio->precio, 2) }}</td>
                    <td class="px-4 py-2 text-center">
                        <!-- Botón Editar -->
                        <a href="{{ route('servicios.edit', $servicio->id) }}" 
                           class="text-blue-500 hover:underline">
                            ✏️ Editar
                        </a>

                        <!-- Botón Eliminar -->
                        <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-500 hover:underline ml-2"
                                    onclick="return confirm('¿Estás seguro de eliminar este servicio?')">
                                ❌ Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">No hay servicios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
