@can('pages.update')
{{-- Video Editor Modal for Front-end Inline Editing --}}
<aside id="client-inline-video-editor" class="client-video-editor-backdrop" aria-hidden="true">
    <div class="client-video-editor-dialog" role="dialog" aria-modal="true" aria-labelledby="client-video-editor-title">
        {{-- Header --}}
        <div class="client-video-editor-head">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #EEF2FF; border-radius: 8px; color: #4F46E5; font-size: 16px;">
                    ▶
                </span>
                <div>
                    <h3 id="client-video-editor-title" style="margin: 0; font-size: 17px; font-weight: 700; color: #1E293B; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                        Chỉnh Sửa Video
                    </h3>
                    <small id="client-video-editor-badge" style="color: #64748B; font-size: 12px; font-weight: 500;">
                        Vị trí: Trang web
                    </small>
                </div>
            </div>
            <button type="button" id="client-video-editor-close" class="client-video-editor-btn-close" aria-label="Đóng">&times;</button>
        </div>

        {{-- Body --}}
        <div class="client-video-editor-body">
            {{-- Video URL input --}}
            <div class="client-video-field">
                <label for="client-video-url-input" class="client-video-label">
                    Đường dẫn Video <span style="color: #EF4444;">*</span>
                </label>
                <div style="position: relative;">
                    <input
                        type="text"
                        id="client-video-url-input"
                        class="client-video-input"
                        placeholder="Dán link YouTube (watch, youtu.be, embed, shorts) hoặc link video MP4..."
                        autocomplete="off"
                    >
                </div>
                <p class="client-video-hint">
                    Hỗ trợ: Link YouTube (vd: <code>https://www.youtube.com/watch?v=...</code>, <code>https://youtu.be/...</code>), mã nhúng <code>&lt;iframe&gt;</code>, hoặc file <code>.mp4</code>.
                </p>
            </div>

            {{-- Poster input --}}
            <div class="client-video-field">
                <label for="client-video-poster-input" class="client-video-label">
                    Ảnh bìa Video (Poster) <span style="font-weight: 400; color: #94A3B8; font-size: 12px;">(Tùy chọn)</span>
                </label>
                <div style="display: flex; gap: 8px;">
                    <input
                        type="text"
                        id="client-video-poster-input"
                        class="client-video-input"
                        placeholder="https://... hoặc đường dẫn ảnh bìa"
                        style="flex: 1;"
                    >
                    @can('media.view')
                    <button type="button" id="client-video-pick-media-btn" class="client-video-btn-secondary" style="white-space: nowrap;">
                        📁 Chọn Thư Viện
                    </button>
                    @endcan
                </div>
                <p class="client-video-hint">
                    Đối với video YouTube, nếu để trống poster hệ thống sẽ tự động dùng ảnh thumbnail của YouTube.
                </p>
            </div>

            {{-- Live Preview Box --}}
            <div class="client-video-field" style="margin-bottom: 0;">
                <label class="client-video-label" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Xem trước (Live Preview)</span>
                    <span id="client-video-type-indicator" style="font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px; background: #E0E7FF; color: #3730A3;">
                        Tự động nhận diện
                    </span>
                </label>
                <div id="client-video-preview-box" class="client-video-preview-container">
                    <div id="client-video-preview-empty" style="color: #94A3B8; font-size: 13px; text-align: center; padding: 30px 16px;">
                        Nhập hoặc dán link video ở trên để xem thử trước khi lưu
                    </div>
                    <iframe id="client-video-preview-iframe" style="display: none; width: 100%; height: 100%; border: 0; position: absolute; inset: 0;" allowfullscreen></iframe>
                    <video id="client-video-preview-player" controls playsinline style="display: none; width: 100%; height: 100%; object-fit: contain; position: absolute; inset: 0; background: #000;"></video>
                </div>
            </div>

            {{-- Status/Alert --}}
            <div id="client-video-status-message" style="display: none; margin-top: 14px; padding: 10px 14px; border-radius: 8px; font-size: 13px;"></div>
        </div>

        {{-- Footer --}}
        <div class="client-video-editor-foot">
            <button type="button" id="client-video-restore-btn" class="client-video-btn-text" style="color: #DC2626;">
                Khôi phục mặc định
            </button>
            <div style="display: flex; gap: 10px;">
                <button type="button" id="client-video-cancel-btn" class="client-video-btn-secondary">
                    Hủy bỏ
                </button>
                <button type="button" id="client-video-save-btn" class="client-video-btn-primary">
                    <span id="client-video-save-spinner" style="display: none; margin-right: 6px;">⏳</span>
                    Lưu Video
                </button>
            </div>
        </div>
    </div>
</aside>

<style>
.client-video-editor-backdrop {
    position: fixed !important;
    inset: 0 !important;
    background: rgba(15, 23, 42, 0.7) !important;
    backdrop-filter: blur(4px) !important;
    z-index: 2147483645 !important;
    display: none !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 16px !important;
    box-sizing: border-box !important;
}
.client-video-editor-backdrop.is-open {
    display: flex !important;
}
.client-video-editor-dialog {
    background: #FFFFFF !important;
    border-radius: 16px !important;
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.35) !important;
    max-width: 640px !important;
    width: 100% !important;
    max-height: 92vh !important;
    display: flex !important;
    flex-direction: column !important;
    overflow: hidden !important;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    animation: clientVideoFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
@keyframes clientVideoFadeIn {
    from { opacity: 0; transform: scale(0.96) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.client-video-editor-head {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 18px 22px !important;
    border-bottom: 1px solid #E2E8F0 !important;
}
.client-video-editor-btn-close {
    background: transparent !important;
    border: none !important;
    font-size: 26px !important;
    line-height: 1 !important;
    color: #94A3B8 !important;
    cursor: pointer !important;
    padding: 0 4px !important;
    border-radius: 6px !important;
    transition: color 0.15s !important;
}
.client-video-editor-btn-close:hover {
    color: #0F172A !important;
}
.client-video-editor-body {
    padding: 22px !important;
    overflow-y: auto !important;
    flex: 1 !important;
}
.client-video-field {
    margin-bottom: 18px !important;
}
.client-video-label {
    display: block !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    color: #1E293B !important;
    margin-bottom: 7px !important;
}
.client-video-input {
    width: 100% !important;
    box-sizing: border-box !important;
    padding: 10px 14px !important;
    font-size: 14px !important;
    color: #1E293B !important;
    background: #F8FAFC !important;
    border: 1px solid #CBD5E1 !important;
    border-radius: 8px !important;
    outline: none !important;
    transition: all 0.2s !important;
}
.client-video-input:focus {
    background: #FFFFFF !important;
    border-color: #4F46E5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
}
.client-video-hint {
    margin: 6px 0 0 0 !important;
    font-size: 12px !important;
    color: #64748B !important;
    line-height: 1.4 !important;
}
.client-video-hint code {
    background: #F1F5F9 !important;
    padding: 2px 4px !important;
    border-radius: 4px !important;
    font-family: monospace !important;
    font-size: 11px !important;
    color: #0F172A !important;
}
.client-video-preview-container {
    position: relative !important;
    width: 100% !important;
    padding-bottom: 56.25% !important;
    height: 0 !important;
    background: #0F172A !important;
    border-radius: 10px !important;
    overflow: hidden !important;
    border: 1px solid #E2E8F0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
.client-video-editor-foot {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 16px 22px !important;
    border-top: 1px solid #E2E8F0 !important;
    background: #F8FAFC !important;
}
.client-video-btn-primary {
    background: #4F46E5 !important;
    color: #FFFFFF !important;
    font-weight: 600 !important;
    font-size: 13.5px !important;
    padding: 9px 20px !important;
    border-radius: 8px !important;
    border: none !important;
    cursor: pointer !important;
    transition: background 0.15s !important;
    display: inline-flex !important;
    align-items: center !important;
}
.client-video-btn-primary:hover {
    background: #4338CA !important;
}
.client-video-btn-secondary {
    background: #FFFFFF !important;
    color: #334155 !important;
    font-weight: 600 !important;
    font-size: 13.5px !important;
    padding: 9px 16px !important;
    border-radius: 8px !important;
    border: 1px solid #CBD5E1 !important;
    cursor: pointer !important;
    transition: background 0.15s !important;
}
.client-video-btn-secondary:hover {
    background: #F1F5F9 !important;
}
.client-video-btn-text {
    background: none !important;
    border: none !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    cursor: pointer !important;
    padding: 6px 8px !important;
}
.client-video-btn-text:hover {
    text-decoration: underline !important;
}

/* Edit mode indicator on videos */
body.client-edit-active [data-block-type="video"] {
    outline: 2px dashed #4F46E5 !important;
    outline-offset: 3px !important;
    cursor: pointer !important;
    position: relative !important;
    transition: outline 0.15s !important;
}
body.client-edit-active [data-block-type="video"]:hover {
    outline: 2px dashed #D97706 !important;
}
</style>
@endcan
