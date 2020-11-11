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

    private function getUser($id) {
        if($id == NULL) {
            return Auth::user();
        } else {
            return User::findOrFail($id);
        }
    }

    private function getData($id) {
        return [
            'user' => $this->getUser($id),
        ];
    }

    public function index($id = NULL) {
        return view('profile.index', $this->getData($id));
    }

    public function edit_name($id = NULL) {
        return view('profile.edit.name', $this->getData($id));
    }

    public function edit_role($id = NULL) {
        return view('profile.edit.role', $this->getData($id));
    }

    public function edit_password() {
        return view('profile.edit.password');
    }

    public function update_name($id = NULL) {
        $user = $this->getUser($id);

        $user->name = request('name');

        $user->save();

        return redirect('/profile/'.$id);
    }

    public function update_role($id = NULL) {
        $user = $this->getUser($id);

        $user->role = request('role');

        $user->save();

        return redirect('/profile/'.$id);
    }

    public function update_password() {
        return redirect('/profile');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('home');
    }
}
