<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioRespuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'respuesta_id',
        'user_id',
        'mensaje',
        'leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
