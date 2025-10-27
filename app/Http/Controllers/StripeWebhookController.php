<?php

namespace App\Http\Controllers;

use App\Models\Dedication;
use App\Mail\AdminNotification;
use App\Mail\DonorReceipt;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Read raw payload
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        // 2. Verify Stripe signature
        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $secret
            );
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe Signature Error: '.$e->getMessage());
            return response('Invalid signature', 400);
        }

        Log::info('Stripe webhook received', ['event' => $event->type]);

        // 3. Handle only payment_intent.succeeded for now
        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $metadata = $intent->metadata ?? [];
            $orderId = $intent->id ?? null;

            // Find the dedication
            $dedication = null;
            if (!empty($metadata->dedication_id)) {
                $dedication = Dedication::find($metadata->dedication_id);
            } elseif (!empty($metadata->email)) {
                $dedication = Dedication::where('email', $metadata->email)->latest()->first();
            }

            if ($dedication) {
                $dedication->status = 'paid';
                $dedication->order_id = $orderId;
                $dedication->save();

                // Send emails
                try {
                    Mail::to('sarah.geonta@gmail.com')->send(new AdminNotification($dedication, $intent));
                    Mail::to($dedication->email)->send(new DonorReceipt($dedication, $intent));
                } catch (\Exception $e) {
                    Log::error('Mail send failed for dedication '.$dedication->id.': '.$e->getMessage());
                }
            } else {
                Log::warning('Dedication not found for Stripe intent: ' . json_encode($metadata));
            }
        }

        return response()->json(['received' => true]);
    }
}
