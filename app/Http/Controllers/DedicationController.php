<?php

namespace App\Http\Controllers;

use App\Models\Dedication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DedicationController extends Controller
{
    public function landing()
    {
        return view('dedicate.landing');
    }

    public function create()
    {
        // Show details form (Page 2)
        return view('dedicate.details');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'dedication_type' => 'required|string|max:100',
            'other_type' => 'nullable|string|max:30',
            'honoree_name' => 'required|string|max:255',
            'short_note' => 'nullable|string|max:500',
            'consent_spelling' => 'accepted',
        ]);

        // normalize/trimming
        $data = array_map(function ($v) {
            return is_string($v) ? trim($v) : $v;
        }, $data);

        // Ensure checkbox/boolean values are stored as integers (DB expects tinyint)
        if (array_key_exists('consent_spelling', $data)) {
            $val = $data['consent_spelling'];
            // common values: 'on', '1', 1, true
            $data['consent_spelling'] = ($val === 'on' || $val === '1' || $val === 1 || $val === true) ? 1 : 0;
        } else {
            $data['consent_spelling'] = 0;
        }

        // If dedication type isn't Other, ensure other_type is null
        if (isset($data['dedication_type']) && $data['dedication_type'] !== 'Other') {
            $data['other_type'] = null;
        }

        // store draft
        $dedication = Dedication::create(array_merge($data, [
            'status' => 'pending_payment',
            'amount_cents' => 18000,
            'metadata' => $data,
        ]));

        // In a real integration, create a Stripe PaymentIntent and return client secret
        // For now, send user to payment page using the model so route-model-binding uses the uuid
        return redirect()->route('dedicate.payment', $dedication);
    }

    public function payment(Dedication $dedication)
    {
        // Page 3: show summary and payment element
        $clientSecret = null;

        // Try to create a PaymentIntent if stripe-php is installed and STRIPE_SECRET is set.
        try {
            if (class_exists('\Stripe\StripeClient') && config('services.stripe.secret')) {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $intent = $stripe->paymentIntents->create([
                    'amount' => $dedication->amount_cents ?? 18000,
                    'currency' => 'usd',
                    'metadata' => array_merge($dedication->metadata ?? [], ['dedication_id' => $dedication->id]),
                ]);

                Log::info('PaymentIntent created', ['dedication_id' => $dedication->id, 'intent_id' => $intent->id]);

                $clientSecret = $intent->client_secret ?? null;
            }
        } catch (\Throwable $e) {
            // Log but don't break the page; the view will show instructions to install stripe-php
            Log::warning('Stripe PaymentIntent creation failed: ' . $e->getMessage());
        }

        return view('dedicate.payment', compact('dedication', 'clientSecret'));
    }

    public function success(Request $request)
    {
        $ref = $request->query('ref');

        $dedication = Dedication::where('order_id', $ref)->firstOrFail()->fresh();
        
        return view('dedicate.success', compact('dedication'));

    }

    public function videos()
    {
        return view('dedicate.videos');
    }

}
