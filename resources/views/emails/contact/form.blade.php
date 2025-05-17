@component('mail::message')
# New Contact Form Submission

You have received a new message via your website contact form:

**Full Name:** {{ $formData['name'] ?? 'N/A' }}
**Email:** [{{ $formData['email'] ?? 'N/A' }}](mailto:{{ $formData['email'] ?? '' }})
**Phone:** {{ $formData['phone'] ?? 'N/A' }}
**Nationality:** {{ $formData['nationality'] ?? 'N/A' }}

---

**Trip Details:**

**Departure Date :** {{ isset($formData['arrival_date']) ? \Carbon\Carbon::parse($formData['arrival_date'])->format('d M Y') : 'N/A' }}
**Duration:** {{ $formData['duration_days'] ?? 'N/A' }} days
**Adults (>12):** {{ $formData['adults'] ?? 'N/A' }}
**Children (2-11):** {{ $formData['children'] ?? '0' }}

---

**Travel Ideas / Message:**

@component('mail::panel')
{{ $formData['travel_ideas'] ?? 'No specific ideas provided.' }}
@endcomponent

---

Please follow up with them soon.

Thanks,<br>
{{ config('app.name') }}
@endcomponent