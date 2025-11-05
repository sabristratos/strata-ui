{{--
/**
 * Sidebar User Menu Component
 *
 * Pre-made user dropdown menu for sidebar footer with avatar, name, email, and rotating chevron.
 *
 * @props
 * @prop string $name - User's display name (default: null)
 * @prop string $email - User's email address (default: null)
 * @prop string $avatar - Avatar image URL (default: null)
 * @prop string $fallback - Fallback initials for avatar (default: null)
 * @prop string $placement - Dropdown placement (default: 'top-start')
 *
 * @slots
 * @slot default - Dropdown menu content (dropdown items)
 *
 * @example
 * <x-strata::sidebar.user-menu name="John Doe" email="john@example.com" fallback="JD">
 *     <x-strata::dropdown.label>My Account</x-strata::dropdown.label>
 *     <x-strata::dropdown.item icon="user">Profile</x-strata::dropdown.item>
 *     <x-strata::dropdown.item icon="settings">Settings</x-strata::dropdown.item>
 *     <x-strata::dropdown.divider />
 *     <x-strata::dropdown.item icon="log-out">Logout</x-strata::dropdown.item>
 * </x-strata::sidebar.user-menu>
 */
--}}

@props([
    'name' => null,
    'email' => null,
    'avatar' => null,
    'fallback' => null,
    'placement' => 'top-start',
])

@php
use Stratos\StrataUI\Support\ComponentHelpers;

$menuId = ComponentHelpers::generateId('sidebar-user-menu', null, null);
@endphp

<x-strata::dropdown :id="$menuId" :placement="$placement" class="w-full">
    <x-strata::dropdown.trigger :data-dropdown-trigger="$menuId" class="w-full">
        <button
            x-data="{
                dropdownElement: null,
                init() {
                    this.$nextTick(() => {
                        this.dropdownElement = this.$el.closest('[data-strata-dropdown]');
                    });
                },
                get isOpen() {
                    return this.dropdownElement?.__x?.$data?.open || false;
                }
            }"
            class="w-full flex items-center gap-3 px-3 py-2 rounded-md hover:bg-sidebar-hover transition-colors"
        >
            @if($avatar || $fallback)
            <x-strata::avatar
                :src="$avatar"
                :fallback="$fallback"
                size="sm"
                class="bg-primary text-primary-foreground"
            />
            @endif

            <div
                :class="{
                    'opacity-0 w-0 overflow-hidden': collapsed && !isMobile,
                    'opacity-100 flex-1': !collapsed || isMobile
                }"
                class="min-w-0 text-left transition-all duration-150"
            >
                @if($name)
                <p class="text-sm font-medium truncate">{{ $name }}</p>
                @endif
                @if($email)
                <p class="text-xs text-muted-foreground truncate">{{ $email }}</p>
                @endif
            </div>

            <span
                :class="{
                    'opacity-0 w-0 overflow-hidden': collapsed && !isMobile,
                    'opacity-100': !collapsed || isMobile,
                    'rotate-180': isOpen,
                    'rotate-0': !isOpen
                }"
                class="flex items-center justify-center flex-shrink-0 w-4 h-4 transition-all duration-150 origin-center"
            >
                <x-strata::icon.chevron-up class="w-4 h-4" />
            </span>
        </button>
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        {{ $slot }}
    </x-strata::dropdown.content>
</x-strata::dropdown>
