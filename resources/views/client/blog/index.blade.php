@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
    $site = app(\App\Services\SiteContentService::class);
    $blogBanner = $site->image('blog.hero.banner', asset('client-assets/images/s54/story_roasting_master.jpg'));
    $canEdit = (bool) (auth()->user()?->canEditClientContent() && auth()->user()->can('media.view'));
@endphp

@section('title', ($locale === 'vi' ? 'Cẩm Nang Cà Phê & Tin Tức S54 Coffee' : 'S54 Coffee Journal & Brewing Guides'))
@section('meta_description', ($locale === 'vi' ? 'Cẩm nang cà phê S54: kiến thức pha chế, bí quyết bảo quản hạt, câu chuyện thương hiệu và tin tức mới nhất từ S54 COFFEE.' : 'S54 Coffee journal: brewing techniques, bean preservation tips, brand stories and latest news from S54 COFFEE.'))

@section('content')
<section class="s54-blog-hero" style="background: radial-gradient(circle at center, rgba(47,34,26,0.85) 0%, rgba(26,18,14,0.96) 100%), url('{{ $blogBanner }}') center/cover no-repeat; padding: 80px 20px 60px; text-align: center; color: #FAF6F1; position: relative;">
    @if($canEdit)
        <div style="position: absolute; top: 16px; right: 20px; z-index: 10;">
            <button type="button" class="s54-edit-banner-trigger" data-block-key="blog.hero.banner" data-block-type="image" src="{{ $blogBanner }}" title="Click để thay đổi ảnh nền banner trang Cẩm nang" style="background: rgba(31,41,55,0.9); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(4px); box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                <span>📷 Đổi ảnh banner</span>
            </button>
        </div>
    @endif
    <div class="o-wrapper" style="max-width: 960px; margin: 0 auto; position: relative; z-index: 1;">
        <x-client::editable key="blog.hero.title" tag="h1" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(32px, 4.5vw, 46px); font-weight: 700; margin-bottom: 14px; color: #FAF6F1 !important;">
            {{ $locale === 'vi' ? 'Cẩm Nang & Câu Chuyện Cà Phê' : 'Coffee Journal & Heritage' }}
        </x-client::editable>
        <x-client::editable key="blog.hero.subtitle" tag="p" style="color: #D6C7BC !important; font-size: clamp(14px, 1.8vw, 16.5px); max-width: 650px; margin: 0 auto; line-height: 1.6;">
            {{ $locale === 'vi' ? 'Kiến thức pha chế, bí quyết bảo quản và hành trình khám phá các vùng trồng cà phê Việt Nam.' : 'Brewing techniques, bean preservation tips, and stories from Vietnamese coffee farms.' }}
        </x-client::editable>
    </div>
</section>

<section style="background-color: #FAF8F5; padding: 60px 20px 80px;">
    <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 36px;">
            @forelse($posts ?? [] as $post)
                @php
                    $pTitle = is_array($post->title) ? ($post->title[$locale] ?? $post->title['vi'] ?? '') : ($post->getTranslation('title', $locale, false) ?: $post->title);
                    $pSummary = is_array($post->summary) ? ($post->summary[$locale] ?? $post->summary['vi'] ?? '') : ($post->getTranslation('summary', $locale, false) ?: $post->summary);
                    $pImg = $post->image_url ?: 'client-assets/images/s54/story_roasting_master.jpg';
                    if (!str_starts_with($pImg, 'http') && !str_starts_with($pImg, 'client-assets') && !str_starts_with($pImg, 'assets') && !str_starts_with($pImg, 'storage') && !str_starts_with($pImg, '/storage')) {
                        $pImg = asset('client-assets/' . ltrim($pImg, '/'));
                    } elseif (!str_starts_with($pImg, 'http')) {
                        $pImg = asset(ltrim($pImg, '/'));
                    }
                @endphp
                <article style="background: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); display: flex; flex-direction: column;">
                    <a href="{{ route('client.blog.show', ['locale' => $locale, 'slug' => $post->slug]) }}">
                        <img src="{{ $pImg }}" alt="{{ $pTitle }}" style="width: 100%; height: 220px; object-fit: cover;">
                    </a>
                    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span style="font-size: 11.5px; font-weight: 700; color: #D68E1D; text-transform: uppercase;">{{ $post->published_at?->format('d/m/Y') ?? now()->format('d/m/Y') }}</span>
                            <h2 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 22px; font-weight: 700; margin: 8px 0 12px; line-height: 1.3;">
                                <a href="{{ route('client.blog.show', ['locale' => $locale, 'slug' => $post->slug]) }}" style="color: #2F221A; text-decoration: none;">
                                    {{ $pTitle }}
                                </a>
                            </h2>
                            <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6;">{{ Str::limit($pSummary, 120) }}</p>
                        </div>
                        <div style="margin-top: 18px;">
                            <a href="{{ route('client.blog.show', ['locale' => $locale, 'slug' => $post->slug]) }}" style="color: #D68E1D; font-size: 12.5px; font-weight: 700; text-transform: uppercase; text-decoration: none;">
                                {{ $locale === 'vi' ? 'Đọc tiếp' : 'Read more' }} &rarr;
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #8A7B70;">
                    {{ $locale === 'vi' ? 'Chưa có bài viết nào.' : 'No articles published yet.' }}
                </div>
            @endforelse
        </div>

        @if(method_exists($posts, 'links'))
            <div style="margin-top: 50px; display: flex; justify-content: center;">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
