@php
    $editorId = $editorId ?? 'store-description';
    $content = old('description', $value ?? '');
    $quillId = $editorId . '-quill';
@endphp
<div class="form-group">
    <label for="{{ $editorId }}">Description</label>
    <p class="form-hint">Rich text editor — headings, lists, links, and formatted copy about this store.</p>
    <textarea name="description" id="{{ $editorId }}" class="rich-editor-source" hidden>{{ $content }}</textarea>
    <div id="{{ $quillId }}" class="quill-editor-mount"></div>
</div>
@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        <style>
            .quill-editor-mount {
                background: #fff;
                border-radius: 8px;
                max-width: 100%;
            }
            .quill-editor-mount .ql-editor {
                min-height: 280px;
                font-size: 1rem;
                line-height: 1.6;
            }
            .quill-editor-mount .ql-toolbar {
                border-radius: 8px 8px 0 0;
                border-color: var(--border, #e5e7eb);
            }
            .quill-editor-mount .ql-container {
                border-radius: 0 0 8px 8px;
                border-color: var(--border, #e5e7eb);
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.quill-editor-mount').forEach(function (mount) {
                    if (mount.dataset.quillReady === '1') return;
                    mount.dataset.quillReady = '1';

                    var sourceId = mount.id.replace(/-quill$/, '');
                    var source = document.getElementById(sourceId);
                    if (!source) return;

                    var quill = new Quill(mount, {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{ header: [2, 3, 4, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['blockquote', 'link'],
                                ['clean']
                            ]
                        }
                    });

                    if (source.value.trim()) {
                        quill.clipboard.dangerouslyPasteHTML(source.value);
                    }

                    var form = mount.closest('form');
                    if (form) {
                        form.addEventListener('submit', function () {
                            source.value = quill.root.innerHTML;
                        });
                    }
                });
            });
        </script>
    @endpush
@endonce
