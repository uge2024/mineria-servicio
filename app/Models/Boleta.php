<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Servicio;
use App\Models\Muestra;


class Boleta extends Model
{

    protected $fillable = [
        'servicio_id',
        'nombre_solicitante',
        'ci',
        'sector',
        'fecha_solicitud',
        'numero_contrato',
        'numero_solicitud',
        //'caracteristicas_muestra',
        //'peso',
        //'municipio',
        //'lugar_especifico',
        //'tipo_material',
        'observaciones'
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function muestras()
    {
        return $this->hasMany(Muestra::class);
    }
}
