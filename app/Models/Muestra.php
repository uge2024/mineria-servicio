<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Boleta;


class Muestra extends Model
{
    protected $fillable = [
        'boleta_id', 'codigo', 'caracteristicas_muestra', 'municipio', 'lugar_especifico', 'tipo_material'
    ];

    public function boleta()
    {
        return $this->belongsTo(Boleta::class);
    }
}
