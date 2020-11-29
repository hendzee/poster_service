<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** Get all data user */
    public function index(Request $request) {
        $user = User::all();

        return $user;
    }

    /** Store data user */
    public function store(Request $request) {
        $user = new User;

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->photo = $request->photo;
        $user->country = $request->country;
    }

    /** Update data user */
    public function update(Request $request, $id) {
        $user = User::find($id);
    }
}
