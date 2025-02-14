<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Boleta;
use App\Models\Servicio;

class OrdenTrabajo extends Model
{
    
    protected $table = 'orden_trabajos'; // Especifica el nombre de la tabla


    // Campos que se pueden asignar masivamente
        protected $fillable = [
        'boleta_id',
        'servicio_id',
        'cantidad_muestras',
        'costo_total',
        'estado_pago',
        ];


    public function boleta()
    {
        return $this->belongsTo(Boleta::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
