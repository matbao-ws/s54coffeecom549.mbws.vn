@extends('client.layouts.app')

@section('title', $metaTitle ?: $title)

{{-- Guarded: `@section($name, null)` makes Blade open an output buffer it never
     closes, because a null body means "the section content follows". --}}
@if($metaDescription)
    @section('meta_description', $metaDescription)
@endif

@section('content')
    <div class="o-wrapper" style="max-width: 960px; margin: 48px auto 80px; padding: 0 20px;">
        <h1 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(32px, 4vw, 44px); font-weight: 700; color: #2F221A; margin-bottom: 24px; text-align: center;">
            {{ $title }}
        </h1>
        <div style="width: 50px; height: 2px; background-color: #D68E1D; margin: 0 auto 36px;"></div>

        {{-- data-client-editable-root is what the inline editor looks for. A theme
             layout that renders page content in its own wrapper only has to carry
             this attribute; it does not have to reproduce the id convention. It is
             emitted only for an admin who may edit — a guest gets no hook at all. --}}
        <main id="client-page-{{ $page->id }}"
              @if(auth()->user()?->canEditClientContent()) data-client-editable-root @endif
              translate="no" class="notranslate" style="line-height: 1.8; color: #4A3A2F; font-size: 15px; background: #FFFFFF; padding: clamp(24px, 4vw, 48px); border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #EAE2D8;">
            {!! $html ?: '<p style="color: #8A7B70; text-align: center;">Nội dung trang đang được cập nhật.</p>' !!}
        </main>
    </div>
@endsection
