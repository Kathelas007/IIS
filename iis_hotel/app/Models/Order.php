<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const states = [
        'filed',
        'accepted',
        'confirmed',
        'proceeding',
        'finished'
    ];
}
