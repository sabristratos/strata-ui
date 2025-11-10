/**
 * Global Alpine.js Magic Helpers and Directives
 *
 * Provides reusable Alpine utilities for all Strata UI components
 */

document.addEventListener('alpine:init', () => {
    /**
     * $__() - Translate a string
     * Usage: $__('Save')
     *
     * @param {string} key - Translation key
     * @param {Object} [replacements={}] - Key-value pairs for placeholder replacement
     * @returns {string} Translated string
     */
    Alpine.magic('__', () => {
        return (key, replacements = {}) => {
            const translations = window.__strataTranslations || {};
            let translation = translations[key] || key;

            Object.keys(replacements).forEach(placeholder => {
                translation = translation.replace(
                    new RegExp(`:${placeholder}|{${placeholder}}`, 'g'),
                    replacements[placeholder]
                );
            });

            return translation;
        };
    });

    /**
     * $__choice() - Translate a string with pluralization support
     * Usage: $__choice('{count} file|{count} files', count)
     *
     * @param {string} key - Translation key with | separator for plural forms
     * @param {number} count - The count to determine singular/plural
     * @param {Object} [replacements={}] - Additional key-value pairs for placeholder replacement
     * @returns {string} Translated string with proper plural form
     */
    Alpine.magic('__choice', () => {
        return (key, count, replacements = {}) => {
            const translations = window.__strataTranslations || {};
            let translation = translations[key] || key;

            const forms = translation.split('|').map(s => s.trim());

            if (forms.length === 1) {
                translation = forms[0];
            } else if (forms.length === 2) {
                translation = count === 1 ? forms[0] : forms[1];
            } else if (forms.length === 3) {
                if (count === 0) {
                    translation = forms[0];
                } else if (count === 1) {
                    translation = forms[1];
                } else {
                    translation = forms[2];
                }
            } else if (forms.length === 6) {
                const arabicPluralForm = getArabicPluralForm(count);
                translation = forms[arabicPluralForm] || forms[forms.length - 1];
            }

            const allReplacements = { count, ...replacements };
            Object.keys(allReplacements).forEach(placeholder => {
                translation = translation.replace(
                    new RegExp(`:${placeholder}|{${placeholder}}`, 'g'),
                    allReplacements[placeholder]
                );
            });

            return translation;
        };
    });

    /**
     * $locale() - Get current locale
     * Usage: $locale()
     *
     * @returns {string} Current locale code (e.g., 'en', 'fr', 'ar')
     */
    Alpine.magic('locale', () => {
        return () => window.__strataLocale || 'en';
    });

    /**
     * $isRTL() - Check if current locale is RTL
     * Usage: $isRTL()
     *
     * @returns {boolean} True if current locale is RTL
     */
    Alpine.magic('isRTL', () => {
        return () => {
            const rtlLocales = ['ar', 'he', 'fa', 'ur'];
            const currentLocale = window.__strataLocale || 'en';
            return rtlLocales.includes(currentLocale);
        };
    });

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

/**
 * Get the appropriate plural form index for Arabic
 *
 * @param {number} count - The count to determine plural form
 * @returns {number} Index of the plural form (0-5)
 */
function getArabicPluralForm(count) {
    if (count === 0) return 0;
    if (count === 1) return 1;
    if (count === 2) return 2;
    if (count % 100 >= 3 && count % 100 <= 10) return 3;
    if (count % 100 >= 11 && count % 100 <= 99) return 4;
    return 5;
}
