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
        // Obtener la boleta
        $boleta = Boleta::findOrFail($request->boleta_id);
    
        // Obtener el servicio asociado a la boleta
        $servicio = $boleta->servicio;
    
        // Contar la cantidad de muestras asociadas a la boleta
        $cantidadMuestras = $boleta->muestras->count();
    
        // Calcular el costo total (cantidad de muestras * precio del servicio)
        $costoTotal = $cantidadMuestras * $servicio->precio;
    
        // Crear la orden de trabajo
        OrdenTrabajo::create([
            'boleta_id' => $boleta->id,
            'servicio_id' => $servicio->id,
            'cantidad_muestras' => $cantidadMuestras,
            'costo_total' => $costoTotal,
            'estado_pago' => 'pendiente', // Estado inicial
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

        // Cambiar el estado de pago a "pagado"
        $ordenTrabajo->estado_pago = 'pagado';
        $ordenTrabajo->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('orden_trabajo.index')->with('success', 'Estado de pago actualizado correctamente.');
    }
    

}
