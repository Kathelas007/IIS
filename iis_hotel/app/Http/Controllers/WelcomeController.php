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

    public function search(Request $request) {
        $request->validate(['query' => 'required|min:3']);

        $query = $request->input('query');
        $hotels = HotelController::get_search_paginator($query);
        $start_date = $request->input('query_in');
        $end_date = $request->input('query_out');

        return view('welcome.search', compact('hotels', 'start_date', 'end_date'));
    }

}
