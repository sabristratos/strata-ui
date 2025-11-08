@props([
    'monthOffset' => 0,
    'placement' => 'bottom',
    'pickerId',
])

@php
$positioningStyle = 'inset-area: ' . match($placement) {
    'bottom', 'bottom-start' => 'bottom span-left',
    'bottom-end' => 'bottom span-right',
    'top', 'top-start' => 'top span-left',
    'top-end' => 'top span-right',
    default => 'bottom span-left',
} . ';';
@endphp

<div
    id="{{ $pickerId }}"
    popover="auto"
    @toggle="showMonthPicker = $event.newState === 'open'"
    style="{{ $positioningStyle }} position-anchor: --monthpicker-{{ $pickerId }};"
    @keydown.escape="showMonthPicker = false"
    x-trap.nofocus="showMonthPicker"
    data-strata-monthpicker-dropdown
    data-placement="{{ $placement }}"
    wire:ignore.self
    tabindex="-1"
    role="dialog"
    aria-modal="true"
    aria-label="{{ __('Select month and year') }}"
    class="m-0 p-0 border-none bg-transparent inset-[unset]"
    x-data="{
        scrollToCurrentYear() {
            this.$nextTick(() => {
                const yearGrid = this.$refs.yearGrid{{ $monthOffset }};
                const selectedYearButton = yearGrid?.querySelector('[data-year=\'' + this.selectedYear + '\']');
                if (selectedYearButton) {
                    selectedYearButton.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }
    }"
    x-init="$watch('showMonthPicker', (value) => { if (value) scrollToCurrentYear(); })"
>
    <div
        data-strata-calendar-month-picker
        class="bg-popover border border-border rounded-lg shadow-xl transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95"
    >
        <div class="flex">
            <div class="border-r border-border">
                <div class="px-4 py-3 border-b border-border">
                    <label class="block text-sm font-medium text-foreground">Year</label>
                </div>
                <div
                    x-ref="yearGrid{{ $monthOffset }}"
                    class="max-h-80 overflow-y-auto p-2 w-48"
                >
                    <div class="grid grid-cols-3 gap-1">
                        <template x-for="year in years" :key="year">
                            <button
                                type="button"
                                :data-year="year"
                                @click="selectedYear = year; changeYear(); scrollToCurrentYear();"
                                x-bind:class="{
                                    'bg-primary text-primary-foreground font-semibold': selectedYear === year,
                                    'hover:bg-primary/10 text-foreground': selectedYear !== year
                                }"
                                class="px-2 py-1.5 text-sm rounded transition-colors"
                                x-text="year"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>

            <div>
                <div class="px-4 py-3 border-b border-border">
                    <label class="block text-sm font-medium text-foreground">Month</label>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-3 gap-2 w-56">
                        <template x-for="index in 12" :key="index">
                            <button
                                type="button"
                                @click="selectMonth(index - 1)"
                                x-bind:class="{
                                    'bg-primary text-primary-foreground font-semibold': selectedMonth === (index - 1),
                                    'hover:bg-primary/10 text-foreground': selectedMonth !== (index - 1)
                                }"
                                class="px-3 py-2 text-sm rounded-lg border border-border transition-colors"
                                x-text="getMonthName(index - 1).substring(0, 3)"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
