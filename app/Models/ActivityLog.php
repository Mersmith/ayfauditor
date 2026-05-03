<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'accion',
        'modelo_afectado_id',
        'modelo_afectado_type',
        'valor_anterior',
        'valor_nuevo',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación polimórfica para obtener el modelo que fue afectado.
     */
    public function modeloAfectado()
    {
        return $this->morphTo();
    }
}
