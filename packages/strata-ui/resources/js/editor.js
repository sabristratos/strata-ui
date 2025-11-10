import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import TextAlign from '@tiptap/extension-text-align';

export default (initialValue = null) => {
    let editor;
    let syncTimeout;

    return {
        ...window.createEntangleableMixin({
            initialValue: initialValue,
            inputSelector: '[data-strata-editor-input]',
            afterWatch: function(newValue) {
                const currentContent = JSON.stringify(editor.getJSON());
                const newContent = JSON.stringify(newValue);

                if (currentContent !== newContent) {
                    editor.commands.setContent(newValue, false);
                }
            }
        }),

        activeStates: {},

        init() {
            if (editor) {
                return;
            }

            this.initEntangleable();

            editor = new Editor({
                element: this.$refs.editor,
                content: this.entangleable.get(),
                extensions: [
                    StarterKit.configure({
                        link: false,
                    }),
                    Link.configure({
                        openOnClick: false,
                        HTMLAttributes: {
                            class: 'text-primary underline cursor-pointer',
                        },
                    }),
                    Image.configure({
                        HTMLAttributes: {
                            class: 'max-w-full h-auto rounded',
                        },
                    }),
                    TextAlign.configure({
                        types: ['heading', 'paragraph'],
                    }),
                ],
                editorProps: {
                    attributes: {
                        class: 'prose prose-sm sm:prose lg:prose-lg dark:prose-invert max-w-none focus:outline-none p-4',
                    },
                },
                onCreate: () => {
                    this.updateActiveStates();
                },
                onUpdate: ({ editor }) => {
                    clearTimeout(syncTimeout);
                    syncTimeout = setTimeout(() => {
                        this.entangleable.set(editor.getJSON());
                    }, 300);
                    this.updateActiveStates();
                },
                onSelectionUpdate: () => {
                    this.updateActiveStates();
                },
            });
        },

        toggleBold() {
            editor.chain().focus().toggleBold().run();
        },

        toggleItalic() {
            editor.chain().focus().toggleItalic().run();
        },

        toggleStrike() {
            editor.chain().focus().toggleStrike().run();
        },

        toggleCode() {
            editor.chain().focus().toggleCode().run();
        },

        toggleHeading(level) {
            editor.chain().focus().toggleHeading({ level }).run();
        },

        toggleBulletList() {
            editor.chain().focus().toggleBulletList().run();
        },

        toggleOrderedList() {
            editor.chain().focus().toggleOrderedList().run();
        },

        toggleBlockquote() {
            editor.chain().focus().toggleBlockquote().run();
        },

        toggleCodeBlock() {
            editor.chain().focus().toggleCodeBlock().run();
        },

        setTextAlign(alignment) {
            editor.chain().focus().setTextAlign(alignment).run();
        },

        setLink() {
            const previousUrl = editor.getAttributes('link').href;
            const url = window.prompt('URL', previousUrl);

            if (url === null) {
                return;
            }

            if (url === '') {
                editor.chain().focus().extendMarkRange('link').unsetLink().run();
                return;
            }

            editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
        },

        addImage() {
            this.$refs.imageInput?.click();
        },

        async handleImageSelect(event) {
            const file = event.target.files?.[0];
            if (!file || !file.type.includes('image')) {
                return;
            }

            try {
                const base64 = await this.blobToBase64(file);
                editor.chain().focus().setImage({ src: base64 }).run();
            } catch (error) {
                window.toast.error('Image Upload Failed', 'Could not read the selected image file.');
                console.error('[Editor] Image upload error:', error);
            }

            event.target.value = '';
        },

        blobToBase64(blob) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onload = () => resolve(reader.result);
                reader.onerror = (error) => reject(error);
            });
        },

        undo() {
            editor.chain().focus().undo().run();
        },

        redo() {
            editor.chain().focus().redo().run();
        },

        updateActiveStates() {
            this.activeStates = {
                bold: editor.isActive('bold'),
                italic: editor.isActive('italic'),
                strike: editor.isActive('strike'),
                code: editor.isActive('code'),
                heading1: editor.isActive('heading', { level: 1 }),
                heading2: editor.isActive('heading', { level: 2 }),
                heading3: editor.isActive('heading', { level: 3 }),
                bulletList: editor.isActive('bulletList'),
                orderedList: editor.isActive('orderedList'),
                blockquote: editor.isActive('blockquote'),
                codeBlock: editor.isActive('codeBlock'),
                link: editor.isActive('link'),
                alignLeft: editor.isActive({ textAlign: 'left' }),
                alignCenter: editor.isActive({ textAlign: 'center' }),
                alignRight: editor.isActive({ textAlign: 'right' }),
                alignJustify: editor.isActive({ textAlign: 'justify' }),
            };
        },

        isActive(type, opts = {}) {
            if (typeof type === 'object' && type.textAlign) {
                const alignmentKey = `align${type.textAlign.charAt(0).toUpperCase() + type.textAlign.slice(1)}`;
                return this.activeStates[alignmentKey] ?? false;
            }
            const key = opts.level ? `${type}${opts.level}` : type;
            return this.activeStates[key] ?? false;
        },

        canUndo() {
            return editor.can().undo();
        },

        canRedo() {
            return editor.can().redo();
        },

        destroy() {
            clearTimeout(syncTimeout);
            editor?.destroy();
            this.entangleable?.destroy();
        },
    };
};
