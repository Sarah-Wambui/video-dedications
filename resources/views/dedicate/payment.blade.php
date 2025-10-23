@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold">Payment</h2>

        <div class="mt-4 p-4 border rounded">
            <h3 class="font-medium">Summary</h3>
            <p>Type: {{ $dedication->dedication_type }} {{ $dedication->other_type ? ' - '.$dedication->other_type : '' }}</p>
            <p>Honoree: {{ $dedication->honoree_name }}</p>
            <p>Note: {{ $dedication->short_note }}</p>
            <p class="mt-2 font-semibold">Pay $180</p>
        </div>

        <div class="mt-6">
            <!-- Stripe Payment integration goes here. Create PaymentIntent on backend and mount Stripe Elements. -->
            <p class="text-sm text-gray-600">(Stripe payment integration placeholder)</p>
        </div>
    </div>
</div>
@endsection
