<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{ 
            state: @entangle($getStatePath()),
            initEditor() {
                if (typeof tinymce === 'undefined') {
                    setTimeout(() => this.initEditor(), 100);
                    return;
                }
                
                tinymce.init({
                    target: this.$refs.editor,
                    plugins: 'advlist autolink lists link image charmap preview anchor pagebreak table',
                    toolbar_mode: 'floating',
                    toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image | removeformat',
                    height: 400,
                    menubar: false,
                    branding: false,
                    promotion: false,
                    setup: (editor) => {
                        editor.on('init', () => {
                            editor.setContent(this.state || '');
                        });
                        editor.on('change keyup blur', () => {
                            this.state = editor.getContent();
                        });
                    }
                });
            }
        }"
        x-init="
            initEditor();
            $watch('state', (value) => {
                const editor = tinymce.get(this.$refs.editor.id);
                if (editor && editor.getContent() !== value) {
                    editor.setContent(value || '');
                }
            });
        "
        wire:ignore
        class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden"
    >
        <textarea x-ref="editor" id="{{ $getId() }}"></textarea>
    </div>
</x-dynamic-component>
