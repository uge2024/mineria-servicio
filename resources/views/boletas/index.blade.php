@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-700">Listado de Solicitudes de Servicio</h1>

    <!-- Botón Agregar Boleta -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('boletas.create') }}" 
           class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Agregar Solicitud
        </a>
    </div>

    <!-- Verificar si hay boletas -->
    @if ($boletas->isEmpty())
        <div class="text-center text-gray-500 py-8">
            No hay boletas generadas.
        </div>
    @else
        @foreach ($boletas as $index => $boleta)
            <!-- Contenedor de Boleta Completa -->
            <div class="rounded-lg border-2 {{ $index % 2 === 0 ? 'border-blue-400' : 'border-green-400' }} p-4 mb-6 bg-white shadow-sm">
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
                        <p class="font-semibold text-gray-700">Número de Contacto:</p>
                        <p>{{ $boleta->numero_contrato }}</p>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('boletas.edit', $boleta->id) }}" 
                       class="inline-flex items-center bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('boletas.destroy', $boleta->id) }}" method="POST" 
                          class="inline-block" 
                          onsubmit="return confirm('¿Está seguro de eliminar esta boleta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4M9 7h6"></path>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                    <a href="{{ route('boletas.pdf', $boleta->id) }}" 
                       target="_blank" 
                       class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
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
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Código</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Características</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Municipio</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Lugar Específico</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Tipo de Material</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($boleta->muestras as $muestraIndex => $muestra)
                                        <tr class="{{ $muestraIndex % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $muestra->codigo }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $muestra->caracteristicas_muestra ?? 'N/A' }}</td>
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