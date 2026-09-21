@props([
    'key',
    'defaultUrl' => '',
    'defaultPoster' => '',
    'title' => 'Video',
    'aspectRatio' => '56.25%',
    'borderRadius' => '8px',
    'wrapperStyle' => '',
    'wrapperClass' => '',
])

@php
    $site = app(\App\Services\SiteContentService::class);
    $canEdit = (bool) auth()->user()?->canEditClientContent();

    $video = $site->video($key, $defaultUrl, $defaultPoster);
    $cleared = $site->isCleared($key);
    $url = $cleared ? $defaultUrl : ($video['url'] ?: $defaultUrl);
    $poster = $cleared ? $defaultPoster : ($video['poster'] ?: $defaultPoster);
    $customPoster = $video['custom_poster'] ?? '';
    $isYoutube = $video['is_youtube'];
    $embedUrl = $video['embed_url'];
    $youtubeId = $video['youtube_id'];

    $editAttrs = $canEdit ? [
        'data-block-key' => $key,
        'data-block-type' => \App\Models\SiteBlock::TYPE_VIDEO,
        'data-video-url' => $url,
        'data-poster-url' => $customPoster,
        'data-default-url' => $defaultUrl,
        'data-default-poster' => $defaultPoster,
        'data-video-title' => $title,
        'data-is-youtube' => $isYoutube ? 'true' : 'false',
        'data-youtube-id' => $youtubeId ?? '',
        'data-embed-url' => $embedUrl ?? '',
        'data-block-cleared' => $cleared ? 'true' : null,
    ] : [];
@endphp

@if(! $cleared || $canEdit)
    <div
        {{ $attributes
            ->class(['client-editable-video-wrapper', 'client-block-cleared' => $canEdit && $cleared, $wrapperClass])
            ->merge(array_filter($editAttrs)) }}
        style="position: relative; width: 100%; border-radius: {{ $borderRadius }}; {{ $wrapperStyle }}"
    >
        @if($slot->isNotEmpty())
            {{ $slot }}
        @elseif($isYoutube && $embedUrl)
            <div style="position: relative; padding-bottom: {{ str_contains($aspectRatio, '%') ? $aspectRatio : ($aspectRatio === '16/9' ? '56.25%' : $aspectRatio) }}; height: 0; overflow: hidden; border-radius: {{ $borderRadius }};">
                <iframe
                    src="{{ $embedUrl }}"
                    title="{{ $title }}"
                    style="position: absolute; top:0; left:0; width: 100%; height: 100%; border:0;"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                    loading="lazy"
                ></iframe>
            </div>
        @else
            <div style="position: relative; padding-bottom: {{ str_contains($aspectRatio, '%') ? $aspectRatio : ($aspectRatio === '16/9' ? '56.25%' : $aspectRatio) }}; height: 0; overflow: hidden; border-radius: {{ $borderRadius }}; background-color: #000;">
                <video
                    controls
                    playsinline
                    poster="{{ $poster }}"
                    style="position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover;"
                >
                    <source src="{{ $url }}" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ phát video.
                </video>
            </div>
        @endif
    </div>
@endif
