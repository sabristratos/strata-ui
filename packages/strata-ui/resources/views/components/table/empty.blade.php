@props([
    'message' => 'No data available',
    'icon' => 'inbox',
    'colspan' => null,
])

<tr data-strata-table-empty>
    <td
        colspan="{{ $colspan }}"
        class="text-center py-12"
    >
        <div class="flex flex-col items-center justify-center gap-3">
            @if($icon)
                <x-dynamic-component
                    :component="'strata::icon.' . $icon"
                    class="w-12 h-12 text-muted-foreground/30"
                />
            @endif
            <div class="text-muted-foreground">
                @if($slot->isEmpty())
                    <p class="text-sm">{{ $message }}</p>
                @else
                    {{ $slot }}
                @endif
            </div>
        </div>
    </td>
</tr>
