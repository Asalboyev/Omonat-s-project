<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Breand;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * @OA\PathItem(path="/api/products")
 */
class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();

        // Ensure the products are always an array latest()->paginate()
        $productsArray = $products->toArray();

        if (empty($productsArray)) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($productsArray);
    }

    public function breand_index()
    {
        $breands = Breand::all();

        // Ensure the products are always an array
        $productsArray = $breands->toArray();

        if (empty($productsArray)) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($productsArray);
    }

    public function filter()
{
    $category = request()->query('category');
    $perPage = request()->query('per_page', 24); // You can dynamically set per page items with a default of 24
    $currentPage = LengthAwarePaginator::resolveCurrentPage();

    if (is_null($category)) {
        return response()->json(['message' => 'Category is required'], 400);
    }

    // Retrieve the category by slug or ID
    $categoryData = ProductCategory::where('slug', $category)
        ->orWhere('id', $category)
        ->first();

    if (!$categoryData) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Initialize category titles
    $mainCategoryTitle = null;
    $subCategoryTitle = null;

    // Check if the selected category is a subcategory
    if ($categoryData->product_category_id) {
        // If the category is a subcategory, get the main category
        $mainCategory = ProductCategory::find($categoryData->product_category_id);
        if ($mainCategory) {
            $mainCategoryTitle = $mainCategory->title; // Main category title
        }
        $subCategoryTitle = $categoryData->title; // Subcategory title
    } else {
        // If it's a main category
        $mainCategoryTitle = $categoryData->title; // Main category title
    }

    // Get the category and subcategory IDs
    $categoryIds = ProductCategory::where('slug', $category)
        ->orWhere('product_category_id', $category)
        ->pluck('id')
        ->toArray();

    // Query for products in the category and its subcategories, and randomize the order
    $randomProductsQuery = Product::whereIn('product_category_id', $categoryIds)
        ->inRandomOrder(); // Add random order here

    // Get the total number of products in the selected category and subcategories
    $totalProductsInCategory = $randomProductsQuery->count();

    // Handle pagination logic and skip if there are no products for the page
    if ($totalProductsInCategory === 0 || ($currentPage - 1) * $perPage >= $totalProductsInCategory) {
        return response()->json(['message' => 'No products found in this category or its subcategories'], 404);
    }

    // Paginate products for the requested page
    $products = $randomProductsQuery->skip(($currentPage - 1) * $perPage)
        ->take($perPage)
        ->get();

    // Manually handle pagination data
    $paginator = new LengthAwarePaginator(
        $products,
        $totalProductsInCategory, // Total products in the selected category
        $perPage,
        $currentPage,
        [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]
    );

    return response()->json([
        'main_category_title' => $mainCategoryTitle, // Main category title
        'sub_category_title' => $subCategoryTitle,   // Subcategory title if available
        'products' => $paginator->items(),
        'total_products_in_category' => $totalProductsInCategory, // Total number of products in the selected category
        'total_pages' => $paginator->lastPage(), // Total pages for this category
        'current_page' => $paginator->currentPage(),
        'per_page' => $paginator->perPage(),
    ]);
}
 
// public function filter()
// {
//     $category = request()->query('category');
//     $perPage = request()->query('per_page', 24); // You can dynamically set per page items with a default of 24
//     $currentPage = LengthAwarePaginator::resolveCurrentPage();

//     if (is_null($category)) {
//         return response()->json(['message' => 'Category is required'], 400);
//     }

//     // Retrieve the category by slug or ID
//     $categoryData = ProductCategory::where('slug', $category)
//         ->orWhere('id', $category)
//         ->first();

//     if (!$categoryData) {
//         return response()->json(['message' => 'Category not found'], 404);
//     }

//     // Initialize category titles
//     $mainCategoryTitle = null;
//     $subCategoryTitle = null;

//     // Check if the selected category is a subcategory
//     if ($categoryData->product_category_id) {
//         // If the category is a subcategory, get the main category
//         $mainCategory = ProductCategory::find($categoryData->product_category_id);
//         if ($mainCategory) {
//             $mainCategoryTitle = $mainCategory->title; // Main category title
//         }
//         $subCategoryTitle = $categoryData->title; // Subcategory title
//     } else {
//         // If it's a main category
//         $mainCategoryTitle = $categoryData->title; // Main category title
//     }

//     // Get the category and subcategory IDs
//     $categoryIds = ProductCategory::where('slug', $category)
//         ->orWhere('product_category_id', $category)
//         ->pluck('id')
//         ->toArray();

//     // Query for products in the category and its subcategories
//     $randomProductsQuery = Product::whereIn('product_category_id', $categoryIds);

//     // Get the total number of products in the selected category and subcategories
//     $totalProductsInCategory = $randomProductsQuery->count();

//     // Handle pagination logic and skip if there are no products for the page
//     if ($totalProductsInCategory === 0 || ($currentPage - 1) * $perPage >= $totalProductsInCategory) {
//         return response()->json(['message' => 'No products found in this category or its subcategories'], 404);
//     }

//     // Paginate products for the requested page
//     $products = $randomProductsQuery->skip(($currentPage - 1) * $perPage)
//         ->take($perPage)
//         ->get();

//     // Manually handle pagination data
//     $paginator = new LengthAwarePaginator(
//         $products,
//         $totalProductsInCategory, // Total products in the selected category
//         $perPage,
//         $currentPage,
//         [
//             'path' => LengthAwarePaginator::resolveCurrentPath(),
//         ]
//     );

//     return response()->json([
//         'main_category_title' => $mainCategoryTitle, // Main category title
//         'sub_category_title' => $subCategoryTitle,   // Subcategory title if available
//         'products' => $paginator->items(),
//         'total_products_in_category' => $totalProductsInCategory, // Total number of products in the selected category
//         'total_pages' => $paginator->lastPage(), // Total pages for this category
//         'current_page' => $paginator->currentPage(),
//         'per_page' => $paginator->perPage(),
//     ]);
// }





    public function breand_filter()
    {
        // Brend slugni so'rovdan olish
        $breandSlug = request()->query('breand');

        if (is_null($breandSlug)) {
            return response()->json(['message' => 'Breand slug is required'], 400);
        }

        // Brendni slug orqali topish
        $breand = Breand::where('slug', $breandSlug)->first();

        if (is_null($breand)) {
            return response()->json(['message' => 'Breand not found'], 404);
        }

        // Brendning id si bo'yicha mahsulotlarni olish
        $products = Product::where('breand_id', $breand->id)->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this breand'], 404);
        }

        return response()->json($products);
    }



public function show($slug)
{
    $product = Product::with('breand')->where('slug', $slug)->first();

    if (is_null($product)) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json($product);
}
    public function breand_show($id)
    {
        $breand = Breand::find($id);

        if (is_null($breand)) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($breand);
    }
}
