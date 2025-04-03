<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    public $fillable = ['nombre'];


    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
