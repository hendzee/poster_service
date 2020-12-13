<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use DB;

class Controller extends BaseController
{
    /** Pagination response */
    public function paginationResponse($data) {
        return response()->json($data, 200);
    }

    /** Simple response (with message) */
    public function simpleResponse($data, $message='Successful') {
        $finalData['data'] = $data;
        $finalData['message'] = $message;

        return response()->json($finalData, 200);
    }

    /** Simple error response */
    public function simpleErrorResponse($message='Something went wrong, please refresh again.', $errorCode=500) {
        $response['error'] = 'Error';
        $response['message'] = $message;

        return response()->json($response, $errorCode);
    }

    /** Error response database */
    public function getDatabaseErrorResponse($dbErrorCode, $errorMessage) {
        $message = 'Something went wrong';
        $errorCode = 500;

        switch ($dbErrorCode) {
            // Required data not filled
            case 1048:
                $message = $errorMessage;
                break;
            
            // Data was redundant
            case 1062:
                $message = 'Data was exist (redundant)';
                break;
            
            // References data not found on table
            case 1452:
                $message = 'Error references data, please contact the admin';
                break;
            
            default:
                $message = "Error with code $dbErrorCode";
                break;
        }

        $response['error'] = 'Error';
        $response['message'] = $message;

        return response()->json($response, $errorCode);
    }
}
