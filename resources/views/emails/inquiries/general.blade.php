<x-mail::message>
# New Inquiry Received

You have received a new inquiry with the following details:

**Name:** {{ $data['name'] }}
**Email:** [{{ $data['email'] }}](mailto:{{ $data['email'] }})
@isset($data['phone'])
**Phone:** {{ $data['phone'] }}
@endisset
@isset($data['country'])
**Country:** {{ $data['country'] }}
@endisset

{{-- Conditionally display the subject/related item --}}
@isset($data['subject_type']) {{-- Check if a type is provided --}}
**Regarding {{ ucfirst($data['subject_type']) }}:** {{ $data['subject_title'] ?? 'N/A' }}
    {{-- Link if a slug/URL is available --}}
    @isset($data['subject_url'])
    <x-mail::button :url="$data['subject_url']">
    View {{ ucfirst($data['subject_type']) }}
    </x-mail::button>
    @endisset
@elseif(isset($data['subject'])) {{-- General subject from contact form --}}
**Subject:** {{ $data['subject'] }}
@endif

{{-- Conditionally display Adults/Children --}}
@isset($data['adults'])
**Adults:** {{ $data['adults'] }}
@endisset
@isset($data['children'])
**Children:** {{ $data['children'] }}
@endisset

---

**Message:**

{{-- Use nl2br to preserve line breaks from textarea --}}
{!! nl2br(e($data['message'])) !!}


Thanks,<br>
{{ config('app.name') }} Website
</x-mail::message>