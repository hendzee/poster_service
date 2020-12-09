<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    private $numPage = 5;

    /** Get all data user */
    public function index(Request $request) {
        try {
            $users = User::paginate($this->numPage);
            return $this->paginationResponse($users);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleResponseError();
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
    
            return $this->simpleResponse($user);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleResponseError();
        }
    }

    /** Update data user */
    public function update(Request $request, $id) {
        try {
            $user = User::find($id);

            if (!$user) {
                return $this->simpleErrorResponse('User not found on database', 500);
            }

            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->photo = $request->photo;
            $user->country = $request->country;
            $user->save();

            return $this->simpleResponse($user, 'Data user was updated');   
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleResponseError();
        }
    }
}