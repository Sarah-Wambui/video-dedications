<p>Dear {{ $dedication->first_name }},</p>
<p>Thank you — your dedication has been received. We will include it on an upcoming video and notify you when it is live.</p>
<p><strong>Dedication</strong></p>
<p>Type: {{ $dedication->dedication_type }}</p>
<p>Honoree: {{ $dedication->honoree_name }}</p>
<p>Note: {{ $dedication->short_note }}</p>

<p>Receipt: {{ $intent['id'] ?? $dedication->order_id ?? 'N/A' }}</p>

<p>With thanks,<br/>The Team</p>
