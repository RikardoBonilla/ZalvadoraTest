<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class PlanModel extends Model
{
    protected $table = 'plans';
    protected $guarded = []; // O usa $fillable según prefieras

    protected $casts = [
        'features' => 'array', // Convierte el JSON a array automáticamente
    ];
}