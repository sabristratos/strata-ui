@php
    $hasLabel = isset($label) && !empty($label);
@endphp

@if($hasLabel)
    <div class="px-3 py-2 border-t border-default">
        <h6 class="text-xs font-semibold text-muted uppercase tracking-wide">{{ $label }}</h6>
    </div>
@else
    <div class="border-t border-default my-1" {{ $attributes }}></div>
@endif