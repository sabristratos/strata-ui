import Entangleable from './entangleable.js';
import Positionable from './positionable.js';

if (typeof window !== 'undefined') {
    window.StrataEntangleable = Entangleable;
    window.StrataPositionable = Positionable;

    window.toast = function(options) {
        if (typeof options === 'string') {
            options = { description: options };
        }

        window.dispatchEvent(new CustomEvent('strata:toast', {
            detail: options
        }));
    };

    window.toast.success = function(title, description = null) {
        window.toast({
            variant: 'success',
            title: title,
            description: description
        });
    };

    window.toast.error = function(title, description = null) {
        window.toast({
            variant: 'error',
            title: title,
            description: description
        });
    };

    window.toast.warning = function(title, description = null) {
        window.toast({
            variant: 'warning',
            title: title,
            description: description
        });
    };

    window.toast.info = function(title, description = null) {
        window.toast({
            variant: 'info',
            title: title,
            description: description
        });
    };
}
