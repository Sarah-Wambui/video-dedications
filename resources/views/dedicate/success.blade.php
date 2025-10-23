@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
    <div class="p-4 success-card-wrapper">

        <!-- Green Tick Circle -->
        <div class="d-flex justify-content-center mb-4">
            <div class="rounded-circle bg-success d-flex justify-content-center align-items-center" style="width: 64px; height: 64px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-check" viewBox="0 0 16 16">
                    <path d="M13.485 1.929a.75.75 0 0 1 1.06 1.06L6.53 11.004 2.454 6.93a.75.75 0 1 1 1.06-1.06l2.916 2.917L13.485 1.93z"/>
                </svg>
            </div>
        </div>

        <div class="success-text">
            <!-- Headline -->
            <h3 class="text-center mb-2">Thank you. Your dedication is received.</h3>

            <!-- Sub-copy -->
            <p class="text-center text-muted mb-4">We’ll include it on an upcoming video and email you when it’s live.</p>
        </div>

        <!-- Details Card -->
        <div class="card shadow-sm mb-4 success-card">
            <div class="card-body text-center">
                <p><strong>Type:</strong> {{ $dedication->dedication_type ?? '-' }}</p>
                <p><strong>Honoree:</strong> {{ $dedication->honoree_name ?? '-' }}</p>
                <p><strong>Note:</strong> {{ $dedication->short_note ?? '-' }}</p>
                <p><strong>Receipt #:</strong> {{ $orderId ?? ($dedication->order_id ?? '-') }}</p>

                <div class="mt-3">
                    <button id="copy-share" class="btn-copy btn-custom">Copy share text</button>
                </div>

                <div class="mt-4 d-flex gap-2 justify-content-center">
                    <a href="{{ route('dedicate.details') }}" class="btn-add btn-custom">Add another dedication</a>
                    <a href="/" class="btn-home btn-custom d-flex align-items-center" aria-label="Return to Home">
                        <!-- Home SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <path d="M3 9.5L12 3l9 6.5"></path>
                            <path d="M9 22V12h6v10"></path>
                        </svg>
                        Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy Share Text Script -->
<script>
    document.getElementById('copy-share').addEventListener('click', function() {
        const text = `
Dedication Type: {{ $dedication->dedication_type ?? '-' }}
Honoree: {{ $dedication->honoree_name ?? '-' }}
Note: {{ $dedication->short_note ?? '-' }}
Receipt #: {{ $orderId ?? ($dedication->order_id ?? '-') }}
        `.trim();

        navigator.clipboard.writeText(text).then(() => {
            alert('Share text copied to clipboard!');
        });
    });
</script>
@endsection
