import { computePosition, autoUpdate, flip, shift, offset } from '@floating-ui/dom';

export default class Positionable {
    static instances = new Set();

    constructor(config = {}) {
        this.config = {
            placement: config.placement || 'bottom-start',
            offset: config.offset || 8,
            strategy: config.strategy || 'absolute',
            ...config
        };
        this.cleanup = null;
        this.reference = null;
        this.floating = null;
        this.component = null;
        this.state = false;
        this.styles = {};
        this.wrapperElement = null;
    }

    start(component, reference, floating) {
        this.component = component;
        this.reference = reference;
        this.floating = floating;
        this.wrapperElement = component.$el;

        Positionable.instances.add(this);

        this.compute();

        this.watch(state => {
            if (state && window.innerWidth >= 640 && !this.cleanup) {
                this.component.$nextTick(() => this.syncPosition());
            }

            if (!state && this.cleanup) {
                this.cleanup();
                this.cleanup = null;
            }
        });

        return this;
    }

    watch(callback) {
        queueMicrotask(() => {
            this.component.$watch(() => this.state, (value) => callback(value));
        });
        return this;
    }

    syncPosition() {
        if (window.innerWidth < 640) {
            return;
        }

        this.cleanup = autoUpdate(
            this.reference,
            this.floating,
            () => this.compute()
        );
    }

    compute() {
        if (!this.reference || !this.floating) {
            return;
        }

        computePosition(this.reference, this.floating, {
            placement: this.config.placement,
            strategy: this.config.strategy,
            middleware: [
                offset(this.config.offset),
                flip({ padding: 5 }),
                shift({ padding: 5 })
            ]
        }).then(({ x, y }) => {
            this.styles = {
                position: this.config.strategy,
                left: `${x}px`,
                top: `${y}px`
            };
        });
    }

    open() {
        this.closeConflictingInstances();
        this.compute();
        this.component.$nextTick(() => {
            this.state = true;
        });
    }

    openIfClosed() {
        if (!this.state) {
            this.open();
        }
    }

    close() {
        this.state = false;
    }

    toggle() {
        if (this.state) {
            this.close();
        } else {
            this.open();
        }
    }

    closeConflictingInstances() {
        Positionable.instances.forEach(instance => {
            if (instance === this || !instance.state) {
                return;
            }

            const isAncestor = instance.wrapperElement?.contains(this.wrapperElement);
            const isDescendant = this.wrapperElement?.contains(instance.wrapperElement);

            if (!isAncestor && !isDescendant) {
                instance.close();
            }
        });
    }

    destroy() {
        if (this.cleanup) {
            this.cleanup();
            this.cleanup = null;
        }
        Positionable.instances.delete(this);
    }
}
