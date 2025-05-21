<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenTrabajo;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year); // Debería ser 2025 hoy, 2026 en el futuro

        $totalesPorMes = OrdenTrabajo::selectRaw('MONTH(updated_at) as mes, SUM(costo_total) as total')
            ->where('estado_pago', 'pagado')
            ->whereYear('updated_at', $year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->pluck('total', 'mes')
            ->toArray();

        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        $data = array_fill(1, 12, 0);
        foreach ($totalesPorMes as $mes => $total) {
            $data[$mes] = $total ?? 0;
        }

        $labels = array_values($meses);
        $values = array_map(function ($value) {
            return number_format($value, 2, '.', ',');
        }, array_values($data));

        // Obtener el rango de años desde el más antiguo hasta el actual
        $minYear = OrdenTrabajo::where('estado_pago', 'pagado')
            ->min('updated_at') ? Carbon::parse(OrdenTrabajo::min('updated_at'))->year : Carbon::now()->year;
        $maxYear = Carbon::now()->year;
        $years = range($minYear, $maxYear);

        if (empty($years)) {
            $years = [Carbon::now()->year];
        }

        if (!in_array($year, $years)) {
            $years[] = $year;
            sort($years);
        }

        // Calcular el total general de la gestión seleccionada
        $totalGeneral = OrdenTrabajo::where('estado_pago', 'pagado')
            ->whereYear('updated_at', $year)
            ->sum('costo_total');

        return view('dashboard', compact('labels', 'values', 'year', 'years', 'totalGeneral'));
    }
}
