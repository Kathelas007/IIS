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
        'proceeding',
        'finished',
        'cancelled',
    ];

    protected $fillable = [

    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room');
    }
}
