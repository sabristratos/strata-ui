@props([
    'monthOffset' => 0,
])

<div
    {{ $attributes->merge(['class' => 'absolute z-10 top-full mt-2 left-1/2 -translate-x-1/2 p-4 bg-background border border-border rounded-lg shadow-lg']) }}
    x-data="{
        months: ['January', 'February', 'March', 'April', 'May', 'June',
                 'July', 'August', 'September', 'October', 'November', 'December'],
        years: [],
        selectedYear: null,
        selectedMonth: null,

        init() {
            const currentYear = new Date().getFullYear();
            for (let i = currentYear - 100; i <= currentYear + 10; i++) {
                this.years.push(i);
            }
            this.selectedYear = currentMonth.getFullYear();
            this.selectedMonth = currentMonth.getMonth() + {{ $monthOffset }};
        },

        selectMonthYear() {
            goToMonth(this.selectedMonth - {{ $monthOffset }}, this.selectedYear);
            showMonthPicker = false;
        }
    }"
>
    <div class="space-y-4 min-w-64">
        <div>
            <label class="block text-sm font-medium mb-2">Year</label>
            <select
                x-model="selectedYear"
                class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary bg-background"
            >
                <template x-for="year in years" :key="year">
                    <option :value="year" x-text="year"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Month</label>
            <div class="grid grid-cols-3 gap-2">
                <template x-for="(month, index) in months" :key="index">
                    <button
                        type="button"
                        @click="selectedMonth = index; selectMonthYear()"
                        x-bind:class="{
                            'bg-primary text-primary-foreground': selectedMonth === index,
                            'hover:bg-primary-subtle': selectedMonth !== index
                        }"
                        class="px-3 py-2 text-sm rounded-lg border border-border transition-colors"
                        x-text="month.substring(0, 3)"
                    ></button>
                </template>
            </div>
        </div>
    </div>
</div>
