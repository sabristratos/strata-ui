@props([
    'monthOffset' => 0,
])

@php
$dayNames = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
@endphp

<div data-strata-calendar-grid>
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach($dayNames as $index => $dayName)
            <div
                class="text-center text-xs font-medium text-muted-foreground p-2"
                x-text="(() => {
                    const days = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
                    const adjustedIndex = ({{ $index }} + weekStartsOn) % 7;
                    return days[adjustedIndex];
                })()"
            ></div>
        @endforeach
    </div>

    <div
        class="grid grid-cols-7 gap-1"
        x-data="{
            getDaysInMonth() {
                const year = currentMonth.getFullYear();
                const month = currentMonth.getMonth() + {{ $monthOffset }};
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);

                const startDay = firstDay.getDay();
                const daysInMonth = lastDay.getDate();

                const adjustedStartDay = (startDay - weekStartsOn + 7) % 7;

                const prevMonthLastDay = new Date(year, month, 0).getDate();

                const days = [];

                for (let i = adjustedStartDay - 1; i >= 0; i--) {
                    const day = prevMonthLastDay - i;
                    const date = new Date(year, month - 1, day);
                    days.push({ date, currentMonth: false });
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const date = new Date(year, month, day);
                    days.push({ date, currentMonth: true });
                }

                const remainingDays = 42 - days.length;
                for (let day = 1; day <= remainingDays; day++) {
                    const date = new Date(year, month + 1, day);
                    days.push({ date, currentMonth: false });
                }

                return days;
            }
        }"
    >
        <template x-for="(day, index) in getDaysInMonth()" :key="index">
            <x-strata::calendar.day />
        </template>
    </div>
</div>
