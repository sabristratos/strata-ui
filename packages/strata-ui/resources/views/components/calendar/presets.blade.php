<div class="flex flex-wrap gap-2 mb-4 pb-4 border-b border-border">
    <x-strata::button
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="selectPreset('today')"
    >
        Today
    </x-strata::button>

    <x-strata::button
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="selectPreset('yesterday')"
    >
        Yesterday
    </x-strata::button>

    <x-strata::button
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="selectPreset('last7days')"
        x-show="mode === 'range'"
    >
        Last 7 days
    </x-strata::button>

    <x-strata::button
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="selectPreset('last30days')"
        x-show="mode === 'range'"
    >
        Last 30 days
    </x-strata::button>

    <x-strata::button
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="selectPreset('thisMonth')"
        x-show="mode === 'range'"
    >
        This month
    </x-strata::button>

    <x-strata::button
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="selectPreset('lastMonth')"
        x-show="mode === 'range'"
    >
        Last month
    </x-strata::button>
</div>
