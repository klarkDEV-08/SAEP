<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movimento;

class Produto extends Model
{
    protected $fillable = [
        'produto_id', 'quantidade', 'tipo'
    ];

    public function movimentos(){
        return $this->hasMany(Movimento::class);
    }
}
