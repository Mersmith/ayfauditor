<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auditoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'empresa_id',
        'plantilla_id',
        'titulo',
        'estado_auditoria_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoAuditoria::class, 'estado_auditoria_id');
    }

    public function participantes()
    {
        return $this->hasMany(ParticipanteAuditoria::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}
