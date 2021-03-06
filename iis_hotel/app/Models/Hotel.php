<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'oznaceni',
        'popis',
        'image',

        'ulice',
        'c_popisne',
        'mesto',
        'PSC',
        'stat'
    ];
}
