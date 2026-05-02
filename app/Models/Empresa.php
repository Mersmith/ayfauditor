<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    /** @use HasFactory<\Database\Factories\EmpresaFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'tipo_documento_empresa_id',
        'razon_social',
        'nombre_comercial',
        'numero_documento',
        'direccion_fiscal',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * El tipo de documento legal de la empresa.
     */
    public function tipoDocumento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumentoEmpresa::class, 'tipo_documento_empresa_id');
    }

    /**
     * Una empresa pertenece a un cliente principal.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * El personal que trabaja en esta empresa.
     */
    public function personal()
    {
        return $this->belongsToMany(Personal::class, 'personal_empresas')
            ->withPivot('cargo_id', 'activo')
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
