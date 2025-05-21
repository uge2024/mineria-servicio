<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Órdenes Pagadas</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h3 {
            font-size: 16px;
            color: #2c3e50;
            margin: 5px 0;
        }
        .header p {
            font-size: 10px;
            color: #7f8c8d;
        }
        h1 {
            font-size: 18px;
            color: #2c3e50;
            text-align: center;
            margin: 10px 0;
        }
        h2 {
            font-size: 14px;
            color: #34495e;
            margin: 15px 0 5px;
        }
        p {
            margin: 5px 0;
        }
        .total {
            font-size: 14px;
            font-weight: bold;
            color: #27ae60;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-size: 12px;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        td {
            font-size: 11px;
            padding: 6px;
            border: 1px solid #ddd;
            color: #333;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h3>Gobierno Autónomo Departamental de Cochabamba</h3>
        <p>Secretaria Departamental de Minería, Hidrocarburos y Energías</p>
        <p>Generado el: {{ now()->format('d/m/Y') }}</p>
    </div>

    <h1>Reporte de Órdenes de Trabajo Pagadas</h1>
    <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}</p>
    <p><strong>Fecha de Fin:</strong> {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>

    <h2>Total Cobrado:</h2>
    <p class="total">Bs. {{ number_format($totalCobrado, 2) }}</p>

    @if ($ordenesPagadas->isEmpty())
        <p>No hay órdenes de trabajo pagadas en el rango de fechas seleccionado.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Número de Orden</th>
                    <th>Boleta</th>
                    <th>Servicio</th>
                    <th>Cantidad de Muestras</th>
                    <th>Costo Total</th>
                    <th>Fecha de Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordenesPagadas as $orden)
                    <tr>
                        <td>{{ $orden->numero_orden }}</td>
                        <td>{{ $orden->boleta->numero_solicitud }}</td>
                        <td>{{ $orden->servicio->nombre }}</td>
                        <td>{{ $orden->cantidad_muestras }}</td>
                        <td>Bs. {{ number_format($orden->costo_total, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($orden->updated_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Pie de página -->
    <div class="footer">
        <p>Secretaria Departamental de Minería, Hidrocarburos y Energías {{ now()->format('d/m/Y') }}</p>
    </div>
</body>
</html>