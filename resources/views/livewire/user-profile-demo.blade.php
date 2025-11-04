<div class="max-w-5xl mx-auto p-6 space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">User Profile Demo</h1>
            <p class="text-muted-foreground mt-1">Testing Select, Date Picker, Time Picker, and other components</p>
        </div>
        <x-strata::button
            variant="secondary"
            appearance="outlined"
            icon="arrow-left"
            href="/"
        >
            Back to Home
        </x-strata::button>
    </div>

    {{-- Success Message --}}
    @if ($saved)
        <div class="p-4 bg-success/10 border border-success rounded-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-success flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold text-success">Profile Saved Successfully!</h3>
                <p class="text-sm text-success/80 mt-1">All components are working correctly with wire:model binding.</p>
            </div>
        </div>
    @endif

    {{-- Form Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Basic Information --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-foreground border-b pb-2">Basic Information</h2>

            {{-- Name Input --}}
            <div>
                <label class="block text-sm font-medium text-foreground mb-1.5">
                    Full Name <span class="text-destructive">*</span>
                </label>
                <x-strata::input
                    wire:model.blur="name"
                    placeholder="Enter your full name"
                    iconLeft="user"
                    :state="$errors->has('name') ? 'error' : 'default'"
                />
                @error('name')
                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Input --}}
            <div>
                <label class="block text-sm font-medium text-foreground mb-1.5">
                    Email Address <span class="text-destructive">*</span>
                </label>
                <x-strata::input
                    wire:model.blur="email"
                    type="email"
                    placeholder="your@email.com"
                    iconLeft="mail"
                    :state="$errors->has('email') ? 'error' : 'default'"
                />
                @error('email')
                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Department Select (Single) --}}
            <div>
                <label class="block text-sm font-medium text-foreground mb-1.5">
                    Department <span class="text-destructive">*</span>
                </label>
                <x-strata::select
                    wire:model.live="department"
                    placeholder="Select your department"
                    :clearable="true"
                    :state="$errors->has('department') ? 'error' : 'default'"
                >
                    <x-strata::select.option value="engineering" label="Engineering" />
                    <x-strata::select.option value="design" label="Design" />
                    <x-strata::select.option value="marketing" label="Marketing" />
                    <x-strata::select.option value="sales" label="Sales" />
                    <x-strata::select.option value="hr" label="Human Resources" />
                    <x-strata::select.option value="finance" label="Finance" />
                </x-strata::select>
                @error('department')
                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Skills Multi-Select with Search --}}
            <div>
                <label class="block text-sm font-medium text-foreground mb-1.5">
                    Skills & Technologies <span class="text-destructive">*</span>
                </label>
                <x-strata::select
                    wire:model.live="skills"
                    :multiple="true"
                    :searchable="true"
                    chips
                    :clearable="true"
                    placeholder="Select your skills"
                    :state="$errors->has('skills') ? 'error' : 'default'"
                >
                    <x-strata::select.option value="laravel" label="Laravel" />
                    <x-strata::select.option value="php" label="PHP" />
                    <x-strata::select.option value="javascript" label="JavaScript" />
                    <x-strata::select.option value="vue" label="Vue.js" />
                    <x-strata::select.option value="react" label="React" />
                    <x-strata::select.option value="alpine" label="Alpine.js" />
                    <x-strata::select.option value="tailwind" label="Tailwind CSS" />
                    <x-strata::select.option value="livewire" label="Livewire" />
                    <x-strata::select.option value="mysql" label="MySQL" />
                    <x-strata::select.option value="postgresql" label="PostgreSQL" />
                    <x-strata::select.option value="redis" label="Redis" />
                    <x-strata::select.option value="docker" label="Docker" />
                </x-strata::select>
                @error('skills')
                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Date & Time Information --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-foreground border-b pb-2">Date & Time Information</h2>

            {{-- Birth Date (Single Date Picker) --}}
            <div>
                <label class="block text-sm font-medium text-foreground mb-1.5">
                    Birth Date <span class="text-destructive">*</span>
                </label>
                <x-strata::date-picker
                    wire:model.live="birthDate"
                    mode="single"
                    placeholder="Select your birth date"
                    :max-date="now()->toDateString()"
                    :clearable="true"
                    :state="$errors->has('birthDate') ? 'error' : 'default'"
                />
                @error('birthDate')
                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                @enderror
                @if($birthDate)
                    <p class="text-xs text-muted-foreground mt-1">
                        Selected: {{ $birthDate->format('F j, Y') }} (Age: {{ $birthDate->toCarbon()->diffInYears(now()) }})
                    </p>
                @endif
            </div>

            {{-- Employment Period (Date Range Picker) --}}
            <div>
                <label class="block text-sm font-medium text-foreground mb-1.5">
                    Employment Period <span class="text-destructive">*</span>
                </label>
                <x-strata::date-picker
                    wire:model.live="employmentPeriod"
                    mode="range"
                    :show-presets="true"
                    placeholder="Select employment period"
                    :clearable="true"
                    :state="$errors->has('employmentPeriod') ? 'error' : 'default'"
                />
                @error('employmentPeriod')
                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                @enderror
                @if($employmentPeriod)
                    <p class="text-xs text-muted-foreground mt-1">
                        From: {{ $employmentPeriod->getStartDate()->format('M d, Y') }}
                        To: {{ $employmentPeriod->getEndDate()->format('M d, Y') }}
                        ({{ $employmentPeriod->getStartDate()->diffInDays($employmentPeriod->getEndDate()) }} days)
                    </p>
                @endif
            </div>

            {{-- Preferred Contact Time --}}
            <div>
                <label class="block text-sm font-medium text-foreground mb-1.5">
                    Preferred Contact Time <span class="text-destructive">*</span>
                </label>
                <x-strata::time-picker
                    wire:model.live="preferredContactTime"
                    format="12"
                    :step-minutes="15"
                    :show-presets="true"
                    placeholder="Select preferred time"
                    :clearable="true"
                    :disabled-times="$this->disabledTimes"
                    :state="$errors->has('preferredContactTime') ? 'error' : 'default'"
                />
                @error('preferredContactTime')
                    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                @enderror
                @if($preferredContactTime)
                    <p class="text-xs text-muted-foreground mt-1">
                        Selected: {{ $preferredContactTime->to12HourFormat() }} (24h: {{ $preferredContactTime->to24HourFormat() }})
                    </p>
                @endif
            </div>

            {{-- Info Box --}}
            <div class="p-4 bg-muted/50 rounded-lg border border-border">
                <h3 class="text-sm font-semibold text-foreground mb-2">Component Features:</h3>
                <ul class="text-xs text-muted-foreground space-y-1">
                    <li>✓ Select: Single + Multi with search & chips</li>
                    <li>✓ Date Picker: Single + Range with presets</li>
                    <li>✓ Time Picker: 12-hour format with disabled times</li>
                    <li>✓ All use wire:model for Livewire binding</li>
                    <li>✓ Value objects (DateValue, DateRange, TimeValue)</li>
                    <li>✓ Real-time validation</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center gap-3 pt-4 border-t">
        <x-strata::button
            wire:click="save"
            variant="primary"
            icon="check"
            :loading="$saving"
            :disabled="$saving"
        >
            {{ $saving ? 'Saving...' : 'Save Profile' }}
        </x-strata::button>

        <x-strata::button
            wire:click="clear"
            variant="secondary"
            appearance="outlined"
            icon="x"
            :disabled="$saving"
        >
            Clear Form
        </x-strata::button>

        @if($saved)
            <div class="flex-1 text-right">
                <span class="text-sm text-success font-medium">✓ Saved successfully</span>
            </div>
        @endif
    </div>

    {{-- Saved Data Display --}}
    @if($savedData)
        <div class="p-4 bg-muted/30 rounded-lg border border-border">
            <h3 class="text-sm font-semibold text-foreground mb-2">Saved Data (JSON):</h3>
            <pre class="text-xs text-muted-foreground overflow-x-auto">{{ $savedData }}</pre>
        </div>
    @endif

    {{-- Current State Debug (Development Only) --}}
    <details class="p-4 bg-muted/20 rounded-lg border border-border">
        <summary class="text-sm font-semibold text-foreground cursor-pointer">
            Current State (Debug)
        </summary>
        <div class="mt-3 space-y-2 text-xs text-muted-foreground">
            <div><strong>Name:</strong> {{ $name ?? 'null' }}</div>
            <div><strong>Email:</strong> {{ $email ?? 'null' }}</div>
            <div><strong>Department:</strong> {{ $department ?? 'null' }}</div>
            <div><strong>Skills:</strong> {{ json_encode($skills) }}</div>
            <div><strong>Birth Date:</strong> {{ $birthDate?->toDateString() ?? 'null' }}</div>
            <div><strong>Employment Period:</strong>
                @if($employmentPeriod)
                    {{ $employmentPeriod->getStartDate()->format('Y-m-d') }} to {{ $employmentPeriod->getEndDate()->format('Y-m-d') }}
                @else
                    null
                @endif
            </div>
            <div><strong>Contact Time:</strong> {{ $preferredContactTime?->to12HourFormat() ?? 'null' }}</div>
        </div>
    </details>
</div>
