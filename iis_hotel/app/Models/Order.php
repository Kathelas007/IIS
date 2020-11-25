<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Order extends Model {
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

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function rooms() {
        return $this->belongsToMany('App\Models\Room');
    }

    public function create_binding_table_rows($order_id, $rooms) {
        foreach ($rooms as $room) {
            DB::table('order_room')->insert([
                'room_id' => $room->id,
                'order_id' => $order_id,
            ]);
        }
    }

    public static function totalCount($room_types) {
        $total = 0;
        foreach ($room_types as $room_type) {
            $total += $room_type['count'];
        }
        return $total;
    }

    public static function totalPrice($room_types) {
        $total = 0;
        foreach ($room_types as $room_type) {
            $total += $room_type['count'] * $room_type['type']->price;
        }
        return $total;
    }
}
