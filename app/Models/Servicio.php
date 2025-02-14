<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Boleta;
use App\Models\OrdenTrabajo;

class Servicio extends Model
{


    protected $fillable = ['nombre', 'precio'];

    public function boletas()
    {
        return $this->hasMany(Boleta::class);
    }

    public function ordenTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class);
    }
}
