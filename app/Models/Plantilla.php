<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantilla extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function preguntas()
    {
        return $this->belongsToMany(Pregunta::class, 'plantilla_preguntas')
                    ->withPivot('orden')
                    ->withTimestamps()
                    ->orderBy('pivot_orden');
    }
}
