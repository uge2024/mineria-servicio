<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Boleta;

class Servicio extends Model
{


    protected $fillable = ['nombre', 'precio'];

    public function boletas()
    {
        return $this->hasMany(Boleta::class);
    }
}
