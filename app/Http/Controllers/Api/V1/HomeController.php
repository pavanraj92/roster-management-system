<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class HomeController extends BaseController
{
    /**
     * Home / Products Listing API
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // 🔹 Categories with children + products count
            $categories = Category::query()
                ->active()
                ->whereNull('parent_id')
                ->with([
                    'children' => fn ($query) => $query
                        ->active()
                        ->orderBy('name')
                        ->select(['id', 'name', 'slug', 'parent_id']),
                ])
                ->withCount([
                    'products as products_count' => fn ($query) => $query->active(),
                ])
                ->orderBy('name')
                ->get(['id', 'name', 'slug', 'image']);

            // 🔹 Featured categories
            $featuredCategories = Category::query()
                ->active()
                ->whereNull('parent_id')
                ->where('featured', true)
                ->orderBy('name')
                ->get(['id', 'name', 'slug', 'image']);

            // 🔹 Filters
            $selectedCategory = null;
            $categoryFilter = (string) $request->query('category', '');
            $searchQuery = trim((string) $request->query('q', ''));

            // 🔹 Products query
            $productsQuery = Product::query()
                ->active()
                ->withListingRelations()
                ->byCategoryIdentifier($categoryFilter)
                ->search($searchQuery);

            // 🔹 Selected category detail
            if ($categoryFilter !== '') {
                $selectedCategory = Category::query()
                    ->active()
                    ->with([
                        'parent:id,name,slug,parent_id',
                        'parent.children' => fn ($query) => $query
                            ->active()
                            ->orderBy('name')
                            ->select(['id', 'name', 'slug', 'parent_id']),
                        'children' => fn ($query) => $query
                            ->active()
                            ->orderBy('name')
                            ->select(['id', 'name', 'slug', 'parent_id']),
                    ])
                    ->byIdentifier($categoryFilter)
                    ->first();
            }

            // 🔹 Paginated products
            $products = $productsQuery
                ->latestFirst()
                ->paginate(12)
                ->withQueryString();

            // 🔹 Final API response
            return $this->successResponse(
                'Home data fetched successfully.',
                [
                    'categories' => $categories,
                    'featured_categories' => $featuredCategories,
                    'selected_category' => $selectedCategory,
                    'products' => $products,
                ]
            );

        } catch (\Throwable $e) {
            return $this->errorResponse(
                'Something went wrong.',
                $e->getMessage(),
                500
            );
        }
    }
    
    /**
     * Categories Listing (Parent categories only)
     */
    public function categories(): JsonResponse
    {
        try {
            // Fetch parent categories with nested children
            $categories = Category::query()
                ->active()
                ->whereNull('parent_id')
                ->with([
                    'children' => function ($query) {
                        $query->active()
                            ->latest('id'); // fetch children latest first
                    }
                ])
                ->latest('id')
                ->get();

                // dd($categories);

            // Transform categories for API response
            $categories = $categories->map(function ($category) {
                return [
                    'id'       => $category->id,
                    'name'     => $category->name,
                    'slug'     => $category->slug,
                    'image'    => $category->image_url,
                    'featured' => $category->featured,
                    'children' => $category->children->map(function ($child) {
                        return [
                            'id'       => $child->id,
                            'name'     => $child->name,
                            'slug'     => $child->slug,
                            'image'    => $child->image_url,
                            'featured' => $child->featured,
                        ];
                    }),
                ];
            });

            return $this->successResponse(
                'Categories fetched successfully.',
                $categories
            );
        } catch (\Throwable $e) {
            return $this->errorResponse(
                'Something went wrong.',
                $e->getMessage(),
                500
            );
        }
    }

    
}
