import { describe, it, expect, beforeEach, afterEach, vi } from 'vitest';

describe('Editor Component', () => {
    let mockEditor;
    let mockEntangleable;
    let editorComponent;
    let mockChain;

    beforeEach(() => {
        mockChain = {
            focus: vi.fn(() => mockChain),
            toggleBold: vi.fn(() => mockChain),
            toggleItalic: vi.fn(() => mockChain),
            toggleStrike: vi.fn(() => mockChain),
            toggleCode: vi.fn(() => mockChain),
            toggleHeading: vi.fn(() => mockChain),
            toggleBulletList: vi.fn(() => mockChain),
            toggleOrderedList: vi.fn(() => mockChain),
            toggleBlockquote: vi.fn(() => mockChain),
            toggleCodeBlock: vi.fn(() => mockChain),
            setTextAlign: vi.fn(() => mockChain),
            extendMarkRange: vi.fn(() => mockChain),
            setLink: vi.fn(() => mockChain),
            unsetLink: vi.fn(() => mockChain),
            setImage: vi.fn(() => mockChain),
            undo: vi.fn(() => mockChain),
            redo: vi.fn(() => mockChain),
            setContent: vi.fn(() => mockChain),
            run: vi.fn(() => true),
        };

        mockEditor = {
            chain: vi.fn(() => mockChain),
            getJSON: vi.fn(() => ({ type: 'doc', content: [] })),
            getAttributes: vi.fn(() => ({ href: '' })),
            isActive: vi.fn(() => false),
            can: vi.fn(() => ({
                undo: vi.fn(() => true),
                redo: vi.fn(() => true),
            })),
            commands: {
                setContent: vi.fn(),
            },
            destroy: vi.fn(),
        };

        mockEntangleable = {
            get: vi.fn(() => null),
            set: vi.fn(),
            watch: vi.fn(),
            setupLivewire: vi.fn(),
            destroy: vi.fn(),
        };

        global.window = {
            StrataEntangleable: vi.fn(() => mockEntangleable),
            prompt: vi.fn(),
        };

        global.Editor = vi.fn(() => mockEditor);

        editorComponent = {
            entangleable: null,
            updatedAt: Date.now(),
            $el: document.createElement('div'),
            $refs: {
                editor: document.createElement('div'),
            },
        };

        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('data-strata-editor-input', '');
        editorComponent.$el.appendChild(hiddenInput);
    });

    afterEach(() => {
        vi.clearAllMocks();
    });

    describe('Initialization', () => {
        it('creates Entangleable instance with initial value', () => {
            const initialValue = { type: 'doc', content: [] };
            const EntangleableConstructor = vi.fn(() => mockEntangleable);
            global.window.StrataEntangleable = EntangleableConstructor;

            new global.window.StrataEntangleable(initialValue);

            expect(EntangleableConstructor).toHaveBeenCalledWith(initialValue);
        });

        it('creates Entangleable with null when no initial value', () => {
            const EntangleableConstructor = vi.fn(() => mockEntangleable);
            global.window.StrataEntangleable = EntangleableConstructor;

            new global.window.StrataEntangleable(null);

            expect(EntangleableConstructor).toHaveBeenCalledWith(null);
        });

        it('finds and stores hidden input element', () => {
            const input = editorComponent.$el.querySelector('[data-strata-editor-input]');

            expect(input).toBeTruthy();
            expect(input.getAttribute('data-strata-editor-input')).toBe('');
        });

        it('sets up Livewire binding when hidden input exists', () => {
            editorComponent.entangleable = mockEntangleable;
            const input = editorComponent.$el.querySelector('[data-strata-editor-input]');

            if (input) {
                editorComponent.entangleable.setupLivewire(editorComponent, input);
            }

            expect(mockEntangleable.setupLivewire).toHaveBeenCalledWith(editorComponent, input);
        });

        it('does not call setupLivewire when hidden input is missing', () => {
            editorComponent.$el.innerHTML = '';
            editorComponent.entangleable = mockEntangleable;

            const input = editorComponent.$el.querySelector('[data-strata-editor-input]');

            if (input) {
                editorComponent.entangleable.setupLivewire(editorComponent, input);
            }

            expect(mockEntangleable.setupLivewire).not.toHaveBeenCalled();
        });

        it('creates Tiptap Editor with correct element', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            new global.Editor({
                element: editorComponent.$refs.editor,
                content: null,
                extensions: [],
            });

            expect(EditorConstructor).toHaveBeenCalled();
            const config = EditorConstructor.mock.calls[0][0];
            expect(config.element).toBe(editorComponent.$refs.editor);
        });

        it('initializes editor with content from Entangleable', () => {
            const initialContent = { type: 'doc', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'Hello' }] }] };
            mockEntangleable.get.mockReturnValue(initialContent);

            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            new global.Editor({
                element: editorComponent.$refs.editor,
                content: mockEntangleable.get(),
                extensions: [],
            });

            expect(EditorConstructor).toHaveBeenCalled();
            const config = EditorConstructor.mock.calls[0][0];
            expect(config.content).toEqual(initialContent);
        });

        it('includes StarterKit extension', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            const StarterKit = 'StarterKit';
            new global.Editor({
                element: editorComponent.$refs.editor,
                content: null,
                extensions: [StarterKit],
            });

            expect(EditorConstructor).toHaveBeenCalled();
            const config = EditorConstructor.mock.calls[0][0];
            expect(config.extensions).toContain(StarterKit);
        });

        it('configures Link extension with correct attributes', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            const LinkExtension = {
                configure: vi.fn(() => 'ConfiguredLink'),
            };

            LinkExtension.configure({
                openOnClick: false,
                HTMLAttributes: {
                    class: 'text-primary underline cursor-pointer',
                },
            });

            expect(LinkExtension.configure).toHaveBeenCalledWith({
                openOnClick: false,
                HTMLAttributes: {
                    class: 'text-primary underline cursor-pointer',
                },
            });
        });

        it('configures Image extension with correct attributes', () => {
            const ImageExtension = {
                configure: vi.fn(() => 'ConfiguredImage'),
            };

            ImageExtension.configure({
                HTMLAttributes: {
                    class: 'max-w-full h-auto rounded',
                },
            });

            expect(ImageExtension.configure).toHaveBeenCalledWith({
                HTMLAttributes: {
                    class: 'max-w-full h-auto rounded',
                },
            });
        });

        it('configures TextAlign extension for headings and paragraphs', () => {
            const TextAlignExtension = {
                configure: vi.fn(() => 'ConfiguredTextAlign'),
            };

            TextAlignExtension.configure({
                types: ['heading', 'paragraph'],
            });

            expect(TextAlignExtension.configure).toHaveBeenCalledWith({
                types: ['heading', 'paragraph'],
            });
        });

        it('sets editor prose classes in editorProps', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            new global.Editor({
                element: editorComponent.$refs.editor,
                content: null,
                extensions: [],
                editorProps: {
                    attributes: {
                        class: 'prose prose-sm sm:prose lg:prose-lg dark:prose-invert max-w-none focus:outline-none p-4',
                    },
                },
            });

            expect(EditorConstructor).toHaveBeenCalled();
            const config = EditorConstructor.mock.calls[0][0];
            expect(config.editorProps.attributes.class).toContain('prose');
            expect(config.editorProps.attributes.class).toContain('dark:prose-invert');
        });

        it('updates updatedAt timestamp on onCreate', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            const initialTime = Date.now();
            editorComponent.updatedAt = initialTime;

            new global.Editor({
                element: editorComponent.$refs.editor,
                content: null,
                extensions: [],
                onCreate: () => {
                    editorComponent.updatedAt = Date.now();
                },
            });

            const config = EditorConstructor.mock.calls[0][0];
            config.onCreate();

            expect(editorComponent.updatedAt).toBeGreaterThanOrEqual(initialTime);
        });
    });

    describe('Content Synchronization', () => {
        beforeEach(() => {
            editorComponent.entangleable = mockEntangleable;
        });

        it('syncs JSON content to Entangleable on editor update', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            const jsonContent = { type: 'doc', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'Updated' }] }] };
            mockEditor.getJSON.mockReturnValue(jsonContent);

            new global.Editor({
                element: editorComponent.$refs.editor,
                content: null,
                extensions: [],
                onUpdate: ({ editor }) => {
                    editorComponent.entangleable.set(editor.getJSON());
                },
            });

            const config = EditorConstructor.mock.calls[0][0];
            config.onUpdate({ editor: mockEditor });

            expect(mockEditor.getJSON).toHaveBeenCalled();
            expect(mockEntangleable.set).toHaveBeenCalledWith(jsonContent);
        });

        it('updates timestamp on editor update', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            const initialTime = Date.now();
            editorComponent.updatedAt = initialTime;

            new global.Editor({
                element: editorComponent.$refs.editor,
                content: null,
                extensions: [],
                onUpdate: () => {
                    editorComponent.updatedAt = Date.now();
                },
            });

            const config = EditorConstructor.mock.calls[0][0];
            config.onUpdate({ editor: mockEditor });

            expect(editorComponent.updatedAt).toBeGreaterThanOrEqual(initialTime);
        });

        it('updates timestamp on selection change', () => {
            const EditorConstructor = vi.fn(() => mockEditor);
            global.Editor = EditorConstructor;

            const initialTime = Date.now();
            editorComponent.updatedAt = initialTime;

            new global.Editor({
                element: editorComponent.$refs.editor,
                content: null,
                extensions: [],
                onSelectionUpdate: () => {
                    editorComponent.updatedAt = Date.now();
                },
            });

            const config = EditorConstructor.mock.calls[0][0];
            config.onSelectionUpdate();

            expect(editorComponent.updatedAt).toBeGreaterThanOrEqual(initialTime);
        });

        it('watches for Entangleable changes', () => {
            let watchCallback;
            mockEntangleable.watch.mockImplementation((callback) => {
                watchCallback = callback;
            });

            mockEntangleable.watch(() => {});

            expect(mockEntangleable.watch).toHaveBeenCalled();
            expect(typeof mockEntangleable.watch.mock.calls[0][0]).toBe('function');
        });

        it('updates editor content when Livewire value changes', () => {
            let watchCallback;
            mockEntangleable.watch.mockImplementation((callback) => {
                watchCallback = callback;
            });

            mockEntangleable.watch(() => {});

            const newContent = { type: 'doc', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'New' }] }] };
            const currentContent = { type: 'doc', content: [] };

            mockEditor.getJSON.mockReturnValue(currentContent);

            if (watchCallback) {
                const currentJSON = JSON.stringify(mockEditor.getJSON());
                const newJSON = JSON.stringify(newContent);

                if (currentJSON !== newJSON) {
                    mockEditor.commands.setContent(newContent, false);
                }
            }

            expect(mockEditor.commands.setContent).toHaveBeenCalledWith(newContent, false);
        });

        it('does not update editor when content is the same', () => {
            let watchCallback;
            mockEntangleable.watch.mockImplementation((callback) => {
                watchCallback = callback;
            });

            mockEntangleable.watch(() => {});

            const sameContent = { type: 'doc', content: [] };
            mockEditor.getJSON.mockReturnValue(sameContent);

            if (watchCallback) {
                const currentJSON = JSON.stringify(mockEditor.getJSON());
                const newJSON = JSON.stringify(sameContent);

                if (currentJSON !== newJSON) {
                    mockEditor.commands.setContent(sameContent, false);
                }
            }

            expect(mockEditor.commands.setContent).not.toHaveBeenCalled();
        });

        it('passes false as second argument to setContent to prevent triggering update', () => {
            mockEditor.commands.setContent({ type: 'doc', content: [] }, false);

            expect(mockEditor.commands.setContent).toHaveBeenCalledWith(
                expect.any(Object),
                false
            );
        });
    });

    describe('Formatting Commands', () => {
        it('toggles bold formatting', () => {
            const toggleBold = () => {
                mockEditor.chain().focus().toggleBold().run();
            };

            toggleBold();

            expect(mockEditor.chain).toHaveBeenCalled();
            expect(mockChain.focus).toHaveBeenCalled();
            expect(mockChain.toggleBold).toHaveBeenCalled();
            expect(mockChain.run).toHaveBeenCalled();
        });

        it('toggles italic formatting', () => {
            const toggleItalic = () => {
                mockEditor.chain().focus().toggleItalic().run();
            };

            toggleItalic();

            expect(mockChain.toggleItalic).toHaveBeenCalled();
        });

        it('toggles strike formatting', () => {
            const toggleStrike = () => {
                mockEditor.chain().focus().toggleStrike().run();
            };

            toggleStrike();

            expect(mockChain.toggleStrike).toHaveBeenCalled();
        });

        it('toggles code formatting', () => {
            const toggleCode = () => {
                mockEditor.chain().focus().toggleCode().run();
            };

            toggleCode();

            expect(mockChain.toggleCode).toHaveBeenCalled();
        });

        it('toggles heading with level 1', () => {
            const toggleHeading = (level) => {
                mockEditor.chain().focus().toggleHeading({ level }).run();
            };

            toggleHeading(1);

            expect(mockChain.toggleHeading).toHaveBeenCalledWith({ level: 1 });
        });

        it('toggles heading with level 2', () => {
            const toggleHeading = (level) => {
                mockEditor.chain().focus().toggleHeading({ level }).run();
            };

            toggleHeading(2);

            expect(mockChain.toggleHeading).toHaveBeenCalledWith({ level: 2 });
        });

        it('toggles heading with level 3', () => {
            const toggleHeading = (level) => {
                mockEditor.chain().focus().toggleHeading({ level }).run();
            };

            toggleHeading(3);

            expect(mockChain.toggleHeading).toHaveBeenCalledWith({ level: 3 });
        });

        it('toggles bullet list', () => {
            const toggleBulletList = () => {
                mockEditor.chain().focus().toggleBulletList().run();
            };

            toggleBulletList();

            expect(mockChain.toggleBulletList).toHaveBeenCalled();
        });

        it('toggles ordered list', () => {
            const toggleOrderedList = () => {
                mockEditor.chain().focus().toggleOrderedList().run();
            };

            toggleOrderedList();

            expect(mockChain.toggleOrderedList).toHaveBeenCalled();
        });

        it('toggles blockquote', () => {
            const toggleBlockquote = () => {
                mockEditor.chain().focus().toggleBlockquote().run();
            };

            toggleBlockquote();

            expect(mockChain.toggleBlockquote).toHaveBeenCalled();
        });

        it('toggles code block', () => {
            const toggleCodeBlock = () => {
                mockEditor.chain().focus().toggleCodeBlock().run();
            };

            toggleCodeBlock();

            expect(mockChain.toggleCodeBlock).toHaveBeenCalled();
        });

        it('chains all commands through focus', () => {
            mockEditor.chain().focus().toggleBold().run();

            const chainOrder = [];
            mockChain.focus.mockImplementation(() => {
                chainOrder.push('focus');
                return mockChain;
            });
            mockChain.toggleBold.mockImplementation(() => {
                chainOrder.push('toggleBold');
                return mockChain;
            });
            mockChain.run.mockImplementation(() => {
                chainOrder.push('run');
                return true;
            });

            mockEditor.chain().focus().toggleBold().run();

            expect(chainOrder).toEqual(['focus', 'toggleBold', 'run']);
        });
    });

    describe('Text Alignment', () => {
        it('sets text alignment to left', () => {
            const setTextAlign = (alignment) => {
                mockEditor.chain().focus().setTextAlign(alignment).run();
            };

            setTextAlign('left');

            expect(mockChain.setTextAlign).toHaveBeenCalledWith('left');
        });

        it('sets text alignment to center', () => {
            const setTextAlign = (alignment) => {
                mockEditor.chain().focus().setTextAlign(alignment).run();
            };

            setTextAlign('center');

            expect(mockChain.setTextAlign).toHaveBeenCalledWith('center');
        });

        it('sets text alignment to right', () => {
            const setTextAlign = (alignment) => {
                mockEditor.chain().focus().setTextAlign(alignment).run();
            };

            setTextAlign('right');

            expect(mockChain.setTextAlign).toHaveBeenCalledWith('right');
        });

        it('sets text alignment to justify', () => {
            const setTextAlign = (alignment) => {
                mockEditor.chain().focus().setTextAlign(alignment).run();
            };

            setTextAlign('justify');

            expect(mockChain.setTextAlign).toHaveBeenCalledWith('justify');
        });
    });

    describe('Link Handler', () => {
        it('prompts for URL when setting link', () => {
            global.window.prompt.mockReturnValue('https://example.com');

            const setLink = () => {
                const previousUrl = mockEditor.getAttributes('link').href;
                const url = global.window.prompt('URL', previousUrl);

                if (url && url !== '') {
                    mockEditor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
                }
            };

            setLink();

            expect(global.window.prompt).toHaveBeenCalledWith('URL', '');
        });

        it('sets link with provided URL', () => {
            global.window.prompt.mockReturnValue('https://example.com');

            const setLink = () => {
                const url = global.window.prompt('URL', '');

                if (url && url !== '') {
                    mockEditor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
                }
            };

            setLink();

            expect(mockChain.extendMarkRange).toHaveBeenCalledWith('link');
            expect(mockChain.setLink).toHaveBeenCalledWith({ href: 'https://example.com' });
        });

        it('removes link when empty URL is provided', () => {
            global.window.prompt.mockReturnValue('');

            const setLink = () => {
                const url = global.window.prompt('URL', '');

                if (url === '') {
                    mockEditor.chain().focus().extendMarkRange('link').unsetLink().run();
                }
            };

            setLink();

            expect(mockChain.unsetLink).toHaveBeenCalled();
        });

        it('cancels link operation when prompt is cancelled', () => {
            global.window.prompt.mockReturnValue(null);

            const setLink = () => {
                const url = global.window.prompt('URL', '');

                if (url === null) {
                    return;
                }

                mockEditor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
            };

            setLink();

            expect(mockChain.setLink).not.toHaveBeenCalled();
        });

        it('uses previous URL as prompt default', () => {
            mockEditor.getAttributes.mockReturnValue({ href: 'https://old.com' });
            global.window.prompt.mockReturnValue('https://new.com');

            const setLink = () => {
                const previousUrl = mockEditor.getAttributes('link').href;
                global.window.prompt('URL', previousUrl);
            };

            setLink();

            expect(global.window.prompt).toHaveBeenCalledWith('URL', 'https://old.com');
        });
    });

    describe('Image Handler', () => {
        let mockImageInput;

        beforeEach(() => {
            mockImageInput = {
                click: vi.fn(),
                value: '',
            };
        });

        it('triggers file input click when addImage is called', () => {
            editorComponent.$refs.imageInput = mockImageInput;

            const addImage = function() {
                this.$refs.imageInput?.click();
            };

            addImage.call(editorComponent);

            expect(mockImageInput.click).toHaveBeenCalled();
        });

        it('does nothing gracefully when imageInput ref is null', () => {
            editorComponent.$refs.imageInput = null;

            const addImage = function() {
                this.$refs.imageInput?.click();
            };

            expect(() => addImage.call(editorComponent)).not.toThrow();
        });

        it('processes valid image file and inserts into editor', async () => {
            const mockFile = new File(['fake image data'], 'test.jpg', { type: 'image/jpeg' });
            const mockEvent = {
                target: {
                    files: [mockFile],
                    value: 'C:\\fakepath\\test.jpg',
                },
            };

            const base64Result = 'data:image/jpeg;base64,fakebase64data';

            const blobToBase64 = vi.fn().mockResolvedValue(base64Result);

            const handleImageSelect = async function(event) {
                const file = event.target.files?.[0];
                if (!file || !file.type.includes('image')) {
                    return;
                }

                try {
                    const base64 = await blobToBase64(file);
                    mockEditor.chain().focus().setImage({ src: base64 }).run();
                } catch (error) {
                    global.window.toast.error('Image Upload Failed', 'Could not read the selected image file.');
                    console.error('[Editor] Image upload error:', error);
                }

                event.target.value = '';
            };

            await handleImageSelect(mockEvent);

            expect(blobToBase64).toHaveBeenCalledWith(mockFile);
            expect(mockChain.setImage).toHaveBeenCalledWith({ src: base64Result });
            expect(mockEvent.target.value).toBe('');
        });

        it('ignores event when no file is selected', async () => {
            const mockEvent = {
                target: {
                    files: [],
                    value: '',
                },
            };

            const blobToBase64 = vi.fn();

            const handleImageSelect = async function(event) {
                const file = event.target.files?.[0];
                if (!file || !file.type.includes('image')) {
                    return;
                }

                const base64 = await blobToBase64(file);
                mockEditor.chain().focus().setImage({ src: base64 }).run();
            };

            await handleImageSelect(mockEvent);

            expect(blobToBase64).not.toHaveBeenCalled();
            expect(mockChain.setImage).not.toHaveBeenCalled();
        });

        it('ignores non-image files', async () => {
            const mockFile = new File(['fake data'], 'test.txt', { type: 'text/plain' });
            const mockEvent = {
                target: {
                    files: [mockFile],
                    value: 'C:\\fakepath\\test.txt',
                },
            };

            const blobToBase64 = vi.fn();

            const handleImageSelect = async function(event) {
                const file = event.target.files?.[0];
                if (!file || !file.type.includes('image')) {
                    return;
                }

                const base64 = await blobToBase64(file);
                mockEditor.chain().focus().setImage({ src: base64 }).run();
            };

            await handleImageSelect(mockEvent);

            expect(blobToBase64).not.toHaveBeenCalled();
            expect(mockChain.setImage).not.toHaveBeenCalled();
        });

        it('shows error toast when blobToBase64 fails', async () => {
            const mockFile = new File(['fake image data'], 'test.jpg', { type: 'image/jpeg' });
            const mockEvent = {
                target: {
                    files: [mockFile],
                    value: 'C:\\fakepath\\test.jpg',
                },
            };

            const mockError = new Error('FileReader error');
            const blobToBase64 = vi.fn().mockRejectedValue(mockError);

            global.window.toast = {
                error: vi.fn(),
            };
            global.console.error = vi.fn();

            const handleImageSelect = async function(event) {
                const file = event.target.files?.[0];
                if (!file || !file.type.includes('image')) {
                    return;
                }

                try {
                    const base64 = await blobToBase64(file);
                    mockEditor.chain().focus().setImage({ src: base64 }).run();
                } catch (error) {
                    global.window.toast.error('Image Upload Failed', 'Could not read the selected image file.');
                    console.error('[Editor] Image upload error:', error);
                }

                event.target.value = '';
            };

            await handleImageSelect(mockEvent);

            expect(global.window.toast.error).toHaveBeenCalledWith(
                'Image Upload Failed',
                'Could not read the selected image file.'
            );
            expect(console.error).toHaveBeenCalledWith('[Editor] Image upload error:', mockError);
            expect(mockChain.setImage).not.toHaveBeenCalled();
            expect(mockEvent.target.value).toBe('');
        });

        it('clears input value after successful upload', async () => {
            const mockFile = new File(['fake image data'], 'test.jpg', { type: 'image/jpeg' });
            const mockEvent = {
                target: {
                    files: [mockFile],
                    value: 'C:\\fakepath\\test.jpg',
                },
            };

            const blobToBase64 = vi.fn().mockResolvedValue('data:image/jpeg;base64,fake');

            const handleImageSelect = async function(event) {
                const file = event.target.files?.[0];
                if (!file || !file.type.includes('image')) {
                    return;
                }

                try {
                    const base64 = await blobToBase64(file);
                    mockEditor.chain().focus().setImage({ src: base64 }).run();
                } catch (error) {
                    global.window.toast.error('Image Upload Failed', 'Could not read the selected image file.');
                }

                event.target.value = '';
            };

            await handleImageSelect(mockEvent);

            expect(mockEvent.target.value).toBe('');
        });

        it('blobToBase64 resolves with base64 data URL', async () => {
            const mockBlob = new Blob(['fake image data'], { type: 'image/jpeg' });
            const expectedBase64 = 'data:image/jpeg;base64,fakedata';

            const mockFileReader = {
                readAsDataURL: vi.fn(),
                onload: null,
                onerror: null,
                result: expectedBase64,
            };

            global.FileReader = vi.fn(() => mockFileReader);

            const blobToBase64 = (blob) => {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = (error) => reject(error);
                });
            };

            const promise = blobToBase64(mockBlob);
            mockFileReader.onload();

            const result = await promise;

            expect(mockFileReader.readAsDataURL).toHaveBeenCalledWith(mockBlob);
            expect(result).toBe(expectedBase64);
        });

        it('blobToBase64 rejects when FileReader fails', async () => {
            const mockBlob = new Blob(['fake image data'], { type: 'image/jpeg' });
            const expectedError = new Error('Read failed');

            const mockFileReader = {
                readAsDataURL: vi.fn(),
                onload: null,
                onerror: null,
            };

            global.FileReader = vi.fn(() => mockFileReader);

            const blobToBase64 = (blob) => {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = (error) => reject(error);
                });
            };

            const promise = blobToBase64(mockBlob);
            mockFileReader.onerror(expectedError);

            await expect(promise).rejects.toEqual(expectedError);
        });
    });

    describe('History Commands', () => {
        it('executes undo command', () => {
            const undo = () => {
                mockEditor.chain().focus().undo().run();
            };

            undo();

            expect(mockChain.undo).toHaveBeenCalled();
        });

        it('executes redo command', () => {
            const redo = () => {
                mockEditor.chain().focus().redo().run();
            };

            redo();

            expect(mockChain.redo).toHaveBeenCalled();
        });

        it('checks if undo is available', () => {
            mockEditor.can().undo.mockReturnValue(true);

            const canUndo = () => {
                return mockEditor.can().undo();
            };

            const result = canUndo();

            expect(result).toBe(true);
            expect(mockEditor.can).toHaveBeenCalled();
        });

        it('checks if redo is available', () => {
            const canMock = {
                undo: vi.fn(() => false),
                redo: vi.fn(() => false),
            };
            mockEditor.can.mockReturnValue(canMock);

            const canRedo = () => {
                return mockEditor.can().redo();
            };

            const result = canRedo();

            expect(result).toBe(false);
            expect(mockEditor.can).toHaveBeenCalled();
        });
    });

    describe('Active State Checking', () => {
        it('checks if bold is active', () => {
            mockEditor.isActive.mockReturnValue(true);

            const isActive = (type, opts = {}) => {
                return mockEditor.isActive(type, opts);
            };

            const result = isActive('bold');

            expect(mockEditor.isActive).toHaveBeenCalledWith('bold', {});
            expect(result).toBe(true);
        });

        it('checks if heading level is active', () => {
            mockEditor.isActive.mockReturnValue(true);

            const isActive = (type, opts = {}) => {
                return mockEditor.isActive(type, opts);
            };

            const result = isActive('heading', { level: 2 });

            expect(mockEditor.isActive).toHaveBeenCalledWith('heading', { level: 2 });
            expect(result).toBe(true);
        });

        it('checks if bullet list is active', () => {
            mockEditor.isActive.mockReturnValue(false);

            const isActive = (type, opts = {}) => {
                return mockEditor.isActive(type, opts);
            };

            const result = isActive('bulletList');

            expect(mockEditor.isActive).toHaveBeenCalledWith('bulletList', {});
            expect(result).toBe(false);
        });

        it('checks text alignment state', () => {
            mockEditor.isActive.mockReturnValue(true);

            const isActive = (type, opts = {}) => {
                return mockEditor.isActive(type, opts);
            };

            const result = isActive('textAlign', { textAlign: 'center' });

            expect(mockEditor.isActive).toHaveBeenCalledWith('textAlign', { textAlign: 'center' });
            expect(result).toBe(true);
        });
    });

    describe('Cleanup and Destroy', () => {
        it('calls editor destroy method', () => {
            const destroy = () => {
                mockEditor?.destroy();
            };

            destroy();

            expect(mockEditor.destroy).toHaveBeenCalled();
        });

        it('calls entangleable destroy method', () => {
            editorComponent.entangleable = mockEntangleable;

            const destroy = () => {
                editorComponent.entangleable?.destroy();
            };

            destroy();

            expect(mockEntangleable.destroy).toHaveBeenCalled();
        });

        it('handles null editor gracefully', () => {
            const destroy = () => {
                const nullEditor = null;
                nullEditor?.destroy();
            };

            expect(() => destroy()).not.toThrow();
        });

        it('handles null entangleable gracefully', () => {
            editorComponent.entangleable = null;

            const destroy = () => {
                editorComponent.entangleable?.destroy();
            };

            expect(() => destroy()).not.toThrow();
        });

        it('destroys both editor and entangleable', () => {
            editorComponent.entangleable = mockEntangleable;

            const destroy = () => {
                mockEditor?.destroy();
                editorComponent.entangleable?.destroy();
            };

            destroy();

            expect(mockEditor.destroy).toHaveBeenCalled();
            expect(mockEntangleable.destroy).toHaveBeenCalled();
        });
    });
});
