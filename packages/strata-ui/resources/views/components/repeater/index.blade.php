@props([
    'min' => 0,
    'max' => null,
    'addLabel' => 'Add Item',
    'size' => 'md',
    'state' => 'default',
])

@php
    $wireName = $attributes->wire('model')->value();
    $initialItems = $wireName && isset($this->{$wireName}) ? $this->{$wireName} : [];
@endphp

<div
    x-data="strataRepeater(@js($initialItems), @js($wireName), {{ $min }}, {{ $max }})"
    data-strata-repeater
    {{ $attributes->except(['wire:model']) }}
>
    <div class="space-y-3">
        <template x-for="(item, index) in items" :key="index">
            <div>
                <x-strata::repeater.item
                    ::removable="(!{{ $min }} || items.length > {{ $min }})"
                    :size="$size"
                    @remove="remove(index)"
                >
                    <div x-data="{ itemIndex: index }">
                        {{ $slot }}
                    </div>
                </x-strata::repeater.item>
            </div>
        </template>
    </div>

    <div class="mt-4">
        <x-strata::repeater.controls
            :label="$addLabel"
            :size="$size"
            ::disabled="{{ $max }} && items.length >= {{ $max }}"
            @click="add()"
        />
    </div>
</div>

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataRepeater', (initialItems, wireName, min, max) => ({
        items: [],
        dirty: false,

        init() {
            this.items = (initialItems && initialItems.length) ? JSON.parse(JSON.stringify(initialItems)) : [{}];

            if (min && this.items.length < min) {
                while (this.items.length < min) {
                    this.items.push({});
                }
            }

            this.$watch('items', (value) => {
                this.syncToWire();
            }, { deep: true });

            this.$nextTick(() => {
                this.syncToWire();
            });
        },

        add() {
            if (!max || this.items.length < max) {
                this.items.push({});
                this.dirty = true;
            }
        },

        remove(index) {
            if (!min || this.items.length > min) {
                this.items.splice(index, 1);
                this.dirty = true;
            }
        },

        syncToWire() {
            if (this.$wire && wireName) {
                this.$wire.set(wireName, this.items);
            }
        },

        getItem(index) {
            return this.items[index] || {};
        },

        setItemProperty(index, property, value) {
            if (!this.items[index]) {
                this.items[index] = {};
            }
            this.items[index][property] = value;
        },

        getItemProperty(index, property) {
            return this.items[index]?.[property] || '';
        }
    }));
});
</script>
@endonce
