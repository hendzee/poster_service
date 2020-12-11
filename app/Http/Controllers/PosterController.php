<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use DB;

class PosterController extends Controller
{
    private $numPage = 5;

    /** Get all data poster by country */
    public function index(Request $request) {
        try {
            $country = $request->country;
            $posters = Poster::where('country', strtoupper($country));

            /** If has category filter */
            if ($request->has('category')) {
                $posters = $posters->where('category', strtoupper($request->category));
            }
            
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
        $country = $request->country;

        $posters = DB::table('posters')
            ->rightJoin('subscribers', 'subscribers.poster', '=', 'posters.id')
            ->select('subscribers.poster', DB::raw('COUNT(subscribers.subscriber) AS total_subscriber'))
            ->groupBy('subscribers.poster')
            ->orderBy('total_subscriber', 'DESC')
            ->first();

        $trendingPoster = Poster::find($posters->poster);
        
        return $this->simpleResponse($trendingPoster);
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
            $poster = Poster::find($id);

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