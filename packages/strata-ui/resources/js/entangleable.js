export default class Entangleable {
    constructor(initialValue = null) {
        this.value = initialValue;
        this.watchers = [];
        this.component = null;
        this.wireModelProperty = null;
        this.alpineModelProperty = null;
    }

    watch(callback) {
        this.watchers.push(callback);
        return this;
    }

    set(value) {
        const oldValue = this.value;
        this.value = value;

        if (JSON.stringify(oldValue) !== JSON.stringify(value)) {
            this.notifyWatchers(value, oldValue);
            this.syncToLivewire();
        }
    }

    get() {
        return this.value;
    }

    notifyWatchers(newValue, oldValue) {
        this.watchers.forEach(callback => callback(newValue, oldValue));
    }

    syncToLivewire() {
        if (this.component?.$wire && this.wireModelProperty) {
            this.component.$wire.set(this.wireModelProperty, this.value);
        }
    }

    syncFromLivewire() {
        if (this.component?.$wire && this.wireModelProperty) {
            const serverValue = this.component.$wire.get(this.wireModelProperty);
            if (serverValue !== undefined) {
                this.value = serverValue;
                this.notifyWatchers(this.value, null);
            }
        }
    }

    setupLivewire(component, inputElement) {
        if (!inputElement) return;

        const wireModelAttribute = Array.from(inputElement.getAttributeNames())
            .find(attr => attr.startsWith('wire:model'));

        if (!wireModelAttribute) return;

        this.component = component;

        if (!component.$wire) return;

        this.wireModelProperty = inputElement.getAttribute(wireModelAttribute);

        this.syncFromLivewire();

        component.$wire.$watch(this.wireModelProperty, (value) => {
            if (JSON.stringify(this.value) !== JSON.stringify(value)) {
                const oldValue = this.value;
                this.value = value;
                this.notifyWatchers(value, oldValue);
            }
        });
    }

    setupAlpine(component, modelProperty) {
        this.component = component;
        this.alpineModelProperty = modelProperty;

        if (modelProperty && component[modelProperty] !== undefined) {
            this.value = component[modelProperty];
        }

        this.watch((newValue) => {
            if (modelProperty && component[modelProperty] !== newValue) {
                component[modelProperty] = newValue;
            }
        });
    }

    destroy() {
        this.watchers = [];
        this.component = null;
        this.wireModelProperty = null;
        this.alpineModelProperty = null;
        this.value = null;
    }
}
