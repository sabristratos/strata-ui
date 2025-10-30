<button
    type="button"
    data-strata-calendar-day
    @click="selectDate(formatDate(day.date))"
    :disabled="isDisabled(day.date)"
    :aria-selected="isSelected(day.date)"
    :aria-label="formatDate(day.date)"
    :tabindex="focusedDate && isSameDay(day.date, focusedDate) ? 0 : -1"
    x-bind:class="{
        'bg-primary text-primary-foreground': (isSelected(day.date) && !isInRange(day.date)) || isRangeStart(day.date) || isRangeEnd(day.date),
        'rounded-l-lg': isRangeStart(day.date),
        'rounded-r-lg': isRangeEnd(day.date),
        'bg-primary-subtle': isInRange(day.date),
        'border-2 border-primary': isToday(day.date) && !isSelected(day.date),
        'text-muted-foreground opacity-50': !day.currentMonth,
        'opacity-40 cursor-not-allowed': isDisabled(day.date),
        'hover:bg-primary-subtle': !isDisabled(day.date) && !isSelected(day.date),
        'ring-2 ring-primary ring-offset-2': focusedDate && isSameDay(day.date, focusedDate)
    }"
    class="aspect-square flex items-center justify-center rounded-lg transition-all duration-150 text-sm font-medium focus:outline-none"
    x-text="day.date.getDate()"
></button>
