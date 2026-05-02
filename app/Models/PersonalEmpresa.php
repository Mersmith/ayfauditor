<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalEmpresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'empresa_id',
        'personal_id',
        'cargo_id',
        'activo',
    ];

    /**
     * Pertenece a una empresa específica.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Pertenece a un perfil de personal específico.
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class);
    }

    /**
     * El personal tiene un cargo específico dentro de esa empresa.
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }
}
