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
                    plugins: 'advlist autolink lists link image charmap preview anchor pagebreak table code',
                    toolbar_mode: 'floating',
                    toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image | removeformat | code',
                    height: 400,
                    menubar: false,
                    branding: false,
                    promotion: false,
                    extended_valid_elements: 'style[type|media|scoped|id]',
                    valid_children: '+body[style]',
                    automatic_uploads: true,
                    paste_data_images: true,
                    images_upload_url: '/tinymce/upload',
                    images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', '/tinymce/upload');
                        
                        xhr.upload.onprogress = (e) => {
                            progress(e.loaded / e.total * 100);
                        };
                        
                        xhr.onload = () => {
                            if (xhr.status === 403) {
                                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                                return;
                            }
                            if (xhr.status < 200 || xhr.status >= 300) {
                                reject('HTTP Error: ' + xhr.status);
                                return;
                            }
                            const json = JSON.parse(xhr.responseText);
                            if (!json || typeof json.location != 'string') {
                                reject('Invalid JSON: ' + xhr.responseText);
                                return;
                            }
                            resolve(json.location);
                        };
                        
                        xhr.onerror = () => {
                            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                        };
                        
                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        
                        xhr.send(formData);
                    }),

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
