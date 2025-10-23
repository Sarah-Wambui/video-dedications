@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="max-w-2xl mx-auto text-center">
        <h1 class="text-2xl font-semibold">Thank you. Your dedication is received.</h1>
        <p class="mt-3 text-gray-600">We’ll include it on an upcoming video and email you when it’s live.</p>

        <div class="mt-6 p-4 border rounded text-left">
            <p><strong>Type:</strong> {{ $dedication->dedication_type ?? '-' }}</p>
            <p><strong>Honoree:</strong> {{ $dedication->honoree_name ?? '-' }}</p>
            <p><strong>Note:</strong> {{ $dedication->short_note ?? '-' }}</p>
            <p><strong>Receipt #:</strong> {{ $orderId ?? ($dedication->order_id ?? '-') }}</p>

            <div class="mt-3">
                <button id="copy-share" class="btn">Copy share text</button>
            </div>

            <div class="mt-4 space-x-2">
                <a href="{{ route('dedicate.details') }}" class="btn">Add another dedication</a>
                <a href="/" class="btn btn-secondary">Return to Home</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('copy-share')?.addEventListener('click', function(){
    const text = `I dedicated a video in honor of ${document.querySelector('p strong')?.nextSibling?.textContent || ''}`;
    navigator.clipboard?.writeText(text).then(()=> alert('Copied share text'));
});
</script>
@endpush

@endsection
