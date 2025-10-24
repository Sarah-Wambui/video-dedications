<?php

namespace App\Http\Controllers;

use App\Models\Dedication;
use App\Mail\AdminNotification;
use App\Mail\DonorReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Stripe webhook received', ['payload' => $request->all()]);
        
        // For now, accept JSON and look for payment_intent.succeeded
        $payload = $request->all();
        $eventType = $payload['type'] ?? null;

        if ($eventType === 'payment_intent.succeeded') {
            $intent = $payload['data']['object'] ?? [];
            $metadata = $intent['metadata'] ?? [];
            $orderId = $intent['id'] ?? null;

            // Try to find dedication by some metadata key (e.g., dedication_id or email+timestamp)
            $dedication = null;
            if (!empty($metadata['dedication_id'])) {
                $dedication = Dedication::find($metadata['dedication_id']);
            } elseif (!empty($metadata['email'])) {
                $dedication = Dedication::where('email', $metadata['email'])->latest()->first();
            }

            if ($dedication) {
                $dedication->status = 'paid';
                $dedication->order_id = $orderId;
                $dedication->save();

                // send emails
                try {
                    Mail::to('office@rivnitz.com')->send(new AdminNotification($dedication, $intent));
                    Mail::to($dedication->email)->send(new DonorReceipt($dedication, $intent));
                } catch (\Exception $e) {
                    Log::error('Mail send failed for dedication '.$dedication->id.': '.$e->getMessage());
                }
            } else {
                Log::warning('Dedication not found for Stripe intent: '.json_encode($metadata));
            }
        }

        return response()->json(['received' => true]);
    }
}
