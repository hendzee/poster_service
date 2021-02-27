<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use App\Models\Subscriber;
use DB;

class PosterController extends Controller
{
    private $numPage = 5;

    /** Get all data poster by country */
    public function index(Request $request) {
        try {
            $posters = DB::table('posters')
                ->join('users', 'posters.owner', '=', 'users.id');

            $country = $request->country;
            $posters->where('posters.country', $country);

            /** If has category filter */
            if ($request->has('category')) {
                $posters = $posters->where('category', $request->category);
            }
            
            $posters->select('posters.*', 'users.photo as photo');
            $posters = $posters->paginate($this->numPage);
    
            return $this->paginationResponse($posters);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleErrorResponse();
        }
    }

    /** Get trending poster */
    public function getTrendingPoster(Request $request) {
        try {
            $country = $request->country;

            $subscribers = Subscriber::all();

            if ($subscribers->isEmpty()) {
                return $this->simpleResponse($this->handleDataTrendingEmptySub());
            }

            $posters = $this->hanldeDataTrendingSub();

            $trendingPoster = Poster::with('user')->find($posters->poster);
            
            return $this->simpleResponse($trendingPoster);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            return $this->simpleErrorResponse();
        }
    }

    /** Handle data trending if subsriber 
    * table is empty */
    private function handleDataTrendingEmptySub() {
        $poster = DB::table('posters')
            ->join('users', 'posters.owner', '=', 'users.id')
            ->select('posters.*', 'users.photo as photo')
            ->first();

        return $poster;
    }

    /** Handle data trending if subscriber
    * table is NOT empty */
    private function hanldeDataTrendingSub() {
        $posters = DB::table('posters')
            ->rightJoin('subscribers', 'subscribers.poster', '=', 'posters.id')
            ->select('subscribers.poster', DB::raw('COUNT(subscribers.subscriber) AS total_subscriber'))
            ->groupBy('subscribers.poster')
            ->orderBy('total_subscriber', 'DESC')
            ->first();

        return $posters;
    }
    
    /** Get recomendation data. Currently data get by  
    * random query */
    public function getRecommendationPoster(Request $request) {
        try {
            $posters = Poster::all();
            $limit = 3; // Number of item limitation to get

            if ($posters->isEmpty()) {
                return $this->simpleResponse(null);
            }

            $poster = DB::table('posters')
                ->join('users', 'posters.owner', '=', 'users.id')
                ->where('posters.country', $request->country)
                ->inRandomOrder()
                ->limit($limit)
                ->select('posters.*', 'users.photo as photo')
                ->get();

            return $this->simpleResponse($poster);   
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }

            return $this->simpleErrorResponse();
        }
    }

    /** Store poster data */
    public function store(Request $request) {
        try {
            $poster = new Poster;

            $poster->owner = $request->owner;
            $poster->title = $request->title;
            $poster->description = $request->description;
            $poster->price = $request->price;
            $poster->country = $request->country;
            $poster->location = $request->location;
            $poster->detail_location = $request->detail_location;
            $poster->website = $request->website;
            $poster->facebook = $request->facebook;
            $poster->instagram = $request->instagram;
            $poster->twitter = $request->twitter;
            $poster->category = $request->category;
            $poster->save();

            return $this->simpleResponse($poster);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }

            return $this->simpleErrorResponse();
        }
    }

    /** Update poster data */
    public function update(Request $request, $id) {
        try {
            $poster = Poster::find($id);

            if (!$poster) {
                return $this->simpleResponse($poster, 'Data not found');
            }

            $poster->owner = $request->owner;
            $poster->title = $request->title;
            $poster->description = $request->description;
            $poster->price = $request->price;
            $poster->country = $request->country;
            $poster->location = $request->location;
            $poster->detail_location = $request->detail_location;
            $poster->website = $request->website;
            $poster->facebook = $request->facebook;
            $poster->instagram = $request->instagram;
            $poster->twitter = $request->twitter;
            $poster->category = $request->category;
            $poster->save();

            return $this->simpleResponse($poster);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }

            return $this->simpleErrorResponse();
        }
    }

    /** Show specific poster data */
    public function show($id) {
        try {
            $poster = Poster::with('user')->find($id);

            if (!$poster) {
                return $this->simpleResponse($poster, 'Data not found');
            }

            return $this->simpleResponse($poster);
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleErrorResponse();
        }
    }

    /** Delete data poster from database */
    public function destroy($id) {
        try {
            Poster::destroy($id);

            return $this->simpleResponse($id, 'Poster was removed');
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            
            return $this->simpleErrorResponse();
        }
    }
}