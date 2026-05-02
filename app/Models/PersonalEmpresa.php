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
        'cargo',
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
}
