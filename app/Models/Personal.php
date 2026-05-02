<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre',
        'dni',
        'celular',
    ];

    /**
     * Un perfil de personal pertenece a un único usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Las empresas para las que trabaja este personal.
     */
    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'personal_empresas')
            ->withPivot('cargo', 'activo')
            ->withTimestamps();
    }

    /**
     * Relación directa con la tabla pivote.
     */
    public function personalEmpresas(): HasMany
    {
        return $this->hasMany(PersonalEmpresa::class);
    }
}
