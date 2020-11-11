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
        return view('profile.index');
    }

    public function edit_name() {
        return view('profile.edit.name');
    }

    public function edit_role() {
        return view('profile.edit.role');
    }

    public function edit_password() {
        return view('profile.edit.password');
    }

    public function update_name() {
        $id = Auth::id();
        $user = User::findOrFail($id);

        $user->name = request('name');

        $user->save();

        return redirect('/profile');
    }

    public function update_role() {
        $id = Auth::id();
        $user = User::findOrFail($id);

        $user->user_role = request('user_role');

        $user->save();

        return redirect('/profile');
    }

    public function update_password() {
        return redirect('/profile');
    }
}
