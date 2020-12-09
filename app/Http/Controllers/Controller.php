<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

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
            case 1048:
                $message = $errorMessage;
                break;

            case 1062:
                $message = 'Data was exist (redundant)';
                break;
            
            default:
                break;
        }
        
        $response['error'] = 'Error';
        $response['message'] = $message;

        return response()->json($response, $errorCode);
    }
}
