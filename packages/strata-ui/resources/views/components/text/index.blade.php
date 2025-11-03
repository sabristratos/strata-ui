@props([
    'variant' => 'body',
    'as' => null,
])

@php
    $variantConfig = [
        'body' => [
            'tag' => 'p',
            'class' => 'text-base text-foreground',
        ],
        'lead' => [
            'tag' => 'p',
            'class' => 'text-xl text-foreground',
        ],
        'large' => [
            'tag' => 'p',
            'class' => 'text-lg text-foreground',
        ],
        'small' => [
            'tag' => 'p',
            'class' => 'text-sm text-foreground',
        ],
        'muted' => [
            'tag' => 'p',
            'class' => 'text-sm text-muted-foreground',
        ],
        'overline' => [
            'tag' => 'span',
            'class' => 'text-xs uppercase tracking-wide font-medium text-muted-foreground',
        ],
        'quote' => [
            'tag' => 'blockquote',
            'class' => 'border-l-4 border-primary pl-4 italic text-foreground',
        ],
        'code' => [
            'tag' => 'code',
            'class' => 'font-mono text-sm bg-muted text-foreground px-1.5 py-0.5 rounded',
        ],
    ];

    $config = $variantConfig[$variant] ?? $variantConfig['body'];
    $tag = $as ?? $config['tag'];
@endphp

@if($slot->isNotEmpty())
    <{{ $tag }} {{ $attributes->merge(['class' => $config['class']]) }} data-strata-text data-strata-text-variant="{{ $variant }}">
        {{ $slot }}
    </{{ $tag }}>
@endif
