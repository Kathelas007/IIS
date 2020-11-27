<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HotelController;

class WelcomeController extends Controller
{
    public function index() {
        return view('welcome.index');
    }

    public function search(Request $request) {

        $query = $request->input('query');
        $start_date = $request->input('query_in');
        $end_date = $request->input('query_out');

        $hotels = HotelController::get_search_paginator($query, $start_date, $end_date);

        return view('welcome.search', compact('hotels', 'start_date', 'end_date'));
    }

}
