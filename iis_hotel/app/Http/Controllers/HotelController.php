<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use mysql_xdevapi\Table;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller {
    public function index() {

    }

    public static function get_searched($loc_pos) {
        $by_hotel = Hotel::where('oznaceni', 'like', "%$loc_pos%");

        return DB::table('hotels')->join('addresses', function ($join) {
            $join->on('addresses.id', '=', 'hotels.address_id');
        })
            ->where('addresses.mesto', 'like', "%$loc_pos%")
            ->select('hotels.*')
            ->union($by_hotel)
            ->get();
    }
}
