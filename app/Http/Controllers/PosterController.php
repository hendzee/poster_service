<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;

class PosterController extends Controller
{
    /** Get all data poster */
    public function index(Request $request) {
        $poster = Poster::all();

        if ($request->has('country')) {
            $poster = Poster::where('country', $request->country)
            ->paginate(6);
        }

        return $poster;
    }
}
