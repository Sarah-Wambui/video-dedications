@extends('layouts.app')

@section('content')
<div class="container py-5 payment-page">
    <div class="payment-box shadow-sm p-4 rounded bg-white">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>Credit Card</h2>
        </div>
        <img src="/assets/uploads/card_types.png" alt="Cards" style="height: 30px;">
    </div>

    <hr>

    <!-- Card Details -->
    <h6 class="mb-3">Card Details</h6>
    <div class="d-flex align-items-center mb-2 text-success" style="font-size: 14px;">
        <i class="bi bi-lock-fill me-1"></i> Secure 128-bit SSL
    </div>

    <div class="card-input border rounded p-3 mb-4 bg-light">
        <!-- Stripe Payment Element will go here -->
        <div id="payment-element" class="w-100"></div>
    </div>

    <!-- Summary -->
    <h6 class="mb-3">Summary</h6>
    <div class="summary-row d-flex justify-content-between">
        <span>Dedication Type</span>
        <span>{{ $dedication->dedication_type }}</span>
    </div>
    <div class="summary-row d-flex justify-content-between">
        <span>Honoring:</span>
        <span>{{ $dedication->honoree_name }}</span>
    </div>
    <div class="summary-row d-flex justify-content-between">
        <span>Message:</span>
        <span>{{ $dedication->short_note }}</span>
    </div>
    <div class="summary-row d-flex justify-content-between">
        <strong>Total</strong>
        <strong>$180</strong>
    </div>

    <!-- Button -->
    <button type="button" class="btn btn-teal w-100 mt-4 py-3" id="pay-btn">
        Confirm and Pay
    </button>

    <div id="payment-message" class="small text-danger mt-2" style="display:none;"></div>

</div>

</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const stripe = Stripe("{{ config('services.stripe.key') }}");

    const options = {
        clientSecret: "{{ $clientSecret }}",
        appearance: { theme: 'flat' }
    };

    const elements = stripe.elements(options);
    const paymentElement = elements.create("payment");
    paymentElement.mount("#payment-element");

    const form = document.getElementById("payment-form");
    const payBtn = document.getElementById("pay-btn");
    const messageEl = document.getElementById("payment-message");

    elements.on('ready', () => {
        payBtn.disabled = false;
    });

    payBtn.addEventListener("click", async () => {
        payBtn.disabled = true;
        payBtn.innerText = "Processing...";

        const result = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: "{{ route('dedicate.success') }}?ref={{ $dedication->order_id }}"
            },
            redirect: "if_required" // 🔥 IMPORTANT
        });

        if (result.error) {
            // ❌ PAYMENT FAILED → Show Bootstrap tooltip
            const tooltip = new bootstrap.Tooltip(payBtn, {
                title: result.error.message || "Payment failed. Try again.",
                trigger: 'manual'
            });
            tooltip.show();

            messageEl.style.display = 'block';
            messageEl.innerText = result.error.message;

            payBtn.disabled = false;
            payBtn.innerHTML = "Confirm and Pay";

            // auto-hide tooltip
            setTimeout(() => tooltip.hide(), 4000);
            return;
        }

        // ✅ NO ERROR → Payment Completed (or will redirect if 3DS is needed)
        if (result.paymentIntent && result.paymentIntent.status === "succeeded") {

            payBtn.innerText = "Processing Payment..."; // nicer text

            setTimeout(() => {
                window.location.href = "{{ route('dedicate.success') }}?ref={{ $dedication->order_id }}";
            }, 5000); // 5 second delay
        }

    });
});
</script>
@endsection

