<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /** Get all data user */
    public function index(Request $request) {
        try {
            $user = User::all();
            
            return $this->getResponse($response);
        } catch (\Throwable $th) {
            $message = 'Failed to get data user';
            $errorCode = 500;

            return $this->getErrorResponse($message, $errorCode); 
        }
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

            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return response()->json($th, 500);
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