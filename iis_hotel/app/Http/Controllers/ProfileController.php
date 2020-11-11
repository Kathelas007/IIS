<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('profile');
    }

    public function name() {
        return redirect('/');
    }

    public function password() {
        return redirect('/');
    }

    public function update() {
        $id = Auth::id();
        $user = User::findOrFail($id);

        $user->name = request('name');

        $user->save();

        return redirect('/profile');
    }
}
