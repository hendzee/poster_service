<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /** Destroy notification by id */
    public function destroy($id) {
        try {
            Notification::destroy($id);

            return $this->simpleResponse($id, 'Notification was removed');
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);      
            }
            return $this->simpleErrorResponse();
        }
    }
}
