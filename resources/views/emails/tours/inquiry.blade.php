{{-- resources/views/emails/tours/inquiry.blade.php --}}
@component('mail::message')
# New Tour Inquiry: {{ $tour->title }}

You have received an inquiry regarding the following tour/activity:
**Tour:** {{ $tour->title }}
**Link:** [{{ route('tours.show', $tour) }}]({{ route('tours.show', $tour) }})

---

**Submitter Details:**

**Full Name:** {{ $formData['name'] ?? 'N/A' }}
**Email:** [{{ $formData['email'] ?? 'N/A' }}](mailto:{{ $formData['email'] ?? '' }})
**Phone:** {{ $formData['phone'] ?? 'N/A' }}
**Nationality:** {{ $formData['nationality'] ?? 'N/A' }}

---

**Trip Details:**

**Preferred Arrival Date:** {{ isset($formData['arrival_date']) ? \Carbon\Carbon::parse($formData['arrival_date'])->format('d M Y') : 'N/A' }}
**Preferred Duration:** {{ $formData['duration_days'] ?? 'N/A' }} days
**Adults (>12):** {{ $formData['adults'] ?? 'N/A' }}
**Children (2-11):** {{ $formData['children'] ?? '0' }}

---

**Message / Specific Requests:**

@component('mail::panel')
{{ $formData['inquiry_message'] ?? 'No message provided.' }}
@endcomponent

---

Please follow up with them soon.

Thanks,<br>
{{ config('app.name') }}
@endcomponent