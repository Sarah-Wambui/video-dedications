@extends('layouts.app')

@section('content')
<div class="container dedication-page py-8">
        <div class="max-w-2xl mx-auto dedication-header">
            <h1 class="dedication-title">Dedication Details</h1>
            <p class="dedication-subcopy">Please complete the information below.</p>
        </div>
    <div class="dedication-card mt-6">
        <form method="POST" action="{{ route('dedicate.store') }}" id="dedication-form" class="space-y-4 dedication-form">
            @csrf
            <div class="dedication-form-grid">
                <div class="dedication-form-field">
                    <label for="first_name">First Name</label>
                    <input id="first_name" name="first_name" required class="input" />
                </div>
                <div class="dedication-form-field">
                    <label for="last_name">Last Name</label>
                    <input id="last_name" name="last_name" class="input" />
                </div>
            </div>

            <div class="dedication-form-grid">
                <div class="dedication-form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required class="input" />
                </div>
                <div class="dedication-form-field">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" class="input" placeholder="E.164 preferred" />
                </div>
            </div>

            <div class="dedication-form-field">
                <label for="dedication_type">Dedication Type</label>
                <select name="dedication_type" id="dedication_type" required class="input">
                    <option value="In Honor Of">In Honor Of</option>
                    <option value="In Memory Of">In Memory Of</option>
                    <option value="For a Speedy Recovery (Refuah Sheleimah)">For a Speedy Recovery (Refuah Sheleimah)</option>
                    <option value="In Gratitude / Thank You">In Gratitude / Thank You</option>
                    <option value="For Success / Hatzlacha">For Success / Hatzlacha</option>
                    <option value="Other">Other</option>
                </select>
                <input name="other_type" id="other_type" class="input mt-2" placeholder="Type (max 30 chars)" style="display:none;" maxlength="30" />
            </div>

            <div class="dedication-form-field">
                <label for="honoree_name">Honoree Name</label>
                <input id="honoree_name" name="honoree_name" required class="input" placeholder="e.g., Rachel bat Yosef" />
                <p class="text-xs text-gray-500 mt-2">Use Hebrew naming if you prefer (e.g., Ploni ben/bat Plonit).</p>
            </div>

            <div class="dedication-form-field">
                <label for="short_note">Short Note <small class="text-gray-500">(optional, max 20 words)</small></label>
                <textarea name="short_note" id="short_note" class="input dedication-textarea"></textarea>
                <div class="text-sm text-gray-600 mt-1"><span id="word-count">0</span>/20 words</div>
            </div>

            <div class="dedication-form-field">
                <label class="inline-flex items-center confirm-spelling">
                    <input id="consent_spelling" type="checkbox" name="consent_spelling" />
                    <span class="ml-2">I confirm spelling of names is correct.</span>
                </label>
            </div>

            <div class="dedication-actions">
                <a href="{{ route('dedicate.landing') }}" class="btn-back" id="back-btn">← Back</a>
                <button type="submit" id="next-btn" class="btn btn-continue" disabled>Continue to Payment →</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const requiredFields = [
        "first_name",
        "last_name",
        "email",
        "honoree_name"
    ];

    const nextBtn = document.getElementById("next-btn");
    const checkbox = document.getElementById("consent_spelling");
    const dedicationType = document.getElementById("dedication_type");
    const otherType = document.getElementById("other_type");
    const form = document.getElementById("dedication-form");

    function countWords(s){
        if(!s) return 0;
        return s.trim().split(/\s+/).filter(Boolean).length;
    }

    function isEmailValid(email){
        return /\S+@\S+\.\S+/.test(email);
    }

    function normalizePhone(v){
        if(!v) return '';
        return v.replace(/[^+0-9]/g,'');
    }

    // Store original button text
    const originalBtnText = nextBtn.textContent;

    function validateForm() {
        let isValid = true;

        // gather values
        const first = (document.getElementById('first_name')?.value || '').trim();
        const last = (document.getElementById('last_name')?.value || '').trim();
        const email = (document.getElementById('email')?.value || '').trim();
        const phone = (document.getElementById('phone')?.value || '').trim();
        const hon = (document.getElementById('honoree_name')?.value || '').trim();
        const note = (document.getElementById('short_note')?.value || '').trim();

    // Required fields
    if(!first) isValid = false;
    // last name optional
    if(!hon) isValid = false;

        // Email
        if(!isEmailValid(email)) isValid = false;

    // Phone: optional. If provided, require at least 7 digits after normalization
    const normalizedPhone = normalizePhone(phone).replace(/[^0-9]/g,'');
    if(phone && normalizedPhone.length < 7) isValid = false;

        // Note word count <= 20
        const wordCountValue = countWords(note);
        if(wordCountValue > 20) isValid = false;

        // If "Other" selected, require otherType
        if(dedicationType.value === 'Other'){
            if(!otherType.value.trim()) isValid = false;
        }

        // Checkbox must be checked
        if(!checkbox.checked) isValid = false;

        nextBtn.disabled = !isValid;
        // restore text when becoming enabled (and not submitting)
        if(!nextBtn.disabled){
            nextBtn.textContent = originalBtnText;
            nextBtn.classList.remove('disabled');
        } else {
            nextBtn.classList.add('disabled');
        }
        return isValid;
    }

    // Show/hide other_type input
    dedicationType.addEventListener("change", function () {
        otherType.style.display = this.value === "Other" ? "block" : "none";
        validateForm();
    });

    // Live validate all fields + checkbox
    form.querySelectorAll("input, select, textarea").forEach(input => {
        input.addEventListener("input", validateForm);
        input.addEventListener("change", validateForm);
    });

    // On submit: run validation, show saving state and prevent double-submit
    form.addEventListener('submit', function(e){
        const ok = validateForm();
        if(!ok){
            // prevent submit if invalid
            e.preventDefault();
            return;
        }
        // mark submitting: disable the button and show Saving...
        nextBtn.disabled = true;
        nextBtn.classList.add('submitting');
        nextBtn.textContent = 'Saving...';
        // allow form to submit normally (server will redirect to payment page)
    });
});
</script>

@endpush

@endsection
