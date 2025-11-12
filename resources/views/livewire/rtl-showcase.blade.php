<div class="space-y-12">
    <section>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ __('demo.form_title') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                {{ __('demo.form_subtitle') }}
            </p>

            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">
                        {{ __('section.inputs') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-strata::input
                            wire:model="fullName"
                            :label="__('input.full_name')"
                            :hint="__('input.full_name_hint')"
                            iconLeft="user"
                            required
                        />

                        <x-strata::input
                            wire:model="email"
                            type="email"
                            :label="__('input.email')"
                            :hint="__('input.email_hint')"
                            iconLeft="mail"
                            required
                        />

                        <x-strata::input
                            wire:model="password"
                            type="password"
                            :label="__('input.password')"
                            :hint="__('input.password_hint')"
                            iconLeft="lock"
                            maxlength="50"
                            required
                        >
                            <x-strata::input.counter max="50" />
                            <x-strata::input.toggle-password />
                        </x-strata::input>

                        <x-strata::input
                            wire:model="website"
                            type="url"
                            :label="__('input.website')"
                            :prefix="__('input.website_prefix')"
                            iconLeft="globe"
                        />

                        <x-strata::input
                            wire:model="price"
                            type="number"
                            :label="__('input.price')"
                            :prefix="__('input.price_prefix')"
                            iconLeft="dollar-sign"
                            step="0.01"
                        />

                        <x-strata::input
                            wire:model.live.debounce.500ms="search"
                            type="search"
                            :label="__('input.search')"
                            :placeholder="__('input.search_placeholder')"
                            iconLeft="search"
                        >
                            <x-strata::input.clear />
                        </x-strata::input>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">
                        {{ __('section.selects') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-strata::select
                            wire:model="country"
                            :label="__('input.country')"
                            :placeholder="__('select.placeholder')"
                            searchable
                            clearable
                        >
                            @foreach($countries as $countryOption)
                                <x-strata::select.option
                                    :value="$countryOption['code']"
                                    :label="$countryOption['name']"
                                />
                            @endforeach
                        </x-strata::select>

                        <x-strata::select
                            wire:model="tags"
                            :label="__('input.tags')"
                            :placeholder="__('select.tags_placeholder')"
                            :multiple="true"
                            :chips="true"
                            searchable
                        >
                            <x-strata::select.option value="laravel" :label="__('tags.laravel')" />
                            <x-strata::select.option value="php" :label="__('tags.php')" />
                            <x-strata::select.option value="javascript" :label="__('tags.javascript')" />
                            <x-strata::select.option value="tailwind" :label="__('tags.tailwind')" />
                            <x-strata::select.option value="alpine" :label="__('tags.alpine')" />
                            <x-strata::select.option value="livewire" :label="__('tags.livewire')" />
                        </x-strata::select>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">
                        {{ __('section.dates') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-strata::date-picker
                            wire:model="birthDate"
                            :label="__('date.birth_date')"
                            :placeholder="__('date.select_date')"
                            iconLeft="calendar"
                        />

                        <x-strata::date-picker
                            wire:model="appointmentDate"
                            :label="__('date.appointment')"
                            :placeholder="__('date.select_date')"
                            :minDate="date('Y-m-d')"
                        />

                        <x-strata::date-picker
                            wire:model="dateRange"
                            :label="__('date.date_range')"
                            :placeholder="__('date.select_range')"
                            :range="true"
                        />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">
                        {{ __('section.time') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-strata::time-picker
                            wire:model="appointmentTime"
                            :label="__('time.appointment')"
                            :placeholder="__('time.select_time')"
                        />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">
                        {{ __('section.colors') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-strata::color-picker
                            wire:model="themeColor"
                            :label="__('color.theme')"
                            :hint="__('color.theme_hint')"
                            clearable
                        />

                        <x-strata::color-picker
                            wire:model="backgroundColor"
                            :label="__('color.background')"
                            :hint="__('color.background_hint')"
                            clearable
                        />
                    </div>

                    <div class="mt-6 flex gap-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('color.preview_theme') }}
                            </p>
                            <div class="h-20 rounded-lg border-2 border-gray-200 dark:border-gray-700" :style="`background-color: ${$wire.themeColor}`"></div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('color.preview_background') }}
                            </p>
                            <div class="h-20 rounded-lg border-2 border-gray-200 dark:border-gray-700" :style="`background-color: ${$wire.backgroundColor}`"></div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">
                        {{ __('section.phone') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-strata::phone-input
                            wire:model="mobilePhone"
                            :countries="$countries"
                            :label="__('phone.mobile')"
                            :hint="__('phone.mobile_hint')"
                            default-country="US"
                            required
                        />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">
                        {{ __('section.advanced') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-strata::textarea
                            wire:model="bio"
                            :label="__('textarea.bio')"
                            :placeholder="__('textarea.bio_placeholder')"
                            :hint="__('textarea.bio_hint')"
                            rows="4"
                            maxlength="500"
                        />

                        <x-strata::textarea
                            wire:model="notes"
                            :label="__('textarea.notes')"
                            :placeholder="__('textarea.notes_placeholder')"
                            rows="4"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
