<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Breand;
use App\Models\Product;
use App\Models\ProductCategory;

/**
 * @OA\PathItem(path="/api/product-categories")
 */
class ProductCategoryController extends Controller
{


    public function index()
    {
        // Retrieve all product categories
        $productCategories = ProductCategory::all();

        // Get the root categories (those without a parent)
        $rootCategories = $productCategories->whereNull('product_category_id');

        // Format tree structure for the categories
        $this->formatTree($rootCategories, $productCategories);

        // Return the root categories with nested subcategories
        return response()->json($rootCategories->values()->toArray());
    }
    public function papular()
    {
        // Fetch product categories where 'papular' is 'active'
        $productCategories = ProductCategory::where('popular', 'active')->get();

        $rootCategories = $productCategories->whereNull('product_category_id');

        $this->formatTree($rootCategories, $productCategories);

        return response()->json($rootCategories->values()->toArray());
    }
//    public function getBrands($id)
//    {
//        // Fetch brands associated with the products in the selected category
//        $brands = Breand::whereHas('products', function($query) use ($id) {
//            $query->where('product_category_id', $id);
//        })->get();
//
//        return response()->json(['brands' => $brands]);
//    }
    public function getBrands($slug)
    {
        // Fetch the category based on the slug
        $category = ProductCategory::where('slug', $slug)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Fetch all categories including subcategories
        $categories = ProductCategory::where('id', $category->id)
            ->orWhere('product_category_id', $category->id)
            ->pluck('id');

        // Fetch brands associated with the products in the selected categories
        $brands = Breand::whereHas('products', function($query) use ($categories) {
            $query->whereIn('product_category_id', $categories);
        })->get();

        return response()->json(['brands' => $brands]);
    }
    
  public function getProductsByMainCategorySubCategoryAndBrand($mainCategorySlug, $subCategorySlug, $brandSlug)
    {
        // Fetch the main category based on the slug
        $mainCategory = ProductCategory::where('slug', $mainCategorySlug)->first();

        if (!$mainCategory) {
            return response()->json(['message' => 'Main category not found'], 404);
        }

        // Fetch the subcategory based on the slug and main category
        $subCategory = ProductCategory::where('slug', $subCategorySlug)
            ->where('product_category_id', $mainCategory->id)
            ->first();

        if (!$subCategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

        // Fetch the brand based on the slug
        $brand = Breand::where('slug', $brandSlug)->first();

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        // Fetch products associated with the selected subcategory and brand
        $products = Product::where('product_category_id', $subCategory->id)
            ->where('breand_id', $brand->id)
            ->get();

        return response()->json(['products' => $products]);
    }



    public function show($slug)
    {
        // ProductCategory ni slug bo'yicha topish
        $productCategory = ProductCategory::where('slug', $slug)->first();

        if (is_null($productCategory)) {
            return response()->json(['message' => 'Product category not found'], 404);
        }

        $allCategories = ProductCategory::all();

        $categoryTree = collect([$productCategory]);
        $this->formatTree($categoryTree, $allCategories);

        // Return the category tree, wrapped in an array
        return response()->json($categoryTree->toArray());
    }
    /**
     * Recursively format the category tree with nested subcategories.
     */
    private function formatTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            // Get child categories for the current category
            $category->subcategories = $allCategories->where('product_category_id', $category->id)->values();

            // Recursively format the subcategories
            if ($category->subcategories->isNotEmpty()) {
                $this->formatTree($category->subcategories, $allCategories);
            }
        }
    }
}
