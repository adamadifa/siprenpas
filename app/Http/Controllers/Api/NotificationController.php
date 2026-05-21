<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Store a push subscription.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $subscription = PushSubscription::updateOrCreate(
            ['endpoint' => $request->endpoint],
            [
                'user_id' => Auth::id(),
                'public_key' => $request->keys['p256dh'],
                'auth_token' => $request->keys['auth']
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscribed successfully',
            'data' => $subscription
        ]);
    }

    /**
     * Remove a push subscription.
     */
    public function unsubscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string|url',
        ]);

        PushSubscription::where('endpoint', $request->endpoint)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unsubscribed successfully'
        ]);
    }
}
