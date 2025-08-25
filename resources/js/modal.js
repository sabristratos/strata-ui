/**
 * Strata UI - Modal JavaScript API
 * 
 * Provides Alpine.js magic methods and global JavaScript API for modal components.
 * This script runs immediately when Alpine initializes, making the modal API
 * globally available regardless of whether modal components are rendered.
 */

// Register modal functionality with Alpine.js
function registerModalAPI(Alpine) {
    // Alpine data for modal component
    Alpine.data('strataModal', (config) => ({
        show: false,
        name: config.name || null,
        dismissible: config.dismissible !== false,

        init() {
            // Support wire:model binding
            if (this.$wire && this.$el.hasAttribute('x-model')) {
                this.$watch('show', value => {
                    this.$wire.set(this.$el.getAttribute('x-model'), value);
                });
            }
        },

        showModal(data = {}) {
            this.show = true;
            this.$dispatch('strata-modal-opened', { name: this.name, data });
            document.body.style.overflow = 'hidden';
        },

        hideModal() {
            this.show = false;
            this.$dispatch('strata-modal-closed', { name: this.name });
            this.$dispatch('close'); // For compatibility
            this.$dispatch('cancel'); // For compatibility  
            document.body.style.overflow = '';
        },

        toggleModal(data = {}) {
            if (this.show) {
                this.hideModal();
            } else {
                this.showModal(data);
            }
        }
    }));

    // Register Alpine magic method for $strata
    Alpine.magic('strata', (el) => ({
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
                    // Close all modals by dispatching hide events
                    document.querySelectorAll('[x-data*="strataModal"]').forEach(el => {
                        const modalName = el.getAttribute('x-data').match(/name:\s*'([^']*)'/)
                        if (modalName && modalName[1]) {
                            window.dispatchEvent(new CustomEvent(`strata-modal-hide-${modalName[1]}`));
                        } else {
                            // For unnamed modals, try to call hideModal directly
                            if (el.__x && el.__x.$data && el.__x.$data.hideModal) {
                                el.__x.$data.hideModal();
                            }
                        }
                    });
                    document.body.style.overflow = '';
                }
            };
        }
    }));
}

// Global Strata object for vanilla JavaScript API
function createGlobalStrataAPI() {
    window.Strata = window.Strata || {};
    
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
                    const modalName = el.getAttribute('x-data').match(/name:\s*'([^']*)'/)
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
}

// Initialize modal API when Alpine.js initializes
function initializeModalAPI() {
    // Wait for Alpine to be available
    if (window.Alpine) {
        registerModalAPI(window.Alpine);
        createGlobalStrataAPI();
    } else {
        // Alpine not ready yet, wait for it
        document.addEventListener('alpine:init', () => {
            registerModalAPI(window.Alpine);
            createGlobalStrataAPI();
        });
    }
}

// Initialize immediately if DOM is ready, otherwise wait
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeModalAPI);
} else {
    initializeModalAPI();
}

// Also listen for Alpine initializing event as backup
document.addEventListener('alpine:initializing', () => {
    registerModalAPI(window.Alpine);
    createGlobalStrataAPI();
});

// Handle session modals from Laravel
function handleSessionModals() {
    // Check if there's a session modal to show
    const sessionModalScript = document.querySelector('script[data-strata-session-modal]');
    if (sessionModalScript) {
        try {
            const modalData = JSON.parse(sessionModalScript.textContent);
            if (modalData.id) {
                // Delay slightly to ensure modals are rendered
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent(`strata-modal-show-${modalData.id}`, { detail: modalData }));
                }, 100);
            }
        } catch (e) {
            console.warn('Failed to parse session modal data:', e);
        }
    }
}

// Initialize session modal handling when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', handleSessionModals);
} else {
    handleSessionModals();
}

export { registerModalAPI, createGlobalStrataAPI };