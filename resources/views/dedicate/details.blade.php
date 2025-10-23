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
                    <input id="email" name="email" type="email" class="input" required />
                </div>
                <div class="dedication-form-field">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" class="input" required />
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

@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('dedication-form');
    const submitBtn = document.getElementById('next-btn');
    const checkbox = document.getElementById('consent_spelling');
    const dedicationType = document.getElementById('dedication_type');
    const otherType = document.getElementById('other_type');

    function updateOtherVisibility() {
        if (dedicationType.value === 'Other') {
            otherType.style.display = 'block';
            otherType.setAttribute('required', 'required');
        } else {
            otherType.style.display = 'none';
            otherType.removeAttribute('required');
            otherType.value = '';
        }
    }

    function isFormValid() {
        const requiredFields = form.querySelectorAll('[required]');
        for (let field of requiredFields) {
            const val = (field.value || '').trim();
            if (!val) return false;
        }
        if (!checkbox.checked) return false;
        return true;
    }

    function refreshButtonState() {
        submitBtn.disabled = !isFormValid();
    }

    // Attach input listeners
    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', () => {
            if (el === dedicationType) updateOtherVisibility();
            refreshButtonState();
        });
        el.addEventListener('change', () => {
            if (el === dedicationType) updateOtherVisibility();
            refreshButtonState();
        });
    });

    checkbox.addEventListener('change', refreshButtonState);

    // On submit → show "Saving..." and allow form to submit
    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.classList.add('submitting');
        submitBtn.textContent = 'Saving...';
    });

    // Initialize on load
    updateOtherVisibility();
    refreshButtonState();
});
</script>

@endsection