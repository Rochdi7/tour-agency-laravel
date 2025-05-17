{{-- resources/views/emails/activities/inquiry.blade.php --}}
@component('mail::message')
# New Activity Inquiry: {{ $activity->title }}

You have received an inquiry regarding the following activity:
**Activity:** {{ $activity->title }}
**Link:** [{{ route('activities.show', $activity) }}]({{ route('activities.show', $activity) }}) {{-- Make sure route name is correct --}}

---

**Submitter Details:**

**Full Name:** {{ $formData['name'] ?? 'N/A' }}
**Email:** [{{ $formData['email'] ?? 'N/A' }}](mailto:{{ $formData['email'] ?? '' }})
**Phone:** {{ $formData['phone'] ?? 'N/A' }}
**Nationality:** {{ $formData['nationality'] ?? 'N/A' }} {{-- Changed from Country --}}

---

**Trip Details (If Applicable):**

{{-- Check if these fields exist and have values before displaying --}}
@if(isset($formData['arrival_date']) && $formData['arrival_date'])
**Preferred Departure Date :** {{ \Carbon\Carbon::parse($formData['arrival_date'])->format('d M Y') }}
@endif
@if(isset($formData['duration_days']) && $formData['duration_days'])
**Preferred Duration:** {{ $formData['duration_days'] }} days
@endif
**Adults (>12):** {{ $formData['adults'] ?? 'N/A' }}
**Children (2-11):** {{ $formData['children'] ?? '0' }}

---

**Message / Specific Requests:**

@component('mail::panel')
{{ $formData['inquiry_message'] ?? 'No message provided.' }} {{-- Changed from message --}}
@endcomponent

---

Please follow up with them soon.

Thanks,<br>
{{ config('app.name') }}
@endcomponent