<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantillaPregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'plantilla_id',
        'pregunta_id',
        'orden',
    ];

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}
