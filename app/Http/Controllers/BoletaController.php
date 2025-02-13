<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleta;
use App\Models\Servicio;
use App\Models\Muestra;
use Barryvdh\DomPDF\Facade\Pdf;

class BoletaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boletas = Boleta::with('servicio')
                      ->orderBy('created_at', 'desc')
                      ->get();

    return view('boletas.index', compact('boletas'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicios = Servicio::all();
        return view('boletas.create', compact('servicios'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validar los datos generales de la boleta
    $validated = $request->validate([
        'servicio_id' => 'required|exists:servicios,id',
        'nombre_solicitante' => 'required|string|max:255',
        'ci' => 'required|string|max:20',
        'sector' => 'required|string|max:255',
        'fecha_solicitud' => 'required|date',
        'numero_contrato' => 'required|string|max:255',
        'muestras' => 'required|array|min:1',
        'muestras.*.caracteristicas_muestra' => 'nullable|string',
        'muestras.*.peso' => 'required|numeric|min:0',
        'muestras.*.municipio' => 'required|string|max:255',
        'muestras.*.lugar_especifico' => 'required|string|max:255',
        'muestras.*.tipo_material' => 'required|string|in:Brosa,Fina',
    ]);

    // Extraer el año de la fecha de solicitud (gestión)
    $gestion = \Carbon\Carbon::parse($validated['fecha_solicitud'])->format('Y');

    // Obtener la última boleta de la misma gestión
    $lastBoleta = Boleta::whereYear('fecha_solicitud', $gestion)
                         ->orderBy('id', 'desc')
                         ->first();

    // Generar el número de solicitud
    if ($lastBoleta) {
        // Extraer el número secuencial usando una expresión regular más precisa
        preg_match('/-(\d{3})-\d{4}$/', $lastBoleta->numero_solicitud, $matches);
        $ultimoNumero = $matches ? intval($matches[1]) : 0; // Capturar solo el número secuencial
        $nuevoNumero = $ultimoNumero + 1;
    } else {
        // Si no hay boletas en esta gestión, empezar desde 1
        $nuevoNumero = 1;
    }

    // Formatear el número de solicitud (ejemplo: SDMHyE-003-2025)
    $numeroSolicitud = "SDMHyE-" . str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT) . "-{$gestion}";

    // Verificar que el número de solicitud no exista ya
    while (Boleta::where('numero_solicitud', $numeroSolicitud)->exists()) {
        $nuevoNumero++;
        $numeroSolicitud = "SDMHyE-" . str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT) . "-{$gestion}";
    }

    // Crear la boleta
    $boleta = Boleta::create([
        'servicio_id' => $validated['servicio_id'],
        'nombre_solicitante' => $validated['nombre_solicitante'],
        'ci' => $validated['ci'],
        'sector' => $validated['sector'],
        'fecha_solicitud' => $validated['fecha_solicitud'],
        'numero_contrato' => $validated['numero_contrato'],
        'numero_solicitud' => $numeroSolicitud, // Asignar el número de solicitud
    ]);

    // Crear las muestras asociadas
    foreach ($validated['muestras'] as $muestraData) {
        $boleta->muestras()->create([
            'caracteristicas_muestra' => $muestraData['caracteristicas_muestra'],
            'peso' => $muestraData['peso'],
            'municipio' => $muestraData['municipio'],
            'lugar_especifico' => $muestraData['lugar_especifico'],
            'tipo_material' => $muestraData['tipo_material'],
        ]);
    }

    // Redirigir con mensaje de éxito
    return redirect()->route('boletas.index')->with('success', 'Boleta generada exitosamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Boleta $boleta)
    {
        $servicios = \App\Models\Servicio::all(); // Obtener servicios disponibles
        return view('boletas.edit', compact('boleta', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boleta $boleta)
    {
        // Validar los datos generales de la boleta
    $validated = $request->validate([
        'servicio_id' => 'required|exists:servicios,id',
        'nombre_solicitante' => 'required|string|max:255',
        'ci' => 'required|string|max:20',
        'sector' => 'required|string|max:255',
        'fecha_solicitud' => 'required|date',
        'numero_contrato' => 'required|string|max:255',
        'muestras' => 'required|array|min:1',
        'muestras.*.id' => 'nullable|exists:muestras,id',
        'muestras.*.caracteristicas_muestra' => 'nullable|string',
        'muestras.*.peso' => 'required|numeric|min:0',
        'muestras.*.municipio' => 'required|string|max:255',
        'muestras.*.lugar_especifico' => 'required|string|max:255',
        'muestras.*.tipo_material' => 'required|string|in:Brosa,Fina',
    ]);

    // Actualizar los datos generales de la boleta
    $boleta->update([
        'servicio_id' => $validated['servicio_id'],
        'nombre_solicitante' => $validated['nombre_solicitante'],
        'ci' => $validated['ci'],
        'sector' => $validated['sector'],
        'fecha_solicitud' => $validated['fecha_solicitud'],
        'numero_contrato' => $validated['numero_contrato'],
    ]);

    // Actualizar o crear las muestras asociadas
    foreach ($validated['muestras'] as $muestraData) {
        if (isset($muestraData['id'])) {
            // Si existe un ID, actualizar la muestra existente
            Muestra::where('id', $muestraData['id'])->update([
                'caracteristicas_muestra' => $muestraData['caracteristicas_muestra'],
                'peso' => $muestraData['peso'],
                'municipio' => $muestraData['municipio'],
                'lugar_especifico' => $muestraData['lugar_especifico'],
                'tipo_material' => $muestraData['tipo_material'],
            ]);
        } else {
            // Si no existe un ID, crear una nueva muestra
            $boleta->muestras()->create([
                'caracteristicas_muestra' => $muestraData['caracteristicas_muestra'],
                'peso' => $muestraData['peso'],
                'municipio' => $muestraData['municipio'],
                'lugar_especifico' => $muestraData['lugar_especifico'],
                'tipo_material' => $muestraData['tipo_material'],
            ]);
        }
    }

    // Eliminar muestras marcadas para eliminación
    if ($request->has('muestras_eliminar')) {
        Muestra::whereIn('id', $request->input('muestras_eliminar'))->delete();
    }

    // Redirigir con mensaje de éxito
    return redirect()->route('boletas.index')->with('success', 'Boleta actualizada exitosamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boleta $boleta)
    {
        $boleta->muestras()->delete(); // Eliminar todas las muestras asociadas
    $boleta->delete(); // Eliminar la boleta
    return redirect()->route('boletas.index')->with('success', 'Boleta eliminada exitosamente.');
    
    }

    /**
     * Generar PDF de una boleta específica.
     */
    public function generatePdf(Boleta $boleta)
    {
        // Cargar la boleta con sus muestras asociadas
        $boleta->load('muestras');

        // Generar el PDF
        $pdf = Pdf::loadView('boletas.pdf', compact('boleta'));

        // Descargar el PDF o mostrarlo en el navegador
        return $pdf->stream('boleta_' . $boleta->numero_solicitud . '.pdf');
    }
}
