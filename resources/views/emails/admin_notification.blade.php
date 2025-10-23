<p>A new paid dedication has been received.</p>
<p><strong>Details</strong></p>
<p>Donor: {{ $dedication->first_name }} {{ $dedication->last_name }} ({{ $dedication->email }})</p>
<p>Type: {{ $dedication->dedication_type }}</p>
<p>Honoree: {{ $dedication->honoree_name }}</p>
<p>Note: {{ $dedication->short_note }}</p>

<p>Stripe intent id: {{ $intent['id'] ?? 'N/A' }}</p>
