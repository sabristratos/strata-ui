<div
    class="overflow-y-auto max-h-64"
    x-ref="timeList"
    role="listbox"
    tabindex="-1"
    @keydown="handleKeyboardNavigation($event)"
>
    <div class="space-y-0.5">
        <template x-for="(time, index) in times" :key="time.value">
            <button
                type="button"
                @click="selectTime(time.value)"
                :disabled="time.disabled"
                :id="`time-option-${index}`"
                :aria-selected="time.value === entangleable.value"
                role="option"
                data-strata-time-option
                :class="{
                    'bg-primary text-primary-foreground font-medium': time.value === entangleable.value,
                    'hover:bg-accent hover:text-accent-foreground': time.value !== entangleable.value && !time.disabled,
                    'opacity-40 cursor-not-allowed': time.disabled,
                    'ring-2 ring-primary ring-inset': time.isCurrent && time.value !== entangleable.value,
                    'ring-2 ring-ring ring-inset': highlighted === index && time.value !== entangleable.value
                }"
                class="w-full text-left px-3 py-2 text-sm rounded-md transition-colors duration-150"
                x-text="time.label"
            >
            </button>
        </template>
    </div>
</div>
