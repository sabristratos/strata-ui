/**
 * Alpine.js directive for triggering popovers
 *
 * Usage: x-popover-trigger="popoverId"
 *
 * This directive allows any element to trigger a popover, not just buttons.
 * It handles clicks, keyboard events, and syncs with Alpine state.
 */
export default function popoverTrigger(Alpine) {
    Alpine.directive('popover-trigger', (el, { expression }, { evaluate, cleanup }) => {
        // Helper function to get the popover element on-demand
        // This ensures we always get the current element, even if the DOM changes
        const getPopoverElement = () => {
            const popoverId = evaluate(expression);

            if (!popoverId) {
                console.warn('[Popover Trigger] No popover ID provided');
                return null;
            }

            const popoverEl = document.getElementById(popoverId);

            if (!popoverEl) {
                console.warn('[Popover Trigger] Popover element not found with ID:', popoverId);
            }

            return popoverEl;
        };

        // Handle click events
        const handleClick = (e) => {
            const popoverEl = getPopoverElement();

            if (!popoverEl) {
                console.error('[Popover Trigger] No popover element found');
                return;
            }

            try {
                popoverEl.togglePopover();
            } catch (error) {
                console.error('[Popover Trigger] Error toggling popover:', error);
            }
        };

        // Handle keyboard events (Enter/Space) for accessibility
        const handleKeydown = (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();

                const popoverEl = getPopoverElement();

                if (!popoverEl) {
                    console.error('[Popover Trigger] No popover element found for keyboard event');
                    return;
                }

                try {
                    popoverEl.togglePopover();
                } catch (error) {
                    console.error('[Popover Trigger] Error toggling popover:', error);
                }
            }
        };

        // Attach event listeners
        el.addEventListener('click', handleClick);
        el.addEventListener('keydown', handleKeydown);

        // Make element focusable if it isn't already and has no tabindex
        if (!el.hasAttribute('tabindex') && el.tagName !== 'BUTTON' && el.tagName !== 'A') {
            el.setAttribute('tabindex', '0');
        }

        // Cleanup on unmount
        cleanup(() => {
            el.removeEventListener('click', handleClick);
            el.removeEventListener('keydown', handleKeydown);
        });
    });
}
