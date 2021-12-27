@component('mail::message')
# Some title

Sent by: {{ $data['email'] }}<br><br><br>
Message:<br>
{{ $data['message'] }}.

{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
