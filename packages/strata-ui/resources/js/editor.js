import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import TextAlign from '@tiptap/extension-text-align';

export default (initialValue = null) => {
    let editor;

    return {
        entangleable: null,
        updatedAt: Date.now(),

        init() {
            this.entangleable = new window.StrataEntangleable(initialValue);

            const input = this.$el.querySelector('[data-strata-editor-input]');
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            editor = new Editor({
                element: this.$refs.editor,
                content: this.entangleable.get(),
                extensions: [
                    StarterKit,
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
                    this.updatedAt = Date.now();
                },
                onUpdate: ({ editor }) => {
                    this.entangleable.set(editor.getJSON());
                    this.updatedAt = Date.now();
                },
                onSelectionUpdate: () => {
                    this.updatedAt = Date.now();
                },
            });

            this.entangleable.watch((newValue) => {
                const currentContent = JSON.stringify(editor.getJSON());
                const newContent = JSON.stringify(newValue);

                if (currentContent !== newContent) {
                    editor.commands.setContent(newValue, false);
                }
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
            const url = window.prompt('Image URL');

            if (url) {
                editor.chain().focus().setImage({ src: url }).run();
            }
        },

        undo() {
            editor.chain().focus().undo().run();
        },

        redo() {
            editor.chain().focus().redo().run();
        },

        isActive(type, opts = {}) {
            return editor.isActive(type, opts);
        },

        canUndo() {
            return editor.can().undo();
        },

        canRedo() {
            return editor.can().redo();
        },

        destroy() {
            editor?.destroy();
            this.entangleable?.destroy();
        },
    };
};
