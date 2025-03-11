@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6 text-center">Editar Boleta</h1>

    <form action="{{ route('boletas.update', $boleta->id) }}" method="POST" class="space-y-6" id="multiStepForm">
        @csrf
        @method('PUT')

        <!-- Datos Generales -->
        <div>
            <h2 class="text-lg font-medium mb-4">Datos Generales</h2>
            <!-- Servicio -->
            <div>
                <label for="servicio_id" class="block text-sm font-medium text-gray-700">Servicio:</label>
                <select name="servicio_id" id="servicio_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ $boleta->servicio_id == $servicio->id ? 'selected' : '' }}>
                            {{ $servicio->nombre }} ({{ $servicio->precio }} Bs.)
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Nombre del Solicitante -->
            <div>
                <label for="nombre_solicitante" class="block text-sm font-medium text-gray-700">Nombre del Solicitante:</label>
                <input type="text" name="nombre_solicitante" id="nombre_solicitante" required value="{{ old('nombre_solicitante', $boleta->nombre_solicitante) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <!-- CI -->
            <div>
                <label for="ci" class="block text-sm font-medium text-gray-700">C.I.:</label>
                <input type="text" name="ci" id="ci" required value="{{ old('ci', $boleta->ci) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <!-- Sector -->
            <div>
                <label for="sector" class="block text-sm font-medium text-gray-700">Razón Social al Sector que Pertenece:</label>
                <input type="text" name="sector" id="sector" required value="{{ old('sector', $boleta->sector) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <!-- Fecha de Solicitud -->
            <div>
                <label for="fecha_solicitud" class="block text-sm font-medium text-gray-700">Fecha de Solicitud:</label>
                <input 
                    type="date" 
                    name="fecha_solicitud" 
                    id="fecha_solicitud" 
                    required 
                    value="{{ old('fecha_solicitud', $boleta->fecha_solicitud) }}" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
            <!-- Número de Contrato -->
            <div>
                <label for="numero_contrato" class="block text-sm font-medium text-gray-700">Número de Contrato:</label>
                <input type="text" name="numero_contrato" id="numero_contrato" required value="{{ old('numero_contrato', $boleta->numero_contrato) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Detalles de las Muestras -->
        <div>
            <h2 class="text-lg font-medium mb-4">Detalles de las Muestras</h2>
            <div id="muestras-container">
                @foreach ($boleta->muestras as $index => $muestra)
                    <div class="border p-4 mb-4 rounded-md muestra-item">
                        <h3 class="text-md font-medium mb-2">Muestra {{ $index + 1 }}</h3>
                        <input type="hidden" name="muestras[{{ $index }}][id]" value="{{ $muestra->id }}">
                        <!-- Código (solo lectura) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Código:</label>
                            <input 
                                type="text" 
                                value="{{ $muestra->codigo }}" 
                                readonly 
                                class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-gray-700"
                            >
                        </div>
                        <!-- Características de la Muestra -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Características de la Muestra:</label>
                            <textarea name="muestras[{{ $index }}][caracteristicas_muestra]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old("muestras.$index.caracteristicas_muestra", $muestra->caracteristicas_muestra) }}</textarea>
                        </div>
                        <!-- Municipio -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Municipio:</label>
                            <input type="text" name="muestras[{{ $index }}][municipio]" required value="{{ old("muestras.$index.municipio", $muestra->municipio) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <!-- Lugar Específico -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lugar Específico:</label>
                            <input type="text" name="muestras[{{ $index }}][lugar_especifico]" required value="{{ old("muestras.$index.lugar_especifico", $muestra->lugar_especifico) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <!-- Tipo de Material -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Material:</label>
                            <select name="muestras[{{ $index }}][tipo_material]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="Brosa" {{ $muestra->tipo_material === 'Brosa' ? 'selected' : '' }}>Brosa</option>
                                <option value="Fina" {{ $muestra->tipo_material === 'Fina' ? 'selected' : '' }}>Fina</option>
                            </select>
                        </div>
                        <!-- Botón para eliminar muestra -->
                        <button type="button" class="remove-muestra mt-2 py-1 px-2 bg-red-500 text-white rounded-md hover:bg-red-600" data-muestra-id="{{ $muestra->id }}">
                            Eliminar Muestra
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Campo oculto para almacenar IDs de muestras eliminadas -->
            <div id="muestras-eliminar-container">
                <!-- Aquí se agregarán los inputs ocultos para las muestras eliminadas -->
            </div>

            <!-- Botón para agregar nueva muestra -->
            <button type="button" id="add-muestra" class="py-2 px-4 bg-green-500 text-white rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-500 mb-4">
                Agregar Muestra
            </button>
        </div>

        <!-- Botones de Acción -->
        <div class="flex justify-between mt-4">
            <button type="submit" class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                Guardar Cambios
            </button>
            <a href="{{ route('boletas.index') }}" class="py-2 px-4 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:ring-2 focus:ring-gray-500">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Función para agregar una nueva muestra
    document.getElementById('add-muestra').addEventListener('click', function () {
        const container = document.getElementById('muestras-container');

        // Crear un nuevo div para la muestra
        const newMuestra = document.createElement('div');
        newMuestra.classList.add('border', 'p-4', 'mb-4', 'rounded-md', 'muestra-item');

        // Obtener el índice basado en el número de muestras actuales
        const muestraIndex = container.querySelectorAll('.muestra-item').length;

        // Contenido HTML de la nueva muestra
        newMuestra.innerHTML = `
            <h3 class="text-md font-medium mb-2">Muestra ${muestraIndex + 1}</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700">Características de la Muestra:</label>
                <textarea name="muestras[${muestraIndex}][caracteristicas_muestra]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Municipio:</label>
                <input type="text" name="muestras[${muestraIndex}][municipio]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Lugar Específico:</label>
                <input type="text" name="muestras[${muestraIndex}][lugar_especifico]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de Material:</label>
                <select name="muestras[${muestraIndex}][tipo_material]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecciona una opción</option>
                    <option value="Brosa">Brosa</option>
                    <option value="Fina">Fina</option>
                </select>
            </div>
            <button type="button" class="remove-muestra mt-2 py-1 px-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                Eliminar Muestra
            </button>
        `;

        // Agregar la nueva muestra al contenedor
        container.appendChild(newMuestra);
    });

    // Función para eliminar una muestra y agregar su ID a la lista de eliminados
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('remove-muestra')) {
            const muestraItem = event.target.closest('.muestra-item');
            const muestraId = event.target.getAttribute('data-muestra-id');

            // Si la muestra tiene un ID (es existente), agregarlo a las muestras eliminadas
            if (muestraId) {
                const eliminarContainer = document.getElementById('muestras-eliminar-container');
                const inputEliminar = document.createElement('input');
                inputEliminar.type = 'hidden';
                inputEliminar.name = 'muestras_eliminar[]';
                inputEliminar.value = muestraId;
                eliminarContainer.appendChild(inputEliminar);
            }

            // Eliminar la muestra del DOM
            muestraItem.remove();

            // Recalcular los índices de las muestras restantes
            const muestras = document.querySelectorAll('#muestras-container .muestra-item');
            muestras.forEach((item, index) => {
                item.querySelector('h3').textContent = `Muestra ${index + 1}`;
                item.querySelectorAll('input, textarea, select').forEach(field => {
                    const name = field.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/\[\d+\]/, `[${index}]`);
                        field.setAttribute('name', newName);
                    }
                });
            });
        }
    });
</script>
@endsection