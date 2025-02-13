<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        Servicio::create($validated);
        return redirect()->route('servicios.index')->with('success', 'Servicio registrado exitosamente.');
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
    public function edit(Servicio $servicio)
    {
    return view('servicios.edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicio $servicio)
    {
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
    ]);

    $servicio->update([
        'nombre' => $request->nombre,
        'precio' => $request->precio,
    ]);

    return redirect()->route('servicios.index')->with('success', 'Servicio actualizado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
    $servicio->delete(); // ✅ El servicio ya está definido

    return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }

}
