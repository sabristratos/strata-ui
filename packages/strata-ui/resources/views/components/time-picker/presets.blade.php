<div class="w-32 border-r border-border p-2 space-y-0.5">
    <button
        type="button"
        @click="selectPreset('now')"
        class="w-full text-left px-2 py-1.5 text-xs rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150 font-medium"
    >
        Now
    </button>

    <button
        type="button"
        @click="selectPreset('morning')"
        class="w-full text-left px-2 py-1.5 text-xs rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
    >
        Morning
        <span class="text-[10px] text-muted-foreground block">9:00 AM</span>
    </button>

    <button
        type="button"
        @click="selectPreset('noon')"
        class="w-full text-left px-2 py-1.5 text-xs rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
    >
        Noon
        <span class="text-[10px] text-muted-foreground block">12:00 PM</span>
    </button>

    <button
        type="button"
        @click="selectPreset('afternoon')"
        class="w-full text-left px-2 py-1.5 text-xs rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
    >
        Afternoon
        <span class="text-[10px] text-muted-foreground block">1:00 PM</span>
    </button>

    <button
        type="button"
        @click="selectPreset('evening')"
        class="w-full text-left px-2 py-1.5 text-xs rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
    >
        Evening
        <span class="text-[10px] text-muted-foreground block">5:00 PM</span>
    </button>

    <button
        type="button"
        @click="selectPreset('endOfDay')"
        class="w-full text-left px-2 py-1.5 text-xs rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
    >
        End of Day
        <span class="text-[10px] text-muted-foreground block">11:59 PM</span>
    </button>
</div>
