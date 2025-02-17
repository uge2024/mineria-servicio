@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-700">Listado de Solicitudes de Servicio</h1>

    <!-- Botón Agregar Boleta -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('boletas.create') }}" 
           class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
            + Agregar Solicitud
        </a>
    </div>

    <!-- Verificar si hay boletas -->
    @if ($boletas->isEmpty())
        <div class="text-center text-gray-500">
            No hay boletas generadas.
        </div>
    @else
        @foreach ($boletas as $index => $boleta)
            <!-- Contenedor de Boleta Completa -->
            <div class="rounded-lg border-2 {{ $index % 2 === 0 ? 'border-blue-400' : 'border-green-400' }} p-4 mb-6">
                <!-- Número de Solicitud -->
                <div class="mb-4">
                    <p class="font-semibold text-gray-700">Número de Solicitud:</p>
                    <p class="text-xl font-bold text-gray-800">{{ $boleta->numero_solicitud }}</p>
                </div>

                <!-- Datos Generales de la Boleta -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <p class="font-semibold text-gray-700">Servicio:</p>
                        <p>{{ $boleta->servicio->nombre }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Solicitante:</p>
                        <p>{{ $boleta->nombre_solicitante }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">CI:</p>
                        <p>{{ $boleta->ci }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Sector:</p>
                        <p>{{ $boleta->sector }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Fecha de Solicitud:</p>
                        <p>{{ $boleta->fecha_solicitud }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Número de Contrato:</p>
                        <p>{{ $boleta->numero_contrato }}</p>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="flex space-x-2 mb-4">
                    <a href="{{ route('boletas.edit', $boleta->id) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        Editar
                    </a>
                    <form action="{{ route('boletas.destroy', $boleta->id) }}" method="POST" 
                          class="inline-block" 
                          onsubmit="return confirm('¿Está seguro de eliminar esta boleta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                            Eliminar
                        </button>
                    </form>
                    <a href="{{ route('boletas.pdf', $boleta->id) }}" 
                        target="_blank" 
                        class="text-green-600 hover:text-green-800 font-medium">
                        Imprimir
                     </a>
                </div>

                <!-- Detalles de Muestras -->
                @if ($boleta->muestras->isNotEmpty())
                    <div class="rounded-lg border border-gray-200 p-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Detalles de Muestras</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Características</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Peso (kg)</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Municipio</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Lugar Específico</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Tipo de Material</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($boleta->muestras as $muestraIndex => $muestra)
                                        <tr class="{{ $muestraIndex % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $muestra->caracteristicas_muestra ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $muestra->peso }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $muestra->municipio }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $muestra->lugar_especifico }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $muestra->tipo_material }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @endif

    <!-- Enlaces de Paginación -->
    <div class="mt-6">
        {{ $boletas->links('pagination::tailwind') }}
    </div>
</div>
@endsection