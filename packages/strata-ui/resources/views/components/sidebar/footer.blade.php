{{--
/**
 * Sidebar Footer Component
 *
 * Sticky footer section for sidebar, commonly used for user profile, settings, or actions.
 *
 * @slots
 * @slot default - Footer content (user profile, settings, actions)
 *
 * @example Basic footer
 * <x-strata::sidebar.footer>
 *     <button class="w-full px-3 py-2">Settings</button>
 * </x-strata::sidebar.footer>
 *
 * @example User profile
 * <x-strata::sidebar.footer>
 *     <div class="flex items-center gap-3 px-3 py-2">
 *         <x-strata::avatar src="/avatar.jpg" alt="John Doe" size="sm" />
 *         <div class="flex-1 min-w-0">
 *             <p class="text-sm font-medium truncate">John Doe</p>
 *             <p class="text-xs text-muted-foreground truncate">john@example.com</p>
 *         </div>
 *     </div>
 * </x-strata::sidebar.footer>
 */
--}}

<div
    {{ $attributes->merge([
        'class' => 'flex-shrink-0 border-t border-sidebar-border px-3 py-4'
    ]) }}
    data-strata-sidebar-footer
>
    <div
        x-show="!collapsed || isMobile"
        x-transition.opacity.duration.150ms
    >
        {{ $slot }}
    </div>
</div>
