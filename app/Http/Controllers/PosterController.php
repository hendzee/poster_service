<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;

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
            
            return $this->simpleResponseError();
        }
    }
}