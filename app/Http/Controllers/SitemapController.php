<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate a dynamic XML sitemap from database content.
     *
     * Pulls all active products, posts, categories, post categories,
     * and CMS pages so that any newly-created content is indexed
     * automatically without manual sitemap edits.
     */
    public function index(): Response
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $locale  = 'vi'; // Primary locale

        $urls = [];

        // ── Homepage ──────────────────────────────────────────────
        $urls[] = [
            'loc'        => $baseUrl . '/' . $locale,
            'lastmod'    => now()->toDateString(),
            'changefreq' => 'daily',
            'priority'   => '1.0',
        ];

        // ── Catalog Index ─────────────────────────────────────────
        $urls[] = [
            'loc'        => $baseUrl . '/' . $locale . '/san-pham',
            'lastmod'    => now()->toDateString(),
            'changefreq' => 'daily',
            'priority'   => '0.9',
        ];

        // ── Products ──────────────────────────────────────────────
        $products = Product::where('is_active', true)
            ->whereNotNull('published_at')
            ->orderByDesc('updated_at')
            ->get(['slug', 'updated_at']);

        foreach ($products as $product) {
            $urls[] = [
                'loc'        => $baseUrl . '/' . $locale . '/san-pham/' . $product->slug,
                'lastmod'    => ($product->updated_at ?? now())->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '0.8',
            ];
        }

        // ── Product Categories ────────────────────────────────────
        $categories = Category::where('is_active', true)
            ->where('is_draft', false)
            ->get(['slug', 'updated_at']);

        foreach ($categories as $cat) {
            $urls[] = [
                'loc'        => $baseUrl . '/' . $locale . '/danh-muc/' . $cat->slug,
                'lastmod'    => ($cat->updated_at ?? now())->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '0.7',
            ];
        }

        // ── Blog Index ────────────────────────────────────────────
        $urls[] = [
            'loc'        => $baseUrl . '/' . $locale . '/tin-tuc',
            'lastmod'    => now()->toDateString(),
            'changefreq' => 'daily',
            'priority'   => '0.8',
        ];

        // ── Blog Posts ────────────────────────────────────────────
        $posts = Post::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('updated_at')
            ->get(['slug', 'updated_at', 'published_at']);

        foreach ($posts as $post) {
            $urls[] = [
                'loc'        => $baseUrl . '/' . $locale . '/tin-tuc/' . $post->slug,
                'lastmod'    => ($post->updated_at ?? $post->published_at ?? now())->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.6',
            ];
        }

        // ── Post Categories ───────────────────────────────────────
        if (class_exists(PostCategory::class)) {
            $postCats = PostCategory::where('is_active', true)->get(['slug', 'updated_at']);
            foreach ($postCats as $pc) {
                $urls[] = [
                    'loc'        => $baseUrl . '/' . $locale . '/chuyen-muc/' . $pc->slug,
                    'lastmod'    => ($pc->updated_at ?? now())->toDateString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.5',
                ];
            }
        }

        // ── CMS Pages ─────────────────────────────────────────────
        $staticPages = [
            ['slug' => 'our-story', 'priority' => '0.7'],
            ['slug' => 'wholesale', 'priority' => '0.7'],
        ];

        foreach ($staticPages as $sp) {
            $urls[] = [
                'loc'        => $baseUrl . '/' . $locale . '/pages/' . $sp['slug'],
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => $sp['priority'],
            ];
        }

        // Dynamic CMS pages from DB
        $pages = Page::where('is_active', true)
            ->whereNotIn('slug', ['our-story', 'wholesale'])
            ->get(['slug', 'updated_at']);

        foreach ($pages as $page) {
            $urls[] = [
                'loc'        => $baseUrl . '/' . $locale . '/pages/' . $page->slug,
                'lastmod'    => ($page->updated_at ?? now())->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.5',
            ];
        }

        // ── Build XML ─────────────────────────────────────────────
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url['loc'], ENT_XML1) . "</loc>\n";
            $xml .= "    <lastmod>{$url['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$url['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>\n";

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
