<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Catalog\ProductQueryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __construct(
        private readonly ProductQueryService $productQuery,
    ) {}

    public function index(Request $request): View
    {
        $categories = Category::where('is_active', true)
            ->where('is_draft', false)
            ->orderBy('sort_order')
            ->get();

        $filters = $request->only(['category', 'brand', 'q', 'min_price', 'max_price', 'sort_by']);

        $products = $this->productQuery
            ->listing($filters)
            ->with(['images', 'variants', 'category'])
            ->paginate(12)
            ->withQueryString();

        return view('client.catalog.index', compact('products', 'categories'));
    }

    public function show(string $locale, string $slug): View
    {
        $product = $this->productQuery->findActiveDetail($slug);

        if (! $product) {
            abort(404);
        }

        $relatedProducts = \App\Models\Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn($q) => $q->where('category_id', $product->category_id))
            ->with(['images', 'variants'])
            ->take(4)
            ->get();

        if ($relatedProducts->count() < 4) {
            $more = \App\Models\Product::where('is_active', true)
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->with(['images', 'variants'])
                ->take(4 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($more);
        }

        return view('client.catalog.product', compact('product', 'relatedProducts'));
    }
}
