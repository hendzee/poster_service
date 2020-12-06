<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /** Simple response */
    public function getResponse($data) {
        return response()->json($data, 200);
    }

    /** Simple response with message */
    public function getResponseWithMessage($data, $message) {
        $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($data, 200);
    }

    /** Simple error response */
    public function getErrorResponse($message, $errorCode) {
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
                $message = 'Data was redundant';
                break;
            
            default:
                break;
        }

        $response['message'] = $message;

        return response()->json($response, $errorCode);
    }
}
