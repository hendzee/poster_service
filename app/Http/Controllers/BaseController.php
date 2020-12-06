<?php

namespace App\Http\BaseController;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function getResponse($data) {
        return response()->json($data, 200);
    }

    public function getErrorResponse($message, $errorCode) {
        return response()->json($data, $errorCode);
    }
}
