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
            
            return $this->simpleErrorResponse();
        }
    }

    /** Get user's poster */
    public function getUserPoster(Request $request) {
        try {
            $user = User::where('id', $request->id)->first(); // id is user id
            $userPosters = $user->posters()
                ->with('user')
                ->paginate($this->numPage);
        
            return $this->paginationResponse($userPosters);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleErrorResponse();
        }
    }


    /** Get user subcription */
    public function getUserSubscription(Request $request) {
        $user = User::find($request->id); // id is user id

        $subscriptions = $user->subscribers()
            ->with('user')
            ->paginate($this->numPage);

        return $this->paginationResponse($subscriptions);   
    }

    /** Get user notification */
    public function getUserNotification(Request $request) {
        try {
            $user = User::find($request->id); // id is user id

            $notifications = $user->notifications()->paginate($this->numPage);

            return $this->paginationResponse($notifications);

        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleErrorResponse();
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
            
            return $this->simpleErrorResponse();
        }
    }

    /** Update data user */
    public function update(Request $request, $id) {
        try {
            $user = User::find($id);

            if (!$user) {
                return $this->simpleErrorResponse('User not found on database', 500);
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('phone')) {
                $user->phone = $request->phone;
            }

            if ($request->has('password')) {
                $user->password = $request->password;
            }

            if ($request->has('first_name')) {
                $user->first_name = $request->first_name;
            }

            if ($request->has('last_name')) {
                $user->last_name = $request->last_name;
            }

            if ($request->has('photo')) {
                $this->validate($request, [
                    'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048'
                ]);

                $imageName = '';

                if ($request->file('photo')) {
                    $imagePath = $request->file('photo');
                    $imageName = $request->user_id . time() . $imagePath->getClientOriginalName();
          
                    $path = $request->file('photo')->storeAs('images', $imageName);
                }
    
                $user->photo = env('APP_URL') . '/storage/app/images/' . $imageName;
                
            }
            
            if ($request->has('country')) {
                $user->country = $request->country;
            }
            
            $user->save();

            return $this->simpleResponse($user, 'Data user was updated');   
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            return $th;
            // return $this->simpleErrorResponse();
        }
    }
}