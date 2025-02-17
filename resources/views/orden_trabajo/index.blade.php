@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <!-- Título y Botón Agregar -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Órdenes de Trabajo</h1>
            <a href="{{ route('orden_trabajo.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                + Agregar Orden
            </a>
        </div>

        <!-- Verificar si hay órdenes de trabajo -->
        @if ($ordenesTrabajo->count() === 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <p class="text-yellow-800">No hay órdenes de trabajo disponibles.</p>
            </div>
        @else
            <!-- Tabla de Órdenes de Trabajo -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Boleta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Servicio
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cantidad de Muestras
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Costo Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado de Pago
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($ordenesTrabajo as $orden)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $orden->boleta->numero_solicitud }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $orden->servicio->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $orden->cantidad_muestras }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($orden->costo_total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if ($orden->estado_pago === 'pendiente') bg-yellow-100 text-yellow-800 
                                        @elseif ($orden->estado_pago === 'pagado') bg-green-100 text-green-800 
                                        @endif">
                                        {{ ucfirst($orden->estado_pago) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <a href="{{ route('orden_trabajo.pdf', $orden->id) }}" 
                                       target="_blank"
                                       class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                                        Imprimir
                                    </a>
                                    @if ($orden->estado_pago === 'pendiente')
                                        <form action="{{ route('orden_trabajo.cambiarEstado', $orden->id) }}" method="POST" class="inline-block ml-2" 
                                            onsubmit="return confirmarCambioEstado(event)">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" 
                                                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                                                Marcar como Pagado
                                            </button>
                                        </form>
                                    @endif
                                    <script>
                                        function confirmarCambioEstado(event) {
                                            event.preventDefault(); // Evitar que el formulario se envíe automáticamente
                                            Swal.fire({
                                                title: '¿Estás seguro?',
                                                text: "¿Deseas marcar esta orden como pagada?",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Sí, marcar como pagada',
                                                cancelButtonText: 'Cancelar'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    event.target.submit(); // Enviar el formulario si el usuario confirma
                                                }
                                            });
                                        }
                                    </script>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Enlaces de Paginación -->
        <div class="mt-6">
            {{ $ordenesTrabajo->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection