<button
    type="button"
    data-strata-calendar-day
    @click="selectDate(formatDate(day.date))"
    @mouseenter="handleDateHover(day.date)"
    @mouseleave="clearDateHover()"
    :disabled="isDisabled(day.date)"
    :aria-selected="isSelected(day.date)"
    :aria-disabled="isDisabled(day.date) ? 'true' : 'false'"
    :aria-label="(() => {
        const date = day.date;
        const dateFormatter = new Intl.DateTimeFormat(locale, { dateStyle: 'full' });
        let label = dateFormatter.format(date);
        if (isToday(date)) label += ', ' + @js(__('Today'));
        if (isSelected(date)) label += ', ' + @js(__('Selected'));
        if (isDisabled(date)) label += ', ' + @js(__('Not available'));
        return label;
    })()"
    :tabindex="focusedDate && isSameDay(day.date, focusedDate) ? 0 : -1"
    x-bind:class="{
        'bg-primary/20': isInRange(day.date) && !isRangeStart(day.date) && !isRangeEnd(day.date),
        'bg-primary/10': isHoverInRange(day.date) && !isInRange(day.date),
        'bg-primary text-primary-foreground': isRangeStart(day.date) || isRangeEnd(day.date) || (isSelected(day.date) && !isInRange(day.date)),
        'rounded-l-lg': isRangeStart(day.date),
        'rounded-r-lg': isRangeEnd(day.date),
        'rounded-lg': !isRangeStart(day.date) && !isRangeEnd(day.date) && !isInRange(day.date),
        'border-2 border-primary': isToday(day.date) && !isSelected(day.date),
        'text-muted-foreground opacity-50': !day.currentMonth,
        'opacity-40 cursor-not-allowed': isDisabled(day.date),
        'hover:bg-primary/10': !isDisabled(day.date) && !isSelected(day.date) && !isHoverInRange(day.date),
        'ring-2 ring-primary ring-offset-2': focusedDate && isSameDay(day.date, focusedDate)
    }"
    {{ $attributes->merge(['class' => 'aspect-square flex items-center justify-center transition-all duration-150 text-sm font-medium focus:outline-none']) }}
    x-text="day.date.getDate()"
></button>
