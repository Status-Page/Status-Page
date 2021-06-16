@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Incident Updates --}}
@isset($incidentUpdates)
@foreach ($incidentUpdates as $update)
**{{ $update->getUpdateType() }}** - {{ $update->text }}<br>
@endforeach
@endisset

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level ?? '') {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset
<br>
{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@isset($unsubscribe_key)
<br />
Unsubscribe from this notifications by clicking [this link]({{ route('subscribers.unsubscribe', ['subscriber' => $unsubscribe_id, 'key' => $unsubscribe_key]) }}).
@endisset
@endslot
@endisset
@endcomponent
