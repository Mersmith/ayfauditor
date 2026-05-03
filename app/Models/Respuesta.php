<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Respuesta extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'auditoria_id',
        'pregunta_id',
        'respuesta_cliente',
        'estado_respuesta_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function auditoria()
    {
        return $this->belongsTo(Auditoria::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoRespuesta::class, 'estado_respuesta_id');
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioRespuesta::class);
    }
}
