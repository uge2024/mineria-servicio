<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta {{ $boleta->numero_solicitud }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Boleta de Solicitud</h1>

    <p><strong>Número de Solicitud:</strong> {{ $boleta->numero_solicitud }}</p>
    <p><strong>Servicio:</strong> {{ $boleta->servicio->nombre }}</p>
    <p><strong>Solicitante:</strong> {{ $boleta->nombre_solicitante }}</p>
    <p><strong>C.I.:</strong> {{ $boleta->ci }}</p>
    <p><strong>Sector:</strong> {{ $boleta->sector }}</p>
    <p><strong>Fecha de Solicitud:</strong> {{ $boleta->fecha_solicitud }}</p>
    <p><strong>Número de Contrato:</strong> {{ $boleta->numero_contrato }}</p>

    <h2>Detalles de las Muestras</h2>
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
            @foreach ($boleta->muestras as $muestra)
                <tr>
                    <td>{{ $muestra->caracteristicas_muestra ?? 'N/A' }}</td>
                    <td>{{ $muestra->peso }}</td>
                    <td>{{ $muestra->municipio }}</td>
                    <td>{{ $muestra->lugar_especifico }}</td>
                    <td>{{ $muestra->tipo_material }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>