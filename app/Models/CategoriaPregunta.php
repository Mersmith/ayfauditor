<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaPregunta extends Model
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

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
}
