/**
 * Global Alpine.js Magic Helpers and Directives
 *
 * Provides reusable Alpine utilities for all Strata UI components
 */

document.addEventListener('alpine:init', () => {
    /**
     * $closePopover() - Close the nearest ancestor popover
     * Usage: @click="$closePopover()"
     */
    Alpine.magic('closePopover', (el) => {
        return () => {
            const popoverContent = el.closest('[data-strata-popover-content]');
            if (popoverContent) {
                popoverContent.hidePopover();
            }
        };
    });

    /**
     * $closeDropdown() - Close the nearest ancestor dropdown
     * Usage: @click="$closeDropdown()"
     */
    Alpine.magic('closeDropdown', (el) => {
        return () => {
            const dropdownContent = el.closest('[data-strata-dropdown-content]');
            if (dropdownContent) {
                dropdownContent.hidePopover();
            }
        };
    });

    /**
     * $closeModal() - Close the nearest ancestor modal/dialog
     * Usage: @click="$closeModal()"
     */
    Alpine.magic('closeModal', (el) => {
        return () => {
            const dialog = el.closest('dialog[open]');
            if (dialog) {
                dialog.close();
            }
        };
    });
});
