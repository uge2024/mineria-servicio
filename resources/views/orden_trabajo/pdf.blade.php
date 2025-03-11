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
            padding: 10px; /* Reducir el padding */
            font-size: 12px; /* Reducir el tamaño de la fuente */
        }
        .header {
            position: relative;
            width: 100%;
            margin-bottom: 10px; /* Reducir el margen inferior */
            text-align: center;
        }
        .header img {
            height: 60px; /* Reducir el tamaño de los logos */
        }
        .logo-left {
            position: absolute;
            top: 0;
            left: 0;
        }
        .logo-right {
            position: absolute;
            top: 0;
            right: 0;
        }
        .institution-name {
            font-size: 14px; /* Reducir el tamaño de la fuente */
            font-weight: bold;
            margin-bottom: 5px; /* Reducir el margen inferior */
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 10px; /* Reducir el margen superior */
            font-size: 16px; /* Reducir el tamaño de la fuente */
        }
        .info-table {
            width: 80%; /* Reducir el ancho de la tabla */
            margin: 0 auto; /* Centrar la tabla */
            border-collapse: collapse;
            margin-bottom: 10px; /* Reducir el margen inferior */
        }
        .info-table, .info-table th, .info-table td {
            border: 1px solid #333;
        }
        .info-table th, .info-table td {
            padding: 5px; /* Reducir el padding */
            text-align: left;
            font-size: 10px; /* Reducir el tamaño de la fuente */
        }
        .info-table th {
            background-color: #f2f2f2;
        }
        .samples-table {
            width: 80%; /* Reducir el ancho de la tabla */
            margin: 0 auto; /* Centrar la tabla */
            border-collapse: collapse;
            margin-top: 10px; /* Reducir el margen superior */
        }
        .samples-table, .samples-table th, .samples-table td {
            border: 1px solid #333;
        }
        .samples-table th, .samples-table td {
            padding: 5px; /* Reducir el padding */
            text-align: left;
            font-size: 10px; /* Reducir el tamaño de la fuente */
        }
        .samples-table th {
            background-color: #f2f2f2;
        }
        .section1 {
            text-align: center;
            font-size: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Encabezado con logos -->
    <div class="header">
        <div class="logo-left">
            <img src="" alt="Logo Izquierdo">
        </div>
        <div class="logo-right">
            <img src="" alt="Logo Derecho">
        </div>
        <div class="institution-name">
            <h2>Gobierno Autónomo Departamental de Cochabamba</h2>
            <h1>Secretaria Departamental de Minería, Hidrocarburos y Energías</h1>
            
        </div>
    </div>

    <!-- Título principal -->
    <h1>Orden de Trabajo #{{ $ordenTrabajo->id }}</h1>

    <!-- Información de la boleta en tabla -->
    <table class="info-table">
        <thead>
            <tr>
                <th colspan="2">Datos de la Solicitud</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Número de Solicitud:</strong></td>
                <td>{{ $ordenTrabajo->boleta->numero_solicitud }}</td>
            </tr>
            <tr>
                <td><strong>Solicitante:</strong></td>
                <td>{{ $ordenTrabajo->boleta->nombre_solicitante }}</td>
            </tr>
            <tr>
                <td><strong>CI:</strong></td>
                <td>{{ $ordenTrabajo->boleta->ci }}</td>
            </tr>
            <tr>
                <td><strong>Sector:</strong></td>
                <td>{{ $ordenTrabajo->boleta->sector }}</td>
            </tr>
            <tr>
                <td><strong>Fecha de Solicitud:</strong></td>
                <td>{{ $ordenTrabajo->boleta->fecha_solicitud }}</td>
            </tr>
            <tr>
                <td><strong>Número de Contacto:</strong></td>
                <td>{{ $ordenTrabajo->boleta->numero_contrato }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Información del servicio en tabla -->
    <table class="info-table">
        <thead>
            <tr>
                <th colspan="2">Información del Servicio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Servicio:</strong></td>
                <td>{{ $ordenTrabajo->servicio->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Precio Unitario:</strong></td>
                <td>{{ number_format($ordenTrabajo->servicio->precio, 2) }} Bolivianos</td>
            </tr>
        </tbody>
    </table>

    <!-- Detalles de la orden de trabajo en tabla -->
    <table class="info-table">
        <thead>
            <tr>
                <th colspan="2">Detalles de la Orden de Trabajo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Cantidad de Muestras:</strong></td>
                <td>{{ $ordenTrabajo->cantidad_muestras }}</td>
            </tr>
            <tr>
                <td><strong>Costo Total:</strong></td>
                <td>{{ number_format($ordenTrabajo->costo_total, 2) }} Bolivianos</td>
            </tr>
            <tr>
                <td><strong>Estado de Pago:</strong></td>
                <td>{{ ucfirst($ordenTrabajo->estado_pago) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tabla de muestras -->
    <h1>Muestras</h1>
    <table class="samples-table">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Características</th>
                <th>Municipio</th>
                <th>Lugar Específico</th>
                <th>Tipo de Material</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordenTrabajo->boleta->muestras as $muestra)
                <tr>
                    <td>{{ $muestra->codigo }}</td>
                    <td>{{ $muestra->caracteristicas_muestra }}</td>
                    <td>{{ $muestra->municipio }}</td>
                    <td>{{ $muestra->lugar_especifico }}</td>
                    <td>{{ $muestra->tipo_material }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="section1">
        
        <p>.....................................................................................................................................</p>
        <h3>INSTRUCTIVO DE TRABAJO</h3>

    </div>
</body>
</html>