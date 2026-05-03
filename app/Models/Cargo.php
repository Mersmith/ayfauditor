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
        'slug',
        'tipo',
        'descripcion',
        'color',
        'icono',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con los participantes de auditoría (cuando el cargo actúa como rol en una auditoría).
     */
    public function participantesAuditoria()
    {
        return $this->hasMany(ParticipanteAuditoria::class, 'cargo_id');
    }

    /**
     * Relación con los trabajadores (cuando el cargo es su puesto administrativo).
     */
    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class, 'cargo_id');
    }
}
