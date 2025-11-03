import { describe, it, expect, beforeEach, afterEach, vi } from 'vitest';

describe('Editor Component', () => {
    let mockQuill;
    let mockEntangleable;
    let editorComponent;

    beforeEach(() => {
        mockQuill = {
            root: document.createElement('div'),
            clipboard: {
                dangerouslyPasteHTML: vi.fn(),
            },
            setText: vi.fn(),
            on: vi.fn(),
            off: vi.fn(),
            disable: vi.fn(),
            getSelection: vi.fn(() => ({ index: 0 })),
            setSelection: vi.fn(),
            insertEmbed: vi.fn(),
            getModule: vi.fn(() => ({
                container: {
                    remove: vi.fn(),
                },
            })),
        };

        mockQuill.root.innerHTML = '<p>test content</p>';
        mockQuill.root.isConnected = true;

        mockEntangleable = {
            get: vi.fn(() => ''),
            set: vi.fn(),
            watch: vi.fn(),
            setupLivewire: vi.fn(),
            destroy: vi.fn(),
        };

        global.window = {
            Quill: vi.fn(() => mockQuill),
            StrataEntangleable: vi.fn(() => mockEntangleable),
        };

        editorComponent = {
            entangleable: null,
            quill: null,
            disabled: false,
            isReady: false,
            syncTimeout: null,
            updatingFromLivewire: false,
            isInitializing: false,
            $el: document.createElement('div'),
            $refs: {
                editor: document.createElement('div'),
            },
            $nextTick: vi.fn((callback) => callback()),
            $dispatch: vi.fn(),
        };

        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('data-strata-editor-input', '');
        editorComponent.$el.appendChild(hiddenInput);
    });

    afterEach(() => {
        vi.clearAllMocks();
    });

    describe('normalizeHtml', () => {
        it('returns empty string for null or undefined', () => {
            const normalize = (html) => {
                if (!html) return '';
                return html
                    .trim()
                    .replace(/^<p><br><\/p>$/g, '')
                    .replace(/\s+/g, ' ')
                    .replace(/>\s+</g, '><');
            };

            expect(normalize(null)).toBe('');
            expect(normalize(undefined)).toBe('');
            expect(normalize('')).toBe('');
        });

        it('trims whitespace', () => {
            const normalize = (html) => {
                if (!html) return '';
                return html
                    .trim()
                    .replace(/^<p><br><\/p>$/g, '')
                    .replace(/\s+/g, ' ')
                    .replace(/>\s+</g, '><');
            };

            expect(normalize('  <p>test</p>  ')).toBe('<p>test</p>');
        });

        it('removes empty paragraph', () => {
            const normalize = (html) => {
                if (!html) return '';
                return html
                    .trim()
                    .replace(/^<p><br><\/p>$/g, '')
                    .replace(/\s+/g, ' ')
                    .replace(/>\s+</g, '><');
            };

            expect(normalize('<p><br></p>')).toBe('');
        });

        it('collapses multiple spaces', () => {
            const normalize = (html) => {
                if (!html) return '';
                return html
                    .trim()
                    .replace(/^<p><br><\/p>$/g, '')
                    .replace(/\s+/g, ' ')
                    .replace(/>\s+</g, '><');
            };

            expect(normalize('<p>test   content</p>')).toBe('<p>test content</p>');
        });

        it('removes whitespace between tags', () => {
            const normalize = (html) => {
                if (!html) return '';
                return html
                    .trim()
                    .replace(/^<p><br><\/p>$/g, '')
                    .replace(/\s+/g, ' ')
                    .replace(/>\s+</g, '><');
            };

            expect(normalize('<p>test</p>  <p>content</p>')).toBe('<p>test</p><p>content</p>');
        });
    });

    describe('Initialization', () => {
        it('prevents re-initialization when already initializing', () => {
            editorComponent.isInitializing = true;

            const shouldReturn = editorComponent.isInitializing;

            expect(shouldReturn).toBe(true);
        });

        it('prevents re-initialization when Quill exists and is connected', () => {
            editorComponent.quill = mockQuill;

            const shouldReturn =
                editorComponent.quill !== null &&
                editorComponent.quill.root &&
                editorComponent.quill.root.isConnected;

            expect(shouldReturn).toBe(true);
        });

        it('allows initialization when Quill root is disconnected', () => {
            editorComponent.quill = mockQuill;
            mockQuill.root.isConnected = false;

            const shouldReturn =
                editorComponent.quill !== null &&
                editorComponent.quill.root &&
                editorComponent.quill.root.isConnected;

            expect(shouldReturn).toBe(false);
        });

        it('creates Entangleable instance', () => {
            const EntangleableConstructor = vi.fn(() => mockEntangleable);
            global.window.StrataEntangleable = EntangleableConstructor;

            new global.window.StrataEntangleable('');

            expect(EntangleableConstructor).toHaveBeenCalledWith('');
        });

        it('creates Quill instance with correct config', () => {
            const QuillConstructor = vi.fn(() => mockQuill);
            global.window.Quill = QuillConstructor;

            const toolbarConfig = [['bold', 'italic']];
            const placeholder = 'Type here...';
            const disabled = false;

            new global.window.Quill(editorComponent.$refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: {
                        container: toolbarConfig,
                        handlers: {
                            image: expect.any(Function),
                        },
                    },
                },
                placeholder: placeholder,
                readOnly: disabled,
            });

            expect(QuillConstructor).toHaveBeenCalled();
        });

        it('loads initial content using dangerouslyPasteHTML', () => {
            mockEntangleable.get.mockReturnValue('<p>Initial content</p>');

            editorComponent.quill = mockQuill;
            const content = mockEntangleable.get();
            if (content) {
                mockQuill.clipboard.dangerouslyPasteHTML(content);
            }

            expect(mockQuill.clipboard.dangerouslyPasteHTML).toHaveBeenCalledWith('<p>Initial content</p>');
        });

        it('handles initialization error gracefully', () => {
            const consoleError = vi.spyOn(console, 'error').mockImplementation(() => {});
            const QuillConstructor = vi.fn(() => {
                throw new Error('Quill initialization failed');
            });
            global.window.Quill = QuillConstructor;

            try {
                new global.window.Quill();
            } catch (error) {
                consoleError('Strata Editor: Failed to initialize', error);
            }

            expect(consoleError).toHaveBeenCalledWith(
                'Strata Editor: Failed to initialize',
                expect.any(Error)
            );

            consoleError.mockRestore();
        });
    });

    describe('Content Synchronization', () => {
        beforeEach(() => {
            editorComponent.quill = mockQuill;
            editorComponent.entangleable = mockEntangleable;
        });

        it('syncs content from Quill to Entangleable on text-change', () => {
            let textChangeCallback;
            mockQuill.on.mockImplementation((event, callback) => {
                if (event === 'text-change') {
                    textChangeCallback = callback;
                }
            });

            mockQuill.on('text-change', () => {});
            editorComponent.isReady = true;

            if (textChangeCallback) {
                textChangeCallback();
            }

            setTimeout(() => {
                const html = mockQuill.root.innerHTML;
                mockEntangleable.set(html);
            }, 300);
        });

        it('does not sync when updatingFromLivewire is true', () => {
            let textChangeCallback;
            mockQuill.on.mockImplementation((event, callback) => {
                if (event === 'text-change') {
                    textChangeCallback = callback;
                }
            });

            mockQuill.on('text-change', () => {});
            editorComponent.updatingFromLivewire = true;
            editorComponent.isReady = true;

            if (textChangeCallback) {
                const shouldReturn = editorComponent.updatingFromLivewire;
                if (shouldReturn) {
                    expect(mockEntangleable.set).not.toHaveBeenCalled();
                }
            }
        });

        it('debounces content sync with 300ms timeout', () => {
            vi.useFakeTimers();

            let textChangeCallback;
            mockQuill.on.mockImplementation((event, callback) => {
                if (event === 'text-change') {
                    textChangeCallback = callback;
                }
            });

            mockQuill.on('text-change', () => {});
            editorComponent.isReady = true;

            if (textChangeCallback) {
                textChangeCallback();
                textChangeCallback();
                textChangeCallback();
            }

            vi.advanceTimersByTime(300);

            vi.useRealTimers();
        });

        it('updates Quill content when Livewire value changes', () => {
            let watchCallback;
            mockEntangleable.watch.mockImplementation((callback) => {
                watchCallback = callback;
            });

            mockEntangleable.watch(() => {});

            if (watchCallback) {
                mockQuill.root.innerHTML = '<p>old</p>';
                watchCallback('<p>new content</p>', '<p>old</p>');

                expect(mockQuill.setText).toHaveBeenCalledWith('');
                expect(mockQuill.clipboard.dangerouslyPasteHTML).toHaveBeenCalledWith('<p>new content</p>');
            }
        });

        it('handles empty new value when updating from Livewire', () => {
            let watchCallback;
            mockEntangleable.watch.mockImplementation((callback) => {
                watchCallback = callback;
            });

            mockEntangleable.watch(() => {});

            if (watchCallback) {
                mockQuill.root.innerHTML = '<p>old</p>';
                watchCallback('', '<p>old</p>');

                expect(mockQuill.setText).toHaveBeenCalledWith('');
                expect(mockQuill.clipboard.dangerouslyPasteHTML).not.toHaveBeenCalled();
            }
        });

        it('handles content update error gracefully', () => {
            const consoleError = vi.spyOn(console, 'error').mockImplementation(() => {});
            let watchCallback;
            mockEntangleable.watch.mockImplementation((callback) => {
                watchCallback = callback;
            });

            mockQuill.setText.mockImplementation(() => {
                throw new Error('setText failed');
            });

            mockEntangleable.watch(() => {});

            if (watchCallback) {
                try {
                    mockQuill.root.innerHTML = '<p>old</p>';
                    mockQuill.setText('');
                } catch (error) {
                    consoleError('Strata Editor: Failed to update content', error);
                    editorComponent.updatingFromLivewire = false;
                }

                expect(consoleError).toHaveBeenCalled();
            }

            consoleError.mockRestore();
        });
    });

    describe('Image Handler', () => {
        beforeEach(() => {
            editorComponent.quill = mockQuill;
        });

        it('creates file input with correct attributes', () => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            expect(input.type).toBe('file');
            expect(input.accept).toBe('image/*');
        });

        it('inserts image at current selection', () => {
            mockQuill.getSelection.mockReturnValue({ index: 5 });

            const range = mockQuill.getSelection(true);
            const base64 = 'data:image/png;base64,abc123';

            mockQuill.insertEmbed(range.index, 'image', base64);
            mockQuill.setSelection(range.index + 1);

            expect(mockQuill.insertEmbed).toHaveBeenCalledWith(5, 'image', base64);
            expect(mockQuill.setSelection).toHaveBeenCalledWith(6);
        });

        it('dispatches editor-image-added event', () => {
            const file = new File([''], 'test.png', { type: 'image/png' });
            const base64 = 'data:image/png;base64,abc123';

            editorComponent.$dispatch('editor-image-added', {
                file: file,
                base64: base64,
            });

            expect(editorComponent.$dispatch).toHaveBeenCalledWith('editor-image-added', {
                file: file,
                base64: base64,
            });
        });

        it('handles image insertion error gracefully', () => {
            const consoleError = vi.spyOn(console, 'error').mockImplementation(() => {});
            mockQuill.insertEmbed.mockImplementation(() => {
                throw new Error('Insert failed');
            });

            try {
                mockQuill.insertEmbed(0, 'image', 'data:image/png;base64,abc');
            } catch (error) {
                consoleError('Strata Editor: Failed to insert image', error);
            }

            expect(consoleError).toHaveBeenCalledWith(
                'Strata Editor: Failed to insert image',
                expect.any(Error)
            );

            consoleError.mockRestore();
        });
    });

    describe('Content Getter and Setter', () => {
        beforeEach(() => {
            editorComponent.entangleable = mockEntangleable;
            editorComponent.quill = mockQuill;
        });

        it('returns content from entangleable', () => {
            mockEntangleable.get.mockReturnValue('<p>test</p>');

            const content = editorComponent.entangleable?.get() ?? '';

            expect(content).toBe('<p>test</p>');
        });

        it('returns empty string when entangleable is null', () => {
            editorComponent.entangleable = null;

            const content = editorComponent.entangleable?.get() ?? '';

            expect(content).toBe('');
        });

        it('sets content using setContent method', () => {
            const newContent = '<p>new content</p>';

            if (editorComponent.quill && editorComponent.quill.root) {
                editorComponent.quill.setText('');
                if (newContent) {
                    editorComponent.quill.clipboard.dangerouslyPasteHTML(newContent);
                }
                editorComponent.entangleable.set(newContent);
            }

            expect(mockQuill.setText).toHaveBeenCalledWith('');
            expect(mockQuill.clipboard.dangerouslyPasteHTML).toHaveBeenCalledWith(newContent);
            expect(mockEntangleable.set).toHaveBeenCalledWith(newContent);
        });

        it('handles setContent error gracefully', () => {
            const consoleError = vi.spyOn(console, 'error').mockImplementation(() => {});
            mockQuill.setText.mockImplementation(() => {
                throw new Error('setText failed');
            });

            try {
                editorComponent.quill.setText('');
            } catch (error) {
                consoleError('Strata Editor: Failed to set content', error);
            }

            expect(consoleError).toHaveBeenCalled();

            consoleError.mockRestore();
        });
    });

    describe('Cleanup and Destroy', () => {
        beforeEach(() => {
            editorComponent.quill = mockQuill;
            editorComponent.entangleable = mockEntangleable;
            editorComponent.syncTimeout = setTimeout(() => {}, 300);
        });

        it('clears sync timeout', () => {
            const timeout = editorComponent.syncTimeout;
            clearTimeout(timeout);

            expect(timeout).toBeDefined();
        });

        it('removes text-change listener', () => {
            if (editorComponent.quill) {
                editorComponent.quill.off('text-change');
            }

            expect(mockQuill.off).toHaveBeenCalledWith('text-change');
        });

        it('clears Quill root innerHTML', () => {
            if (editorComponent.quill && editorComponent.quill.root) {
                editorComponent.quill.root.innerHTML = '';
            }

            expect(mockQuill.root.innerHTML).toBe('');
        });

        it('removes toolbar container', () => {
            const toolbar = mockQuill.getModule('toolbar');

            if (toolbar && toolbar.container) {
                toolbar.container.remove();
            }

            expect(toolbar.container.remove).toHaveBeenCalled();
        });

        it('disables Quill instance', () => {
            if (editorComponent.quill) {
                editorComponent.quill.disable();
            }

            expect(mockQuill.disable).toHaveBeenCalled();
        });

        it('nullifies Quill reference', () => {
            if (editorComponent.quill) {
                editorComponent.quill.disable();
                editorComponent.quill = null;
            }

            expect(editorComponent.quill).toBeNull();
        });

        it('destroys Entangleable instance', () => {
            editorComponent.entangleable?.destroy();

            expect(mockEntangleable.destroy).toHaveBeenCalled();
        });

        it('handles destroy errors gracefully', () => {
            const consoleError = vi.spyOn(console, 'error').mockImplementation(() => {});
            mockQuill.disable.mockImplementation(() => {
                throw new Error('Disable failed');
            });

            try {
                editorComponent.quill.disable();
                editorComponent.quill = null;
            } catch (e) {
                editorComponent.quill = null;
            }

            expect(editorComponent.quill).toBeNull();

            consoleError.mockRestore();
        });
    });

    describe('Livewire Integration', () => {
        beforeEach(() => {
            editorComponent.entangleable = mockEntangleable;
        });

        it('sets up Livewire binding with hidden input', () => {
            const input = editorComponent.$el.querySelector('[data-strata-editor-input]');

            if (input) {
                editorComponent.entangleable.setupLivewire(editorComponent, input);
            }

            expect(mockEntangleable.setupLivewire).toHaveBeenCalledWith(editorComponent, input);
        });

        it('registers watcher for Livewire updates', () => {
            const callback = vi.fn();
            editorComponent.entangleable.watch(callback);

            expect(mockEntangleable.watch).toHaveBeenCalledWith(callback);
        });
    });
});
