@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6 text-center">Generar Solicitud</h1>

    <form action="{{ route('boletas.store') }}" method="POST" class="space-y-6" id="multiStepForm">
        @csrf

        <!-- Contenedor de Pasos -->
        <div id="step1" class="step">
            <h2 class="text-lg font-medium mb-4">Paso 1: Datos Generales</h2>
            <!-- Servicio -->
            <div>
                <label for="servicio_id" class="block text-sm font-medium text-gray-700">Servicio:</label>
                <select name="servicio_id" id="servicio_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecciona un servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                            {{ $servicio->nombre }} ({{ $servicio->precio }} Bs.)
                        </option>
                    @endforeach
                </select>
                @error('servicio_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Nombre del Solicitante -->
            <div>
                <label for="nombre_solicitante" class="block text-sm font-medium text-gray-700">Nombre del Solicitante:</label>
                <input type="text" name="nombre_solicitante" id="nombre_solicitante" required value="{{ old('nombre_solicitante') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('nombre_solicitante')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- CI -->
            <div>
                <label for="ci" class="block text-sm font-medium text-gray-700">C.I.:</label>
                <input type="text" name="ci" id="ci" required value="{{ old('ci') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('ci')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Sector -->
            <div>
                <label for="sector" class="block text-sm font-medium text-gray-700">Razon Social al Sector que Pertenece:</label>
                <input type="text" name="sector" id="sector" required value="{{ old('sector') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('sector')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Fecha de Solicitud -->
            <div>
                <label for="fecha_solicitud" class="block text-sm font-medium text-gray-700">Fecha de Solicitud:</label>
                <input 
                    type="date" 
                    name="fecha_solicitud" 
                    id="fecha_solicitud" 
                    required 
                    value="{{ old('fecha_solicitud', now()->format('Y-m-d')) }}" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                >
                @error('fecha_solicitud')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Número de Contrato -->
            <div>
                <label for="numero_contrato" class="block text-sm font-medium text-gray-700">Número de Contacto:</label>
                <input type="text" name="numero_contrato" id="numero_contrato" required value="{{ old('numero_contrato') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('numero_contrato')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Botón para Avanzar -->
            <div class="flex justify-end mt-4">
                <button type="button" onclick="nextStep(2)" class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                    Siguiente
                </button>
            </div>
        </div>

        <div id="step2" class="step hidden">
            <h2 class="text-lg font-medium mb-4">Paso 2: Detalles de las Muestras</h2>
            <div id="muestras-container">
                <!-- Primer campo de muestra por defecto -->
                <div class="border p-4 mb-4 rounded-md muestra-item">
                    <h3 class="text-md font-medium mb-2">Muestra 1</h3>
                    <!-- Características de la Muestra -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Características de la Muestra:</label>
                        <textarea name="muestras[0][caracteristicas_muestra]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <!-- Peso -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peso (kg):</label>
                        <input type="number" step="0.01" name="muestras[0][peso]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <!-- Municipio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Municipio:</label>
                        <input type="text" name="muestras[0][municipio]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <!-- Lugar Específico -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lugar Específico:</label>
                        <input type="text" name="muestras[0][lugar_especifico]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <!-- Tipo de Material -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo de Material:</label>
                        <select name="muestras[0][tipo_material]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Selecciona una opción</option>
                            <option value="Brosa">Brosa</option>
                            <option value="Fina">Fina</option>
                        </select>
                    </div>
                    <!-- Botón para eliminar muestra -->
                    <button type="button" class="remove-muestra mt-2 py-1 px-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                        Eliminar Muestra
                    </button>
                </div>
            </div>

            <!-- Botón para agregar nueva muestra -->
            <button type="button" id="add-muestra" class="py-2 px-4 bg-green-500 text-white rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-500 mb-4">
                Agregar Mas Muestras
            </button>

            <!-- Botones de Navegación -->
            <div class="flex justify-between mt-4">
                <button type="button" onclick="prevStep(1)" class="py-2 px-4 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:ring-2 focus:ring-gray-500">
                    Anterior
                </button>
                <button type="submit" class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                    Generar Solicitud
                </button>
            </div>
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
                <label class="block text-sm font-medium text-gray-700">Peso (kg):</label>
                <input type="number" step="0.01" name="muestras[${muestraIndex}][peso]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
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

    // Función para eliminar una muestra
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('remove-muestra')) {
            const muestraItem = event.target.closest('.muestra-item');
            muestraItem.remove();

            // Recalcular los índices de las muestras restantes
            const muestras = document.querySelectorAll('#muestras-container .muestra-item');
            muestras.forEach((item, index) => {
                // Actualizar el título de la muestra
                item.querySelector('h3').textContent = `Muestra ${index + 1}`;

                // Actualizar los nombres de los campos
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

    // Funciones para navegar entre pasos
    function nextStep(step) {
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
    }

    function prevStep(step) {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
    }
</script>
@endsection