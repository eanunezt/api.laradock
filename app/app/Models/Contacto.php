<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'observacion',
        'municipioResidencia',
        'departamentoResidencia',
        'estado',
        'nomReferencia',
        'codReferencia'
    ];
}
