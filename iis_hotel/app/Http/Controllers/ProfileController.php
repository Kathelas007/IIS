<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    private function getUser($id) {
        if($id == NULL || !(Auth::user()->isAtLeast(User::role_admin))) {
            return Auth::user();
        } else{
            return User::findOrFail($id);
        }
    }

    private function getData($id) {
        return [
            'user' => $this->getUser($id),
        ];
    }

    public function index() {

        if (! (Auth::user()->isAtLeast(User::role_admin))){
            return redirect('home');
        }

        $users = User::all();

        $data = [
            'users' => $users,
        ];
        return view('profile.index', $data);
    }

    public function show($id = NULL) {
        return view('profile.show', $this->getData($id));
    }

    public function edit_firstname($id = NULL) {
        return view('profile.edit.firstname', $this->getData($id));
    }

    public function edit_lastname($id = NULL) {
        return view('profile.edit.lastname', $this->getData($id));
    }

    public function edit_email($id = NULL) {
        return view('profile.edit.email', $this->getData($id));
    }

    public function edit_role($id = NULL) {
        return view('profile.edit.role', $this->getData($id));
    }

    public function edit_password() {
        return view('profile.edit.password');
    }

    public function update_firstname(Request $request, $id = NULL) {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
        ]);

        $user = $this->getUser($id);

        $user->firstname = request('firstname');

        $user->save();

        return redirect('/profile/'.$id);
    }


    public function update_lastname(Request $request, $id = NULL) {
        $request->validate([
            'lastname' => ['required', 'string', 'max:255'],
        ]);

        $user = $this->getUser($id);

        $user->lastname = request('lastname');

        $user->save();

        return redirect('/profile/'.$id);
    }

    public function update_email(Request $request, $id = NULL) {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = $this->getUser($id);

        $user->email = request('email');

        $user->save();

        return redirect('/profile/'.$id);
    }

    public function update_role($id = NULL) {
        $user = $this->getUser($id);

        $user->role = request('role');

        $user->save();

        return redirect('/profile/'.$id);
    }

    public function update_password(Request $request) {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        if(Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);

            $user->save();

            return redirect('/profile');
        }

        $errors = [
            'old_password' => 'This password does not match our records.',
        ];
        return redirect()->back()->withErrors($errors);
    }

    public function destroy($id) {

        if (! (Auth::user()->isAtLeast(User::role_admin))){
            return redirect('home');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect('home');
    }
}
