@props([
    'monthOffset' => 0,
])

<div
    data-strata-calendar-header
    class="flex items-center justify-between mb-4"
    x-data="{
        showMonthPicker: false,
        monthPickerPositionable{{ $monthOffset }}: null,
        months: ['January', 'February', 'March', 'April', 'May', 'June',
                 'July', 'August', 'September', 'October', 'November', 'December'],
        years: [],
        selectedYear: null,
        selectedMonth: null,

        init() {
            this.monthPickerPositionable{{ $monthOffset }} = new window.StrataPositionable({
                placement: 'bottom',
                offset: 8,
                strategy: 'absolute'
            });

            const button = this.$refs.monthPickerButton{{ $monthOffset }};
            const dropdown = this.$refs.monthPickerDropdown{{ $monthOffset }};

            if (button && dropdown) {
                this.monthPickerPositionable{{ $monthOffset }}.start(this, button, dropdown);
            }

            this.$watch('showMonthPicker', (value) => {
                if (value && this.monthPickerPositionable{{ $monthOffset }}) {
                    this.$nextTick(() => {
                        this.monthPickerPositionable{{ $monthOffset }}.state = true;
                    });
                } else if (this.monthPickerPositionable{{ $monthOffset }}) {
                    this.monthPickerPositionable{{ $monthOffset }}.state = false;
                }
            });

            const currentYear = new Date().getFullYear();
            for (let i = currentYear - 100; i <= currentYear + 10; i++) {
                this.years.push(i);
            }

            const validMonth = (currentMonth && currentMonth instanceof Date) ? currentMonth : new Date();
            this.selectedYear = validMonth.getFullYear();
            this.selectedMonth = validMonth.getMonth() + {{ $monthOffset }};
        },

        selectMonth(index) {
            this.selectedMonth = index;
            goToMonth(this.selectedMonth - {{ $monthOffset }}, this.selectedYear);
            this.showMonthPicker = false;
        },

        changeYear() {
            goToMonth(this.selectedMonth - {{ $monthOffset }}, this.selectedYear);
        }
    }"
>
    <x-strata::button.icon
        icon="chevron-left"
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="previousMonth()"
        aria-label="Previous month"
        x-show="{{ $monthOffset }} === 0"
    />

    <div class="flex-1 flex items-center justify-center gap-2 relative">
        <h2
            class="text-lg font-semibold"
            x-text="formatMonthYear(new Date(currentMonth.getFullYear(), currentMonth.getMonth() + {{ $monthOffset }}, 1))"
        ></h2>

        <x-strata::button
            x-ref="monthPickerButton{{ $monthOffset }}"
            icon="chevron-down"
            size="sm"
            variant="primary"
            appearance="outlined"
            @click="showMonthPicker = !showMonthPicker"
            aria-label="Select month and year"
        />

        <x-strata::calendar.month-picker
            :month-offset="$monthOffset"
        />
    </div>

    <x-strata::button.icon
        icon="chevron-right"
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="nextMonth()"
        aria-label="Next month"
        x-show="{{ $monthOffset }} === (monthsToShow - 1)"
    />
</div>
