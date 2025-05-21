<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\DashboardController;


 
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('servicios', ServicioController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/boletas', [BoletaController::class, 'index'])->name('boletas.index');
    Route::get('/boletas/create', [BoletaController::class, 'create'])->name('boletas.create');
    Route::post('/boletas', [BoletaController::class, 'store'])->name('boletas.store');

    Route::get('/boletas/{boleta}/edit', [BoletaController::class, 'edit'])->name('boletas.edit');
    Route::put('/boletas/{boleta}', [BoletaController::class, 'update'])->name('boletas.update');
    Route::delete('/boletas/{boleta}', [BoletaController::class, 'destroy'])->name('boletas.destroy');

    Route::get('/boletas/{boleta}/pdf', [BoletaController::class, 'generatePdf'])->name('boletas.pdf');

    Route::get('/orden-trabajo/create', [OrdenTrabajoController::class, 'create'])->name('orden_trabajo.create');
    Route::post('/orden-trabajo', [OrdenTrabajoController::class, 'store'])->name('orden_trabajo.store');
    Route::get('/orden-trabajo', [OrdenTrabajoController::class, 'index'])->name('orden_trabajo.index');
    Route::put('/orden_trabajo/{id}/cambiar-estado', [OrdenTrabajoController::class, 'cambiarEstado'])
        ->name('orden_trabajo.cambiarEstado');


    Route::get('/orden-trabajo/{id}/pdf', [OrdenTrabajoController::class, 'generarPDF'])->name('orden_trabajo.pdf');
    Route::get('/orden-trabajo/reporte', [OrdenTrabajoController::class, 'reporte'])->name('orden_trabajo.reporte');
    Route::get('/ordenes-trabajo/reporte/exportar-pdf', [OrdenTrabajoController::class, 'exportarReportePDF'])->name('orden_trabajo.exportar_pdf');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
});

require __DIR__.'/auth.php';
