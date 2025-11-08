<div {{ $attributes->merge(['class' => 'flex flex-col gap-1 pr-4 mr-4 border-r border-border min-w-40']) }}>
    <div class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">
        {{ __('Quick Select') }}
    </div>

    <template x-if="mode !== 'range'">
        <div class="flex flex-col gap-1">
            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('today')"
                class="w-full justify-start"
            >
                {{ __('Today') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('yesterday')"
                class="w-full justify-start"
            >
                {{ __('Yesterday') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('thisWeek')"
                class="w-full justify-start"
            >
                {{ __('This week') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('thisMonth')"
                class="w-full justify-start"
            >
                {{ __('This month') }}
            </x-strata::button>
        </div>
    </template>

    <template x-if="mode === 'range'">
        <div class="flex flex-col gap-1">
            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('last7days')"
                class="w-full justify-start"
            >
                {{ __('Last 7 days') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('last30days')"
                class="w-full justify-start"
            >
                {{ __('Last 30 days') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('thisMonth')"
                class="w-full justify-start"
            >
                {{ __('This month') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('lastMonth')"
                class="w-full justify-start"
            >
                {{ __('Last month') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('thisQuarter')"
                class="w-full justify-start"
            >
                {{ __('This quarter') }}
            </x-strata::button>

            <x-strata::button
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click="selectPreset('thisYear')"
                class="w-full justify-start"
            >
                {{ __('This year') }}
            </x-strata::button>
        </div>
    </template>
</div>
