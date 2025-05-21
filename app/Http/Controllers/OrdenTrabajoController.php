<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleta;
use App\Models\OrdenTrabajo;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdenTrabajoController extends Controller
{
    
    public function index()
    {
        $ordenesTrabajo = OrdenTrabajo::with(['boleta', 'servicio'])->orderBy('created_at', 'desc')->paginate(10);
        return view('orden_trabajo.index', compact('ordenesTrabajo'));
    }
    
    public function create()
    {
        // Obtener boletas que no tienen una orden de trabajo asociada
        $boletas = Boleta::whereDoesntHave('ordenTrabajo')->get();

        return view('orden_trabajo.create', compact('boletas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'boleta_id' => 'required|exists:boletas,id',
        ]);
        // Obtener la boleta asociada
    $boleta = Boleta::findOrFail($request->boleta_id);
    $servicio = $boleta->servicio;
    $cantidadMuestras = $boleta->muestras->count();
    $costoTotal = $cantidadMuestras * $servicio->precio;

    // Extraer el año de la fecha de solicitud (gestión) de la boleta
    $gestion = \Carbon\Carbon::parse($boleta->fecha_solicitud)->format('Y');

    // Obtener la última orden de trabajo de la misma gestión
    $lastOrden = OrdenTrabajo::whereHas('boleta', function ($query) use ($gestion) {
        $query->whereYear('fecha_solicitud', $gestion);
    })->orderBy('numero_orden', 'desc')->first();

    // Generar el número de orden
    if ($lastOrden) {
        // Extraer el número secuencial usando una expresión regular más precisa
        preg_match('/(\d{3})-\d{4}$/', $lastOrden->numero_orden, $matches);
        $ultimoNumero = $matches ? intval($matches[1]) : 0; // Capturar solo el número secuencial
        $nuevoNumero = $ultimoNumero + 1;
    } else {
        // Si no hay órdenes en esta gestión, empezar desde 1
        $nuevoNumero = 1;
    }

    // Formatear el número de orden (ejemplo: 001-2025)
    $numeroOrden = str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT) . "-{$gestion}";

    // Verificar que el número de orden no exista ya
    while (OrdenTrabajo::where('numero_orden', $numeroOrden)->exists()) {
        $nuevoNumero++;
        $numeroOrden = str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT) . "-{$gestion}";
    }

    // Crear la orden de trabajo
    OrdenTrabajo::create([
        'boleta_id' => $boleta->id,
        'servicio_id' => $servicio->id,
        'cantidad_muestras' => $cantidadMuestras,
        'costo_total' => $costoTotal,
        'estado_pago' => 'pendiente',
        'numero_orden' => $numeroOrden,
    ]);

    return redirect()->route('orden_trabajo.index')->with('success', 'Orden de trabajo generada correctamente.');
}

    public function generarPDF($id)
    {
        // Obtener la orden de trabajo con sus relaciones
        $ordenTrabajo = OrdenTrabajo::with(['boleta', 'servicio', 'boleta.muestras'])->findOrFail($id);
    
        // Cargar la vista del PDF con los datos
        $pdf = Pdf::loadView('orden_trabajo.pdf', compact('ordenTrabajo'));
    
        // Mostrar el PDF en una nueva pestaña
    return $pdf->stream('orden_trabajo_' . $ordenTrabajo->id . '.pdf');
    }


    public function cambiarEstado($id)
    {
        // Buscar la orden de trabajo por ID
        $ordenTrabajo = OrdenTrabajo::findOrFail($id);

        // Verificar si ya está pagado
        if ($ordenTrabajo->estado_pago === 'pagado') {
            return redirect()->route('orden_trabajo.index')
                            ->with('error', 'Esta orden de trabajo ya ha sido marcada como pagada.');
        }

        // Cambiar el estado de pago a "pagado"
        $ordenTrabajo->estado_pago = 'pagado';
        $ordenTrabajo->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('orden_trabajo.index')->with('success', 'Estado de pago actualizado correctamente.');
    }
    
    public function reporte(Request $request)
    {
        // Definir fechas predeterminadas si no se proporcionan
        $fechaInicio = $request->input('fecha_inicio') ?? now()->toDateString();
        $fechaFin = $request->input('fecha_fin') ?? now()->toDateString();

        // Validar las fechas
        $request->validate([
            'fecha_inicio' => 'nullable|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        // Buscar órdenes pagadas entre las fechas
        $ordenesPagadas = OrdenTrabajo::with(['boleta', 'servicio'])
            ->where('estado_pago', 'pagado')
            ->whereBetween('updated_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Calcular el total cobrado
        $totalCobrado = $ordenesPagadas->sum('costo_total');

        // Si se solicita exportar a PDF
        if ($request->has('export_pdf')) {
            $pdf = Pdf::loadView('orden_trabajo.reporte_pdf', compact('ordenesPagadas', 'totalCobrado', 'fechaInicio', 'fechaFin'));
            return $pdf->stream('reporte_ordenes_pagadas_' . $fechaInicio . '_a_' . $fechaFin . '.pdf');
        }

        // Pasar los datos a la vista
        return view('orden_trabajo.reporte', compact('ordenesPagadas', 'totalCobrado', 'fechaInicio', 'fechaFin'));
    }

}
