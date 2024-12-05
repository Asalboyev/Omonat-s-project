<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class SearchController extends Controller
{
//    public function search(Request $request)
//    {
//        // Search products based on title, optional_key, standard_key, or descriptions
//        $products = Product::where('status', 'active')
//            ->where(function ($query) use ($request) {
//                $query->where('title->en', 'like', '%' . $request->search . '%')
//                    ->orWhere('title->ar', 'like', '%' . $request->search . '%')
//                    ->orWhere('descriptions->en', 'like', '%' . $request->search . '%')
//                    ->orWhere('descriptions->ar', 'like', '%' . $request->search . '%');
//            });
//
//        // Sorting
//        if (isset($request->sort) && $request->sort != '') {
//            switch ($request->sort) {
//                case 'popular':
//                    $products = $products->orderBy('view', 'desc');
//                    break;
//
//                case 'expensive':
//                    $products = $products->orderBy('price', 'desc');
//                    break;
//
//                case 'cheap':
//                    $products = $products->orderBy('price', 'asc');
//                    break;
//            }
//        }
//
//        $products = $products->with(['category', 'category.subcategories'])
//            ->limit(20)
//            ->get();
//
//        // Search categories based on title or descriptions
//        $categories = ProductCategory::where(function ($query) use ($request) {
//            $query->where('title->en', 'like', '%' . $request->search . '%')
//                ->orWhere('title->ar', 'like', '%' . $request->search . '%')
//                ->orWhere('descriptions->en', 'like', '%' . $request->search . '%')
//                ->orWhere('descriptions->ar', 'like', '%' . $request->search . '%');
//        })
//            ->limit(20)
//            ->get();
//
//        // Respond with products and categories
//        return response([
//            'products' => $products,
//            'categories' => $categories,
//        ]);
//    }
  public function search(Request $request)
{
    // Ensure a category slug is provided
    $categorySlug = $request->query('category');
    if (is_null($categorySlug)) {
        return response()->json(['message' => 'Category slug is required'], 400);
    }

    // Fetch the category and its subcategories by slug
    $category = ProductCategory::where('slug', $categorySlug)->first();

    if (is_null($category)) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Get the category IDs including the main category and its subcategories
    $categoryIds = ProductCategory::where('id', $category->id)
        ->orWhere('product_category_id', $category->id) // 'parent_id' connects subcategories to the main category
        ->pluck('id')
        ->toArray();

    // Search products within the specific category and its subcategories
    $products = Product::where('status', 'active')
        ->whereIn('product_category_id', $categoryIds) // Filter by category and subcategories
        ->where(function ($query) use ($request) {
            $query->where('title->en', 'like', '%' . $request->search . '%')
                ->orWhere('title->ar', 'like', '%' . $request->search . '%')
                ->orWhere('descriptions->en', 'like', '%' . $request->search . '%')
                ->orWhere('descriptions->ar', 'like', '%' . $request->search . '%');
        });

    // Sorting
    if (isset($request->sort) && $request->sort != '') {
        switch ($request->sort) {
            case 'popular':
                $products = $products->orderBy('view', 'desc');
                break;

            case 'expensive':
                $products = $products->orderBy('price', 'desc');
                break;

            case 'cheap':
                $products = $products->orderBy('price', 'asc');
                break;
        }
    }

    $products = $products->with(['category', 'category.subcategories'])
        ->limit(20)
        ->get();

    // Search categories based on title or descriptions
    $categories = ProductCategory::where(function ($query) use ($request) {
        $query->where('title->en', 'like', '%' . $request->search . '%')
            ->orWhere('title->ar', 'like', '%' . $request->search . '%')
            ->orWhere('descriptions->en', 'like', '%' . $request->search . '%')
            ->orWhere('descriptions->ar', 'like', '%' . $request->search . '%');
    })
        ->limit(20)
        ->get();

    // Respond with products and categories
    return response()->json([
        'products' => $products,
        'categories' => $categories,
    ]);
}


}
