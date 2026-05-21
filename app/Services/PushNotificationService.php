<?php

namespace App\Services;

use App\Models\PushSubscription;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationService
{
    protected $webPush;

    public function __construct()
    {
        $auth = [
            'VAPID' => [
                'subject' => 'mailto:admin@alamin.com',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $this->webPush = new WebPush($auth);
    }

    /**
     * Send push notification to a single subscriber
     */
    public function notifyOne(PushSubscription $sub, $title, $body, $url = '/')
    {
        $this->webPush->queueNotification(
            Subscription::create([
                'endpoint' => $sub->endpoint,
                'publicKey' => $sub->public_key,
                'authToken' => $sub->auth_token,
            ]),
            json_encode([
                'title' => $title,
                'body' => $body,
                'url' => $url
            ])
        );

        foreach ($this->webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                if ($report->isSubscriptionExpired()) {
                    $sub->delete();
                }
                return false;
            }
        }
        return true;
    }

    /**
     * Send push notification to all subscribers
     */
    public function notifyAll($title, $body, $url = '/')
    {
        $subscriptions = PushSubscription::all();

        foreach ($subscriptions as $sub) {
            $this->webPush->queueNotification(
                Subscription::create([
                    'endpoint' => $sub->endpoint,
                    'publicKey' => $sub->public_key,
                    'authToken' => $sub->auth_token,
                ]),
                json_encode([
                    'title' => $title,
                    'body' => $body,
                    'url' => $url
                ])
            );
        }

        foreach ($this->webPush->flush() as $report) {
            $endpoint = $report->getEndpoint();
            if (!$report->isSuccess()) {
                if ($report->isSubscriptionExpired()) {
                    PushSubscription::where('endpoint', $endpoint)->delete();
                }
                \Log::error("Message failed to sent for subscription {$endpoint}: {$report->getReason()}");
            }
        }
    }
}
