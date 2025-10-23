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

        // store draft
        $dedication = Dedication::create(array_merge($data, [
            'status' => 'pending_payment',
            'amount_cents' => 18000,
            'metadata' => $data,
        ]));

        // In a real integration, create a Stripe PaymentIntent and return client secret
        // For now, send user to payment page with dedication id
        return redirect()->route('dedicate.payment', ['dedication' => $dedication->id]);
    }

    public function payment(Dedication $dedication)
    {
        // Page 3: show summary and payment element
        return view('dedicate.payment', compact('dedication'));
    }

    public function success(Request $request)
    {
        // Page 4: show thank-you
        $orderId = $request->query('ref');
        $dedication = Dedication::where('order_id', $orderId)->first();
        return view('dedicate.success', compact('dedication', 'orderId'));
    }
}
