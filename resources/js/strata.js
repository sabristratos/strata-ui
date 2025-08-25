/**
 * Strata UI - Main JavaScript Bundle
 * 
 * This file provides Alpine.js with necessary plugins for Strata UI components.
 * It intelligently detects if Alpine.js is already loaded (e.g., by Livewire)
 * and avoids conflicts while ensuring required plugins are available.
 */

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import anchor from '@alpinejs/anchor'
import focus from '@alpinejs/focus'

// Register core plugins with our Alpine instance (for standalone mode)
Alpine.plugin(collapse)
Alpine.plugin(anchor)
Alpine.plugin(focus)

/**
 * Safely register a plugin if it's not already registered
 * @param {Object} Alpine - The Alpine.js instance
 * @param {Function} plugin - The plugin to register
 * @param {string} pluginName - The name of the plugin for checking registration
 */
function registerPluginSafely(Alpine, plugin, pluginName) {
    const alreadyRegistered = 
        (pluginName === 'collapse' && Alpine.directive && Alpine.directive.collapse) ||
        (pluginName === 'anchor' && Alpine.anchor) ||
        (pluginName === 'focus' && Alpine.$focus) ||
        false;
    
    if (!alreadyRegistered) {
        Alpine.plugin(plugin)
    }
}


/**
 * Register Strata magic methods and global API
 */
function registerStrataAPI() {
    
    if (typeof Alpine !== 'undefined') {
        Alpine.magic('strata', (el) => ({
            // Modal functionality
            modal(name) {
                return {
                    show(data = {}) {
                        window.dispatchEvent(new CustomEvent(`strata-modal-show-${name}`, { detail: data }));
                    },
                    hide() {
                        window.dispatchEvent(new CustomEvent(`strata-modal-hide-${name}`));
                    },
                    toggle(data = {}) {
                        window.dispatchEvent(new CustomEvent(`strata-modal-toggle-${name}`, { detail: data }));
                    }
                };
            },
            modals() {
                return {
                    close() {
                        document.querySelectorAll('[x-data*="strataModal"]').forEach(el => {
                            const modalName = el.getAttribute('x-data').match(/name:\s*'([^']*)'/);
                            if (modalName && modalName[1]) {
                                window.dispatchEvent(new CustomEvent(`strata-modal-hide-${modalName[1]}`));
                            } else {
                                if (el.__x && el.__x.$data && el.__x.$data.hideModal) {
                                    el.__x.$data.hideModal();
                                }
                            }
                        });
                        document.body.style.overflow = '';
                    }
                };
            },
            // Toast functionality
            toast(detail) {
                window.dispatchEvent(new CustomEvent('strata-toast-show', { detail }));
            }
        }));
    } else {
    }

    window.Strata = window.Strata || {};
    
    // Modal API
    window.Strata.modal = function(name) {
        return {
            show(data = {}) {
                window.dispatchEvent(new CustomEvent(`strata-modal-show-${name}`, { detail: data }));
            },
            hide() {
                window.dispatchEvent(new CustomEvent(`strata-modal-hide-${name}`));
            },
            toggle(data = {}) {
                window.dispatchEvent(new CustomEvent(`strata-modal-toggle-${name}`, { detail: data }));
            }
        };
    };

    window.Strata.modals = function() {
        return {
            close() {
                document.querySelectorAll('[x-data*="strataModal"]').forEach(el => {
                    const modalName = el.getAttribute('x-data').match(/name:\s*'([^']*)'/);
                    if (modalName && modalName[1]) {
                        window.dispatchEvent(new CustomEvent(`strata-modal-hide-${modalName[1]}`));
                    } else {
                        if (el.__x && el.__x.$data && el.__x.$data.hideModal) {
                            el.__x.$data.hideModal();
                        }
                    }
                });
                document.body.style.overflow = '';
            }
        };
    };

    // Toast API
    window.Strata.toast = function(detail) {
        window.dispatchEvent(new CustomEvent('strata-toast-show', { detail }));
    };
    
}

/**
 * Initialize Strata UI (fallback for non-Livewire scenarios)
 */
function initializeStrataUI() {
    
    if (window.Alpine) {
        registerPluginSafely(window.Alpine, collapse, 'collapse')
        registerPluginSafely(window.Alpine, anchor, 'anchor')
        registerPluginSafely(window.Alpine, focus, 'focus')
    } else {
        window.Alpine = Alpine
        Alpine.start()
    }
}

document.addEventListener('alpine:init', () => {
    
    window.Strata = window.Strata || {};
    
    // Modal API
    window.Strata.modal = function(name) {
        return {
            show(data = {}) {
                window.dispatchEvent(new CustomEvent(`strata-modal-show-${name}`, { detail: data }));
            },
            hide() {
                window.dispatchEvent(new CustomEvent(`strata-modal-hide-${name}`));
            },
            toggle(data = {}) {
                window.dispatchEvent(new CustomEvent(`strata-modal-toggle-${name}`, { detail: data }));
            }
        };
    };

    window.Strata.modals = function() {
        return {
            close() {
                document.querySelectorAll('[x-data*="strataModal"]').forEach(el => {
                    const modalName = el.getAttribute('x-data').match(/name:\s*'([^']*)'/);
                    if (modalName && modalName[1]) {
                        window.dispatchEvent(new CustomEvent(`strata-modal-hide-${modalName[1]}`));
                    } else {
                        if (el.__x && el.__x.$data && el.__x.$data.hideModal) {
                            el.__x.$data.hideModal();
                        }
                    }
                });
                document.body.style.overflow = '';
            }
        };
    };

    // Toast API
    window.Strata.toast = function(detail) {
        window.dispatchEvent(new CustomEvent('strata-toast-show', { detail }));
    };
    
});

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeStrataUI)
} else {
    initializeStrataUI()
}

export default Alpine