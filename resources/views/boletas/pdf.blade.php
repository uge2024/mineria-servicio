<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud {{ $boleta->numero_solicitud }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
            font-size: 12px;
        }
        .header, .section {
            width: 100%;
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }
        .header img {
            width: 100px;
            float: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }
        .section1 {
            text-align: center;
            font-size: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="" alt="Logo">
        <h1>GOBIERNO AUTÓNOMO DEPARTAMENTAL DE COCHABAMBA</h1>
        <h2>Secretaria Departamental de Minería, Hidrocarburos y Energías</h2>
        <h2>FORMULARIO DE:{{ $boleta->servicio->nombre }}</h2>
        <h2>Número de Solicitud: {{ $boleta->numero_solicitud }}</h2>
        
    </div>

    <div class="section">
        <h3>DATOS DEL SOLICITANTE</h3>
        <table>
            <tr>
                <td><strong>Nombre del Solicitante:</strong> {{ $boleta->nombre_solicitante }}</td>
                <td><strong>C.I.:</strong> {{ $boleta->ci }}</td>
            </tr>
            <tr>
                <td><strong>Razon Social al Sector que Pertenece:</strong> {{ $boleta->sector }}</td>
                <td><strong>N° de Contacto:</strong> {{ $boleta->numero_contrato }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Fecha de Solicitud:</strong> {{ \Carbon\Carbon::parse($boleta->fecha_solicitud)->format('d-m-Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>DATOS SOBRE LAS MUESTRAS</h3>
        <table>
            <thead>
                <tr>
                    <th>N.º</th>
                    <th>Codigo</th>
                    <th>Características de la Muestra</th>
                    <th>Municipio</th>
                    <th>Lugar Específico</th>
                    <th>Tipo de Material</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($boleta->muestras as $index => $muestra)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $muestra->codigo }}</td>
                    <td>{{ $muestra->caracteristicas_muestra ?? 'N/A' }}</td>
                    <td>{{ $muestra->municipio }}</td>
                    <td>{{ $muestra->lugar_especifico }}</td>
                    <td>{{ $muestra->tipo_material }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <p>El tiempo para la entrega de resultados del análisis de muestra FRX es según la cantidad de muestras.</p>
        <p>En caso de no recoger las muestras durante 2 meses, este sera desechado por el Gobierno Autónomo Departamental de Cochabamba.</p>
    </div>

    <div class="section">
        <h3>OBSERVACIONES</h3>
        <p>........................................................................................................................................................................................................................................................</p>
    </div>

    <div class="section1">
        
        <p>.....................................................................................................................................</p>
        <h3>FIRMA</h3>
        <p>Nombre del Solitante: {{ $boleta->nombre_solicitante }}</p>
    </div>

    
</body>
</html>