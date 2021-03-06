<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function signup(Request $request) {
        try {
            $user = User::where('email', $request->email)->first();

            // If emal already exist
            if ($user) {
                return $this->simpleErrorResponse('Email already exist');
            }else {
                $newUser = new User;
                $newUser->first_name = $request->first_name;
                $newUser->last_name = $request->last_name;
                $newUser->email = $request->email;
                $newUser->password = $request->password;
                $newUser->save();

                // Create new token for new user
                $token = $newUser->createToken('Poster App Password Grant Client')->accessToken;
                $data['token'] = $token;
                $data['user'] = $newUser;

                return $this->simpleResponse($data);
            }
        } catch (\Throwable $th) {
            return ($th);
            
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }

            return $this->simpleErrorResponse();
        }
    }

    public function login(Request $request) {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                if (strcmp($user->password, $request->password) == 0) {
                    $token = $user->createToken('Poster App Password Grant Client')->accessToken;
                    $data['token'] = $token;
                    $data['user'] = $user;

                    return $this->simpleResponse($data);
                }else {
                    return $this->simpleErrorResponse('Password incorect');
                }
            }

            return $this->simpleErrorResponse('User not registered');
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }

            return $this->simpleErrorResponse();
        }
    }
}
