<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_publicacion',
        'es_obligatorio',
    ];

    protected $casts = [
        'es_obligatorio' => 'boolean',
        'fecha_publicacion' => 'date',
    ];

    // Opcional: agregar scope para temas obligatorios
    public function scopeObligatorios($query)
    {
        return $query->where('es_obligatorio', true);
    }
}