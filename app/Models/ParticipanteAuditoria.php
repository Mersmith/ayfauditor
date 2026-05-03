<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipanteAuditoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'auditoria_id',
        'user_id',
        'rol_auditoria_id',
        'invitado_por',
    ];

    public function auditoria()
    {
        return $this->belongsTo(Auditoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rol()
    {
        return $this->belongsTo(RolAuditoria::class, 'rol_auditoria_id');
    }

    public function invitadoPor()
    {
        return $this->belongsTo(User::class, 'invitado_por');
    }
}
