<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(){

    }
    public static function get_searched($loc_pos){
        return Hotel::where('oznaceni', 'like', "%$loc_pos%")->get();
    }
}
