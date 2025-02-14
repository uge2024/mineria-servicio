<!-- resources/views/orden_trabajo/pdf.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Trabajo #{{ $ordenTrabajo->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Orden de Trabajo #{{ $ordenTrabajo->id }}</h1>

    <!-- Información de la boleta -->
    <div class="info">
        <p><strong>Boleta:</strong> {{ $ordenTrabajo->boleta->numero_solicitud }}</p>
        <p><strong>Solicitante:</strong> {{ $ordenTrabajo->boleta->nombre_solicitante }}</p>
        <p><strong>CI:</strong> {{ $ordenTrabajo->boleta->ci }}</p>
        <p><strong>Sector:</strong> {{ $ordenTrabajo->boleta->sector }}</p>
        <p><strong>Fecha de Solicitud:</strong> {{ $ordenTrabajo->boleta->fecha_solicitud }}</p>
        <p><strong>Número de Contrato:</strong> {{ $ordenTrabajo->boleta->numero_contrato }}</p>
    </div>

    <!-- Información del servicio -->
    <div class="info">
        <p><strong>Servicio:</strong> {{ $ordenTrabajo->servicio->nombre }}</p>
        <p><strong>Precio Unitario:</strong> ${{ number_format($ordenTrabajo->servicio->precio, 2) }}</p>
    </div>

    <!-- Detalles de la orden de trabajo -->
    <div class="info">
        <p><strong>Cantidad de Muestras:</strong> {{ $ordenTrabajo->cantidad_muestras }}</p>
        <p><strong>Costo Total:</strong> ${{ number_format($ordenTrabajo->costo_total, 2) }}</p>
        <p><strong>Estado de Pago:</strong> {{ ucfirst($ordenTrabajo->estado_pago) }}</p>
    </div>

    <!-- Tabla de muestras -->
    <h2>Muestras</h2>
    <table>
        <thead>
            <tr>
                <th>Características</th>
                <th>Peso (kg)</th>
                <th>Municipio</th>
                <th>Lugar Específico</th>
                <th>Tipo de Material</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordenTrabajo->boleta->muestras as $muestra)
                <tr>
                    <td>{{ $muestra->caracteristicas_muestra }}</td>
                    <td>{{ $muestra->peso }}</td>
                    <td>{{ $muestra->municipio }}</td>
                    <td>{{ $muestra->lugar_especifico }}</td>
                    <td>{{ $muestra->tipo_material }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>