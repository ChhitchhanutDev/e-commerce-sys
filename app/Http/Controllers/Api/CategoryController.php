<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ], Response::HTTP_OK);
    }

    public function products(Request $request, Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->with('category')
            ->when($request->query('q'), function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
