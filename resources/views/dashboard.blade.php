@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        
        <!-- Total General de la Gestión -->
        <div class="bg-green-100 p-4 rounded-lg shadow-md mb-6 text-center">
            <h2 class="text-lg font-semibold text-green-800">Total Cobrado en la Gestión {{ $year }}</h2>
            <p class="text-2xl font-bold text-green-700">Bs. {{ number_format($totalGeneral, 2, ',', '.') }}</p>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

        <!-- Formulario para seleccionar el año -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-4">
                <label for="year" class="text-sm font-medium text-gray-700">Seleccionar Año:</label>
                <select name="year" id="year" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @if (isset($years) && !empty($years))
                        @foreach ($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    @else
                        <option value="{{ Carbon\Carbon::now()->year }}" selected>{{ Carbon\Carbon::now()->year }}</option>
                    @endif
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Gráfico de totales cobrados por mes -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Total Cobrado por Mes ({{ $year }})</h2>
            <div class="w-full">
                <canvas id="totalesPorMesChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('totalesPorMesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Total Cobrado (Bs.)',
                data: @json($values).map(value => parseFloat(value.replace(',', ''))),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                barThickness: 20,
                hoverBackgroundColor: 'rgba(37, 99, 235, 0.9)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Cobrado (Bs.)',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Bs. ' + value.toLocaleString('es-BO', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        },
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Bs. ' + context.raw.toLocaleString('es-BO', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    }
                }
            },
            animation: {
                duration: 1000
            }
        }
    });
</script>
@endpush