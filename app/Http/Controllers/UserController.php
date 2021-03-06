<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

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
            $userPosters = DB::table('posters')
                ->join('users', 'posters.owner', '=', 'users.id') 
                ->where('users.id', $request->id);
            
            $userPosters->select('posters.*', 'users.photo as photo');

            $userPosters = $userPosters->paginate($this->numPage);
        
            return $this->paginationResponse($userPosters);
        } catch (\Throwable $th) {
            return $th;
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleErrorResponse();
        }
    }


    /** Get user subcription */
    public function getUserSubscription(Request $request) {
        $subscribers = DB::table('posters')
            ->join('users', 'posters.owner', '=', 'users.id')
            ->join('subscribers', 'posters.id', '=', 'subscribers.poster')
            ->where('subscribers.subscriber', $request->id);
        
        $subscribers->select('posters.*', 'users.photo as photo');
        $subscribers = $subscribers->paginate($this->numPage);

        return $this->paginationResponse($subscribers);   
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
          
                    $path = $request->file('photo')->storeAs('images/profiles', $imageName);
                }
    
                $user->photo = env('APP_URL') . '/storage/app/images/profiles/' . $imageName;
                
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
            return $this->simpleErrorResponse();
        }
    }
}