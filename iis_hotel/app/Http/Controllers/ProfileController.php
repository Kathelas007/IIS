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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
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

    public function update_password(Request $request) {
        $this->validator($request->all())->validate();

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
