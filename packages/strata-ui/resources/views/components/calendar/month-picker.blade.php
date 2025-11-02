@props([
    'monthOffset' => 0,
])

<div
    x-cloak
    x-show="showMonthPicker"
    @click.outside="showMonthPicker = false"
    x-ref="monthPickerDropdown{{ $monthOffset }}"
    class="absolute top-0 left-0 z-50"
    :style="monthPickerPositionable{{ $monthOffset }} ? monthPickerPositionable{{ $monthOffset }}.styles : {}"
>
    <div
        data-strata-calendar-month-picker
        class="min-w-72 bg-popover border border-border rounded-lg shadow-xl p-4 transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95"
    >
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-2 text-foreground">Year</label>
                <select
                    x-model="selectedYear"
                    @change="changeYear()"
                    class="w-full h-10 px-3 text-sm bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 transition-all duration-150 text-foreground"
                >
                    <template x-for="year in years" :key="year">
                        <option :value="year" x-text="year"></option>
                    </template>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 text-foreground">Month</label>
                <div class="grid grid-cols-3 gap-2">
                    <template x-for="(month, index) in months" :key="index">
                        <button
                            type="button"
                            @click="selectMonth(index)"
                            x-bind:class="{
                                'bg-primary text-primary-foreground': selectedMonth === index,
                                'hover:bg-primary/10 text-foreground': selectedMonth !== index
                            }"
                            class="px-3 py-2 text-sm rounded-lg border border-border transition-colors"
                            x-text="month.substring(0, 3)"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
