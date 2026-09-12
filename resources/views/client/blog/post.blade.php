@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
    $pTitle = is_array($post->title) ? ($post->title[$locale] ?? $post->title['vi'] ?? '') : ($post->getTranslation('title', $locale, false) ?: $post->title);
    $pContent = is_array($post->content) ? ($post->content[$locale] ?? $post->content['vi'] ?? '') : ($post->getTranslation('content', $locale, false) ?: $post->content);
    $pImg = $post->image_url;
    if ($pImg && !str_starts_with($pImg, 'http') && !str_starts_with($pImg, 'client-assets') && !str_starts_with($pImg, 'assets') && !str_starts_with($pImg, 'storage') && !str_starts_with($pImg, '/storage')) {
        $pImg = asset('client-assets/' . ltrim($pImg, '/'));
    } elseif ($pImg && !str_starts_with($pImg, 'http')) {
        $pImg = asset(ltrim($pImg, '/'));
    }
@endphp

@section('title', $pTitle . ' — S54 COFFEE')

@section('content')
<section style="background-color: #FAF8F5; padding: 60px 20px 80px;">
    <div class="o-wrapper" style="max-width: 800px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; padding: clamp(24px, 5vw, 48px); box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
        <div style="margin-bottom: 12px;">
            <a href="{{ route('client.blog.index', ['locale' => $locale]) }}" style="font-size: 12px; font-weight: 700; color: #D68E1D; text-transform: uppercase; letter-spacing: 1px; text-decoration: none;">
                &larr; {{ $locale === 'vi' ? 'Cẩm Nang Cà Phê' : 'Journal' }}
            </a>
            <span style="color: #BAADA1; margin: 0 8px;">•</span>
            <span style="font-size: 12px; color: #8A7B70;">{{ $post->published_at?->format('d/m/Y') ?? now()->format('d/m/Y') }}</span>
        </div>
        
        <h1 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(30px, 4.5vw, 44px); font-weight: 700; color: #2F221A; margin: 12px 0 24px; line-height: 1.25;">
            {{ $pTitle }}
        </h1>


        <div class="s54-article-content" style="color: #3D2E24; font-size: 16px; line-height: 1.8;">
            {!! $pContent !!}
        </div>

        <div style="border-top: 1px solid #EBE7E1; margin-top: 48px; padding-top: 24px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('client.blog.index', ['locale' => $locale]) }}" style="color: #2F221A; font-weight: 700; text-decoration: none; font-size: 13px;">
                &larr; {{ $locale === 'vi' ? 'Quay lại danh sách bài viết' : 'Back to journal' }}
            </a>
        </div>
    </div>
</section>
@endsection
