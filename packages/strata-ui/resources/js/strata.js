/**
 * Strata UI - Main entry point
 *
 * Exports core utilities and helpers to window global scope.
 * Modules: Entangleable, Positionable, Image, Slider, Lightbox, Toast API
 */

import Entangleable from './entangleable.js';
import Positionable from './positionable.js';
import Image from './image.js';
import Slider from './slider.js';
import Editor from './editor.js';
import './lightbox.js';

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
     * Floating UI positioning for dropdowns/popovers/tooltips
     * @type {typeof Positionable}
     */
    window.StrataPositionable = Positionable;

    /**
     * Image component with loading/error states
     * @type {function}
     */
    window.StrataImage = Image;

    /**
     * Slider component with carousel and form modes
     * @type {typeof Slider}
     */
    window.StrataSlider = Slider;

    /**
     * Rich text editor component powered by Tiptap
     * @type {function}
     */
    window.strataEditor = Editor;

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
