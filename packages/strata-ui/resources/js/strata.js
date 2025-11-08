/**
 * Strata UI - Main entry point
 *
 * Exports core utilities and helpers to window global scope.
 * Modules: Entangleable, Positionable, Image, Slider, Editor, DatePicker, TimePicker, ColorPicker, Lightbox, Toast API
 */

// CSS Anchor Positioning Polyfill
if (!CSS.supports('anchor-name', '--test')) {
    import('@oddbird/css-anchor-positioning');
}

import Entangleable from './entangleable.js';
import { createEntangleableMixin } from './entangleable-mixin.js';
import { createKeyboardNavigationMixin } from './keyboard-navigation-mixin.js';
import Image from './image.js';
import Slider from './slider.js';
import Editor from './editor.js';
import DatePicker from './date-picker.js';
import TimePicker from './time-picker.js';
import ColorPicker from './color-picker.js';
import RangeSlider from './range-slider.js';
import Select from './select.js';
import PhoneInput from './phone-input.js';
import popoverTrigger from './popover-trigger.js';
import './lightbox.js';
import './alpine-helpers.js';

document.addEventListener('alpine:init', () => {
    popoverTrigger(window.Alpine);
});

/**
 * @typedef {Object} ToastOptions
 * @property {string} [variant='default'] - Toast variant ('default'|'success'|'error'|'warning'|'info')
 * @property {string} [title] - Toast title
 * @property {string} [description] - Toast description/message
 * @property {number} [duration] - Auto-dismiss duration in milliseconds
 * @property {boolean} [dismissible=true] - Whether toast can be dismissed
 */

if (typeof window !== 'undefined') {
    /**
     * Bidirectional Alpine ↔ Livewire state synchronization
     * @type {typeof Entangleable}
     */
    window.StrataEntangleable = Entangleable;

    /**
     * Create Entangleable mixin for Alpine components
     * @type {function}
     */
    window.createEntangleableMixin = createEntangleableMixin;

    /**
     * Create Keyboard Navigation mixin for Alpine components
     * @type {function}
     */
    window.createKeyboardNavigationMixin = createKeyboardNavigationMixin;

    /**
     * Image component with loading/error states
     * @type {function}
     */
    window.StrataImage = Image;

    /**
     * Slider component with carousel and form modes
     * @type {function}
     */
    window.strataSlider = Slider;

    /**
     * Rich text editor component powered by Tiptap
     * @type {function}
     */
    window.strataEditor = Editor;

    /**
     * Date picker component with single/range modes and presets
     * @type {function}
     */
    window.strataDatePicker = DatePicker;

    /**
     * Time picker component with 12/24 hour formats and presets
     * @type {function}
     */
    window.strataTimePicker = TimePicker;

    /**
     * Color picker component with HSL/RGB picker and presets
     * @type {function}
     */
    window.strataColorPicker = ColorPicker;

    /**
     * Range slider component with dual handles for numeric ranges
     * @type {function}
     */
    window.strataRangeSlider = RangeSlider;

    /**
     * Select component with search, multi-select, and chips support
     * @type {function}
     */
    window.strataSelect = Select;

    /**
     * Phone input component with country selector and validation
     * @type {function}
     */
    window.strataPhoneInput = PhoneInput;

    /**
     * Display a toast notification
     *
     * @param {ToastOptions|string} options - Toast configuration or message string
     *
     * @example
     * // Simple message
     * window.toast('Item saved successfully');
     *
     * // Full options
     * window.toast({
     *     variant: 'success',
     *     title: 'Success',
     *     description: 'Item saved successfully',
     *     duration: 5000
     * });
     */
    window.toast = function(options) {
        if (typeof options === 'string') {
            options = { description: options };
        }

        window.dispatchEvent(new CustomEvent('strata:toast', {
            detail: options
        }));
    };

    /**
     * Display a success toast
     *
     * @param {string} title - Toast title
     * @param {string|null} [description=null] - Optional description
     *
     * @example
     * window.toast.success('Saved', 'Your changes have been saved');
     */
    window.toast.success = function(title, description = null) {
        window.toast({
            variant: 'success',
            title: title,
            description: description
        });
    };

    /**
     * Display an error toast
     *
     * @param {string} title - Toast title
     * @param {string|null} [description=null] - Optional description
     *
     * @example
     * window.toast.error('Failed', 'Could not save your changes');
     */
    window.toast.error = function(title, description = null) {
        window.toast({
            variant: 'error',
            title: title,
            description: description
        });
    };

    /**
     * Display a warning toast
     *
     * @param {string} title - Toast title
     * @param {string|null} [description=null] - Optional description
     *
     * @example
     * window.toast.warning('Warning', 'This action cannot be undone');
     */
    window.toast.warning = function(title, description = null) {
        window.toast({
            variant: 'warning',
            title: title,
            description: description
        });
    };

    /**
     * Display an info toast
     *
     * @param {string} title - Toast title
     * @param {string|null} [description=null] - Optional description
     *
     * @example
     * window.toast.info('Info', 'New features available');
     */
    window.toast.info = function(title, description = null) {
        window.toast({
            variant: 'info',
            title: title,
            description: description
        });
    };
}
