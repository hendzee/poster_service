<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    // Add new subscriber
    public function store(Request $request)
    {
        try {
            $subscriber = new Subscriber;

            $searchSubscriber = Subscriber::where('subscriber', $request->subscriber_id)
                ->where('poster', $request->poster_id)
                ->first();

            if (!$searchSubscriber) {
                $subscriber->poster = $request->poster_id;
                $subscriber->subscriber = $request->subscriber_id;
                $subscriber->save();

                return $this->simpleResponse($subscriber, 'Poster was subscribed');
            } else {
                // Unsubscribe when item found
                Subscriber::destroy($searchSubscriber->id);

                return $this->simpleResponse($subscriber, 'Poster was unsubsribed');
            }
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);
            }

            return $this->simpleErrorResponse();
        }
    }

    // Check user subscribed or not
    public function exist(Request $request)
    {
        try {
            $searchSubscriber = Subscriber::where('subscriber', $request->subscriber_id)
                ->where('poster', $request->poster_id)
                ->select('id')
                ->first();

            if (!$searchSubscriber) {
                return $this->simpleResponse($searchSubscriber, 'Data not found');
            } else {
                return $this->simpleResponse($searchSubscriber, 'Data was found');
            }
        } catch (\Throwable $th) {
            if (property_exists($th, 'errorInfo')) {
                return $this->getDatabaseErrorResponse($th->errorInfo[1], $th->errorInfo[2]);
            }

            return $this->simpleErrorResponse();
        }
    }
}
