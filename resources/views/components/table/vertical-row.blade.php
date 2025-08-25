@php
    $labelClasses = 'px-[var(--table-cell-px)] py-[var(--table-cell-py)] text-primary bg-default w-1/3 align-top';
    if ($labelBold) {
        $labelClasses .= ' font-semibold';
    }

    $valueClasses = 'px-[var(--table-cell-px)] py-[var(--table-cell-py)] text-secondary';
@endphp

<tr {{ $attributes->merge(['class' => '']) }}>
    <th class="{{ $labelClasses }}">
        {{ $label }}
    </th>
    <td class="{{ $valueClasses }}">
        {{ $slot }}
    </td>
</tr>
