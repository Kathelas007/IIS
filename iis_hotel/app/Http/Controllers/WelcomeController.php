<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HotelController;

class WelcomeController extends Controller
{
//  TODO seeds

    public function index() {
        return view('welcome.index');
    }

    public function search(Request $request){
        $request->validate(['query' => 'required|min:3']);

        $query = $request->input('query');
        $result = HotelController::get_searched($query);

        return view('welcome.search',  ['hotel_results' => $result]);
    }
}
