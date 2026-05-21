<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:push-subscriptions.index', ['only' => ['index', 'test']]);
        $this->middleware('permission:push-subscriptions.destroy', ['only' => ['destroy']]);
    }

    /**
     * Send a test notification to a specific subscription.
     */
    public function test(PushSubscription $pushSubscription)
    {
        try {
            $pushService = new \App\Services\PushNotificationService();
            $success = $pushService->notifyOne(
                $pushSubscription,
                'Test Notifikasi',
                'Halo! Ini adalah notifikasi uji coba dari sistem Siprenpas.',
                '/dashboard'
            );

            if ($success) {
                return redirect()->back()->with('success', 'Notifikasi tes berhasil dikirim!');
            } else {
                return redirect()->back()->with('error', 'Gagal mengirim notifikasi tes. Kemungkinan token sudah tidak valid.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of the push subscriptions.
     */
    public function index()
    {
        $subscriptions = PushSubscription::with('user')->orderBy('created_at', 'desc')->get();
        return view('push_subscriptions.index', compact('subscriptions'));
    }

    /**
     * Remove the specified subscription.
     */
    public function destroy(PushSubscription $pushSubscription)
    {
        try {
            $pushSubscription->delete();
            return redirect()->route('push-subscriptions.index')->with('success', 'Subscription berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus subscription');
        }
    }
}
