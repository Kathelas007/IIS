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
        $hotels = HotelController::get_search_paginator($query);

        return view('welcome.search',  compact('hotels'));
    }

    public function show($id){
        return view('welcome.show');
    }


}
