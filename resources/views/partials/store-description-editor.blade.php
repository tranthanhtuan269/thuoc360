@php
    $editorId = $editorId ?? 'store-description';
    $content = old('description', $value ?? '');
@endphp
<div class="form-group">
    <label for="{{ $editorId }}">Description</label>
    <p class="form-hint">Use the editor for headings, lists, links, and formatted copy about this store.</p>
    <textarea name="description" id="{{ $editorId }}" class="rich-editor-field">{{ $content }}</textarea>
</div>
@once
    @push('styles')
        <style>
            .cke_chrome { border-radius: 8px !important; border-color: var(--border, #e5e7eb) !important; max-width: 100%; }
            .rich-editor-field { min-height: 280px; }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('form').forEach(function (form) {
                    form.addEventListener('submit', function () {
                        if (typeof CKEDITOR !== 'undefined') {
                            for (var id in CKEDITOR.instances) {
                                CKEDITOR.instances[id].updateElement();
                            }
                        }
                    });
                });
                document.querySelectorAll('.rich-editor-field').forEach(function (el) {
                    if (el.dataset.ckeditorInit === '1') return;
                    el.dataset.ckeditorInit = '1';
                    CKEDITOR.replace(el.id, {
                        height: 320,
                        removePlugins: 'elementspath',
                        resize_enabled: true,
                        toolbar: [
                            { name: 'document', items: ['Source'] },
                            { name: 'clipboard', items: ['Undo', 'Redo'] },
                            { name: 'styles', items: ['Format'] },
                            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'RemoveFormat'] },
                            { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'] },
                            { name: 'links', items: ['Link', 'Unlink'] },
                            { name: 'insert', items: ['Table', 'HorizontalRule'] },
                            { name: 'tools', items: ['Maximize'] }
                        ]
                    });
                });
            });
        </script>
    @endpush
@endonce
