<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'icono',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con el personal asignado a este cargo en una empresa.
     */
    public function personalEmpresas()
    {
        return $this->hasMany(PersonalEmpresa::class);
    }

    /**
     * Relación directa con el staff interno.
     */
    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class);
    }
}
