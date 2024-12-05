<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\PortfolioCategory;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function categories(Request $request)
    {
        try {
            $categories = Category::all();
            return response()->json([
                'ok'=>true,
                'lang'=>$categories,
            ]);
        }
        catch (\Exception $e){
            return  response()->json([
                'ok'=>false,
                'mag'=>$e->getMessage(),
            ]);
        }
    }
    public function product_category(Request $request)
    {
        try {
            $product_category = ProductCategory::all();
            return response()->json([
                'ok'=>true,
                'lang'=>$product_category,
            ]);
        }
        catch (\Exception $e){
            return  response()->json([
                'ok'=>false,
                'mag'=>$e->getMessage(),
            ]);
        }
    }
    public function portfolio_category(Request $request)
    {
        try {
            $portfolio_category = PortfolioCategory::all();
            return response()->json([
                'ok'=>true,
                'lang'=>$portfolio_category,
            ]);
        }
        catch (\Exception $e){
            return  response()->json([
                'ok'=>false,
                'mag'=>$e->getMessage(),
            ]);
        }
    }
    public function service_category(Request $request)
    {
        try {
            $service_category = ServiceCategory::all();
            return response()->json([
                'ok'=>true,
                'lang'=>$service_category,
            ]);
        }
        catch (\Exception $e){
            return  response()->json([
                'ok'=>false,
                'mag'=>$e->getMessage(),
            ]);
        }
    }

}


