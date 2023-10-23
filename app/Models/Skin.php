<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skin extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", 
        "types",
        "price",
        "color",
        "category",
        "design_pattern",
        "rarity",
    ];

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
