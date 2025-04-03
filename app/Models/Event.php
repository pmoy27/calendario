<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $fillable = ['titulo', 'fecha_inicio', 'fecha_fin', 'user_id', 'tipo_id', 'telefono', 'hora_inicio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
}
