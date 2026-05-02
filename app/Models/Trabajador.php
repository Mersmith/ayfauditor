<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajador extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre',
        'dni',
        'especialidad_id',
        'cargo_id',
        'registro_profesional',
    ];

    /**
     * Un trabajador pertenece a un único usuario de login.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * El trabajador tiene una especialidad técnica.
     */
    public function especialidad(): BelongsTo
    {
        return $this->belongsTo(Especialidad::class);
    }

    /**
     * El trabajador tiene un cargo en el staff interno.
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }
}
