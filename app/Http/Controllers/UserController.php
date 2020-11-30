<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** Get all data user */
    public function index(Request $request) {
        try {
            $user = User::all();
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->photo = $request->photo;
            $user->country = $request->country;
            $user->save();

            return $request;
        } catch (\Throwable $th) {
            $response['message'] = 'Failed to get data user';
            
            return response()->json($response, 500); 
        }

        return $user;
    }

    /** Store data user */
    public function store(Request $request) {
        try {
            $user = new User;
    
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->photo = $request->photo;
            $user->country = $request->country;
            $user->save();
    
            return $request;
        } catch (\Throwable $th) {
            $response['message'] = 'Failed to store data';
            
            return response()->json($response, 500);
        }
    }

    /** Update data user */
    public function update(Request $request, $id) {
        try {
            $user = User::findOrFail($id);

            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->photo = $request->photo;
            $user->country = $request->country;
            $user->save();

            return $request;   
        } catch (\Throwable $th) {
            $response['message'] = 'Failed to store data';
            
            return response()->json($response, 500);
        }
    }
}
