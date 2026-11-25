<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validateWithBag('newsletter', [
            'email' => ['required', 'string', 'email:filter', 'max:254'],
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Please agree to receive JPL newsletter updates.',
        ]);

        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => mb_strtolower(trim($data['email']))],
            ['consented_at' => now()]
        );

        if (!$subscriber->wasRecentlyCreated) {
            return back()
                ->withInput(['email' => $subscriber->email])
                ->with('newsletter_status', 'This email is already subscribed to JPL updates.');
        }

        return back()->with('newsletter_status', "You're subscribed to JPL updates. Thank you!");
    }
}
