@once
    @push('styles')
        <style>
            .content-language-tabs .nav-link { font-weight: 600; }
            .content-language-tabs .language-required { font-size: .72rem; }
            @cannot('translations.use')
                .js-translate-locale { display: none !important; }
            @endcannot
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.js-translate-locale').forEach(function (button) {
                    button.addEventListener('click', async function () {
                        const sourceLocale = button.dataset.sourceLocale;
                        const targetLocale = button.dataset.targetLocale;
                        const fields = {};
                        const formats = {};

                        document.querySelectorAll(`[data-i18n-locale="${sourceLocale}"][data-i18n-field]`).forEach(function (element) {
                            const editor = document.querySelector(`.catalog-quill[data-target="${element.id}"]`);
                            if (editor && editor.__quill) element.value = editor.__quill.root.innerHTML;
                            fields[element.dataset.i18nField] = element.value || '';
                            formats[element.dataset.i18nField] = element.dataset.translationFormat || 'text';
                        });

                        const targets = Array.from(document.querySelectorAll(`[data-i18n-locale="${targetLocale}"][data-i18n-field]`));
                        if (targets.some((element) => (element.value || '').trim() !== '') && !window.confirm('Bản dịch đích đã có nội dung. Bạn có muốn thay bằng bản dịch xem trước mới?')) return;

                        const original = button.innerHTML;
                        button.disabled = true;
                        button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Đang dịch';

                        try {
                            const response = await fetch(@json(route('admin.translations.preview')), {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({ source_locale: sourceLocale, target_locale: targetLocale, fields, formats }),
                            });
                            const payload = await response.json();
                            if (!response.ok) throw new Error(payload.message || 'Không thể dịch nội dung.');

                            targets.forEach(function (element) {
                                let value = payload.data?.fields?.[element.dataset.i18nField];
                                if (typeof value !== 'string') return;
                                if (element.dataset.i18nField === 'slug' && value.trim()) {
                                    value = value.toLowerCase()
                                        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                                        .replace(/[đĐ]/g, 'd')
                                        .replace(/[^a-z0-9]+/g, '-')
                                        .replace(/^-+|-+$/g, '');
                                }
                                element.value = value;
                                const editor = document.querySelector(`.catalog-quill[data-target="${element.id}"]`);
                                if (editor && editor.__quill) {
                                    if (editor.__quill.clipboard && typeof editor.__quill.clipboard.dangerouslyPasteHTML === 'function') {
                                        editor.__quill.clipboard.dangerouslyPasteHTML(value);
                                    } else {
                                        editor.__quill.root.innerHTML = value;
                                    }
                                }
                                element.dispatchEvent(new Event('input', { bubbles: true }));
                                element.dispatchEvent(new Event('change', { bubbles: true }));
                            });
                        } catch (error) {
                            window.alert(error.message || 'Không thể dịch nội dung.');
                        } finally {
                            button.disabled = false;
                            button.innerHTML = original;
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce
