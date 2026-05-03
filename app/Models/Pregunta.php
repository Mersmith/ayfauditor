<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pregunta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'orden_sugerido',
        'texto',
        'categoria_pregunta_id',
        'descripcion_ayuda',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaPregunta::class, 'categoria_pregunta_id');
    }

    public function plantillas()
    {
        return $this->belongsToMany(Plantilla::class, 'plantilla_preguntas')
                    ->withPivot('orden')
                    ->withTimestamps();
    }
}
