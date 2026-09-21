<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function contact(string $locale): View
    {
        return view('client.pages.contact');
    }

    public function show(string $locale, string $slug): View
    {
        if ($slug === 'our-story') {
            return view('client.pages.our-story');
        }

        if ($slug === 'wholesale') {
            return view('client.pages.wholesale');
        }

        if ($slug === 'lien-he' || $slug === 'contact') {
            return view('client.pages.contact');
        }

        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if ($page) {
            $title = is_array($page->title) ? ($page->title[$locale] ?? $page->title['vi'] ?? '') : ($page->getTranslation('title', $locale, false) ?: $page->title);
            $metaTitle = is_array($page->meta_title) ? ($page->meta_title[$locale] ?? $page->meta_title['vi'] ?? $title) : ($page->getTranslation('meta_title', $locale, false) ?: $title);
            $metaDescription = is_array($page->meta_description) ? ($page->meta_description[$locale] ?? $page->meta_description['vi'] ?? '') : ($page->getTranslation('meta_description', $locale, false) ?: '');
            $html = is_array($page->published_html) ? ($page->published_html[$locale] ?? $page->published_html['vi'] ?? '') : ($page->getTranslation('published_html', $locale, false) ?: $page->published_html);

            return view('client.pages.show', compact('page', 'title', 'metaTitle', 'metaDescription', 'html'));
        }

        abort(404);
    }
}
