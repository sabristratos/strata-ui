import { parsePhoneNumber, getExampleNumber, AsYouType, isValidPhoneNumber } from 'libphonenumber-js';
import examples from 'libphonenumber-js/mobile/examples';

export default function (props = {}) {
    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || null,
            inputSelector: '[data-strata-phone-input-value]',
            afterWatch: function(newValue) {
                console.log('[PhoneInput] afterWatch triggered', {
                    newValue,
                    lastSetValue: this.lastSetValue,
                    willParse: newValue && newValue !== this.lastSetValue,
                    activeElement: document.activeElement?.tagName
                });

                if (newValue && newValue !== this.lastSetValue) {
                    this.parseE164Value(newValue);
                }
            }
        }),

        countries: props.countries || [],
        initialCountry: props.initialCountry || null,
        placeholder: props.placeholder || 'Enter phone number',
        disabled: props.disabled || false,
        readonly: props.readonly || false,
        required: props.required || false,
        returnObject: props.returnObject || false,

        selectedCountry: null,
        selectedFlag: null,
        displayNumber: '',
        dialCode: '',
        currentPlaceholder: '',
        validationMessage: '',
        isValid: false,
        lastSetValue: null,
        countryDropdownOpen: false,
        countrySearch: '',
        highlightedIndex: -1,
        _countryObserver: null,

        get filteredCountries() {
            if (!this.countrySearch.trim()) {
                return this.countries;
            }
            const search = this.countrySearch.toLowerCase();
            return this.countries.filter(c =>
                c.label.toLowerCase().includes(search) ||
                c.dialCode.includes(search) ||
                c.value.toLowerCase().includes(search)
            );
        },

        get countriesMap() {
            if (!this._countriesMap) {
                this._countriesMap = new Map(this.countries.map(c => [c.value, c]));
            }
            return this._countriesMap;
        },

        init() {
            console.log('[PhoneInput] init START', {
                propsInitialValue: props.initialValue,
                activeElement: document.activeElement?.tagName
            });

            this.initEntangleable();

            this.$nextTick(() => {
                const initialValue = this.entangleable.value || props.initialValue;
                console.log('[PhoneInput] init $nextTick', {
                    entangleableValue: this.entangleable.value,
                    propsInitialValue: props.initialValue,
                    finalInitialValue: initialValue,
                    activeElement: document.activeElement?.tagName
                });

                if (initialValue) {
                    this.parseE164Value(initialValue);
                } else if (this.initialCountry) {
                    this.selectedCountry = this.initialCountry;
                    this.setSelectedFlag();
                    this.updateDialCodeAndPlaceholder();
                } else if (this.countries.length > 0) {
                    this.selectedCountry = this.countries[0].value;
                    this.setSelectedFlag();
                    this.updateDialCodeAndPlaceholder();
                }
            });

            this.disabled = this.$el?.dataset?.disabled === 'true';

            console.log('[PhoneInput] init END');

            this._countryObserver = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-disabled') {
                        this.disabled = this.$el?.dataset?.disabled === 'true';
                    }
                }
            });

            this._countryObserver.observe(this.$el, {
                attributes: true,
                attributeFilter: ['data-disabled']
            });

            this.$watch('selectedCountry', (newCountry) => {
                if (newCountry) {
                    this.updateDialCodeAndPlaceholder();
                    this.reformatNumber();
                }
            });

            this.$watch('countrySearch', () => {
                this.highlightedIndex = this.filteredCountries.length > 0 ? 0 : -1;
            });

            this.$watch('countryDropdownOpen', (isOpen) => {
                if (isOpen) {
                    this.highlightedIndex = this.filteredCountries.findIndex(c => c.value === this.selectedCountry);
                    if (this.highlightedIndex === -1 && this.filteredCountries.length > 0) {
                        this.highlightedIndex = 0;
                    }
                    this.$nextTick(() => {
                        const searchInput = this.$el.querySelector('[data-strata-phone-country-search]');
                        if (searchInput) {
                            searchInput.focus();
                        }
                    });
                }
            });

            this.$nextTick(() => {
                const flagButton = this.$el.querySelector('[data-strata-phone-flag-button]');
                if (flagButton) {
                    flagButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.toggleCountryDropdown();
                    });
                }
            });
        },

        parseE164Value(e164Value) {
            console.log('[PhoneInput] parseE164Value START', {
                e164Value,
                currentDisplayNumber: this.displayNumber,
                activeElement: document.activeElement?.tagName
            });

            if (!e164Value || e164Value.trim() === '') {
                this.displayNumber = '';
                this.validationMessage = '';
                this.isValid = false;
                console.log('[PhoneInput] parseE164Value - cleared (empty input)');
                return;
            }

            try {
                const phoneNumber = parsePhoneNumber(e164Value);

                if (phoneNumber) {
                    const countryCode = phoneNumber.country;
                    const country = this.countriesMap.get(countryCode);

                    if (country) {
                        this.selectedCountry = country.value;
                        this.selectedFlag = country.flag;
                        this.dialCode = country.dialCode;
                        this.displayNumber = phoneNumber.nationalNumber;
                        this.updatePlaceholder();
                        this.validateNumber();

                        console.log('[PhoneInput] parseE164Value - parsed successfully', {
                            newDisplayNumber: this.displayNumber,
                            country: this.selectedCountry,
                            activeElement: document.activeElement?.tagName
                        });
                    }
                }
            } catch (error) {
                console.warn('[PhoneInput] Failed to parse phone number:', error);
            }

            console.log('[PhoneInput] parseE164Value END');
        },

        setSelectedFlag() {
            const country = this.countriesMap.get(this.selectedCountry);
            if (country) {
                this.selectedFlag = country.flag;
            }
        },

        updateDialCodeAndPlaceholder() {
            const country = this.countriesMap.get(this.selectedCountry);
            if (country) {
                this.dialCode = country.dialCode;
                this.updatePlaceholder();
            }
        },

        updatePlaceholder() {
            const country = this.countriesMap.get(this.selectedCountry);
            if (!country) {
                this.currentPlaceholder = this.placeholder;
                return;
            }

            try {
                const exampleNumber = getExampleNumber(this.selectedCountry, examples);
                if (exampleNumber) {
                    this.currentPlaceholder = exampleNumber.formatNational().replace(country.dialCode, '').trim();
                } else {
                    this.currentPlaceholder = this.placeholder;
                }
            } catch (error) {
                this.currentPlaceholder = this.placeholder;
            }
        },

        handleNumberInput(event) {
            console.log('[PhoneInput] handleNumberInput START', {
                inputValue: event.target.value,
                displayNumber: this.displayNumber,
                activeElement: document.activeElement?.tagName,
                hasWireIgnore: event.target.hasAttribute('wire:ignore')
            });

            const inputValue = event.target.value;

            if (inputValue.startsWith('+')) {
                this.detectCountryFromNumber(inputValue);
            } else {
                this.reformatNumber();
            }

            this.validateNumber();

            if (this._syncTimeout) {
                clearTimeout(this._syncTimeout);
            }

            this._syncTimeout = setTimeout(() => {
                this.updateE164Value();
            }, 300);

            console.log('[PhoneInput] handleNumberInput END', {
                displayNumber: this.displayNumber,
                activeElement: document.activeElement?.tagName
            });
        },

        detectCountryFromNumber(value) {
            if (!value.startsWith('+')) return;

            try {
                const phoneNumber = parsePhoneNumber(value);
                if (phoneNumber && phoneNumber.country) {
                    const detectedCountry = this.countriesMap.get(phoneNumber.country);
                    if (detectedCountry) {
                        this.selectedCountry = detectedCountry.value;
                        this.selectedFlag = detectedCountry.flag;
                        this.dialCode = detectedCountry.dialCode;
                        this.displayNumber = phoneNumber.nationalNumber;
                        this.updatePlaceholder();
                    }
                }
            } catch (error) {
            }
        },

        reformatNumber() {
            if (!this.displayNumber || this.displayNumber.trim() === '') {
                return;
            }

            const country = this.countriesMap.get(this.selectedCountry);
            if (!country) return;

            try {
                const formatter = new AsYouType(this.selectedCountry);
                const formatted = formatter.input(this.displayNumber);

                const nationalFormatted = formatted.replace(country.dialCode, '').trim();

                if (nationalFormatted !== this.displayNumber) {
                    this.displayNumber = nationalFormatted;
                }
            } catch (error) {
            }
        },

        validateNumber() {
            if (!this.displayNumber || this.displayNumber.trim() === '') {
                this.validationMessage = this.required ? 'Phone number is required' : '';
                this.isValid = false;
                return;
            }

            const country = this.countriesMap.get(this.selectedCountry);
            if (!country) {
                this.validationMessage = 'Please select a country';
                this.isValid = false;
                return;
            }

            const fullNumber = `${country.dialCode}${this.displayNumber.replace(/\D/g, '')}`;

            try {
                const valid = isValidPhoneNumber(fullNumber, this.selectedCountry);
                this.isValid = valid;
                this.validationMessage = '';
            } catch (error) {
                this.isValid = false;
                this.validationMessage = 'Invalid phone number format';
            }
        },

        updateE164Value() {
            console.log('[PhoneInput] updateE164Value START', {
                displayNumber: this.displayNumber,
                selectedCountry: this.selectedCountry,
                activeElement: document.activeElement?.tagName
            });

            if (!this.displayNumber || this.displayNumber.trim() === '') {
                this.lastSetValue = null;
                this.entangleable.set(null);
                console.log('[PhoneInput] updateE164Value - cleared (empty)');
                return;
            }

            const country = this.countriesMap.get(this.selectedCountry);
            if (!country) return;

            const cleanNumber = this.displayNumber.replace(/\D/g, '');
            const fullNumber = `${country.dialCode}${cleanNumber}`;

            if (this.returnObject) {
                try {
                    const phoneNumber = parsePhoneNumber(fullNumber, this.selectedCountry);

                    const objectValue = {
                        e164: phoneNumber && phoneNumber.isValid() ? phoneNumber.format('E.164') : fullNumber,
                        country: this.selectedCountry,
                        countryCallingCode: country.dialCode.replace('+', ''),
                        nationalNumber: cleanNumber,
                        national: phoneNumber ? phoneNumber.formatNational() : this.displayNumber,
                        international: phoneNumber ? phoneNumber.formatInternational() : fullNumber,
                        uri: phoneNumber && phoneNumber.isValid() ? phoneNumber.getURI() : `tel:${fullNumber}`,
                        isValid: phoneNumber ? phoneNumber.isValid() : false,
                        isPossible: phoneNumber ? phoneNumber.isPossible() : false,
                    };

                    this.lastSetValue = objectValue;
                    this.entangleable.set(objectValue);
                } catch (error) {
                    const objectValue = {
                        e164: fullNumber,
                        country: this.selectedCountry,
                        countryCallingCode: country.dialCode.replace('+', ''),
                        nationalNumber: cleanNumber,
                        national: this.displayNumber,
                        international: fullNumber,
                        uri: `tel:${fullNumber}`,
                        isValid: false,
                        isPossible: false,
                    };

                    this.lastSetValue = objectValue;
                    this.entangleable.set(objectValue);
                }
            } else {
                try {
                    const phoneNumber = parsePhoneNumber(fullNumber, this.selectedCountry);
                    if (phoneNumber && phoneNumber.isValid()) {
                        const e164Value = phoneNumber.format('E.164');
                        this.lastSetValue = e164Value;
                        this.entangleable.set(e164Value);
                    } else {
                        this.lastSetValue = fullNumber;
                        this.entangleable.set(fullNumber);
                    }
                } catch (error) {
                    this.lastSetValue = fullNumber;
                    this.entangleable.set(fullNumber);
                }
            }

            console.log('[PhoneInput] updateE164Value END', {
                lastSetValue: this.lastSetValue,
                activeElement: document.activeElement?.tagName
            });
        },

        handleKeydown(event) {
            if (event.key === 'Enter' && this.isValid) {
                this.$refs.phoneNumberInput?.blur();
            }
        },

        toggleCountryDropdown() {
            if (this.isDisabled()) {
                return;
            }

            const dropdown = this.$refs.countryDropdown;
            if (dropdown) {
                dropdown.togglePopover();
            }
        },

        closeCountryDropdown() {
            const dropdown = this.$refs.countryDropdown;
            if (dropdown) {
                dropdown.hidePopover();
            }
            this.countrySearch = '';
            this.highlightedIndex = -1;
        },

        handleDropdownKeydown(event) {
            if (!this.countryDropdownOpen || this.filteredCountries.length === 0) return;

            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    this.highlightedIndex = Math.min(this.highlightedIndex + 1, this.filteredCountries.length - 1);
                    this.scrollToHighlighted();
                    break;

                case 'ArrowUp':
                    event.preventDefault();
                    this.highlightedIndex = Math.max(this.highlightedIndex - 1, 0);
                    this.scrollToHighlighted();
                    break;

                case 'Home':
                    event.preventDefault();
                    this.highlightedIndex = 0;
                    this.scrollToHighlighted();
                    break;

                case 'End':
                    event.preventDefault();
                    this.highlightedIndex = this.filteredCountries.length - 1;
                    this.scrollToHighlighted();
                    break;

                case 'Enter':
                case ' ':
                    event.preventDefault();
                    if (this.highlightedIndex >= 0 && this.highlightedIndex < this.filteredCountries.length) {
                        this.selectCountry(this.filteredCountries[this.highlightedIndex]);
                    }
                    break;
            }
        },

        scrollToHighlighted() {
            this.$nextTick(() => {
                const options = this.$el.querySelectorAll('[data-strata-phone-country-option]');
                if (options[this.highlightedIndex]) {
                    options[this.highlightedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                }
            });
        },

        selectCountry(country) {
            this.selectedCountry = country.value;
            this.selectedFlag = country.flag;
            this.dialCode = country.dialCode;
            this.updatePlaceholder();
            this.reformatNumber();

            if (this.displayNumber && this.displayNumber.trim() !== '') {
                this.validateNumber();
            } else {
                this.validationMessage = '';
                this.isValid = false;
            }

            this.updateE164Value();
            this.closeCountryDropdown();
        },

        isDisabled() {
            return this.disabled === true || this.readonly === true;
        },

        clear() {
            this.displayNumber = '';
            this.validationMessage = '';
            this.isValid = false;
            this.lastSetValue = null;
            this.entangleable.set(null);
        },

        destroy() {
            if (this.entangleable) {
                this.entangleable.destroy();
            }
            if (this._countryObserver) {
                this._countryObserver.disconnect();
            }
        },
    };
}
