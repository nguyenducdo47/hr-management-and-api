<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Api\ProductRequest;


class ProductController extends Controller
{

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $infoProduct=$product->only(['id', 'sku', 'name', 'slug', 'description', 'image']);

        $category = ['category' =>$product->category->only(['id', 'name', 'slug'])];

        $date=$product->only(['created_at', 'updated_at']);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => array_merge( $infoProduct, $category, $date ),
        ]);
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        }

        $products = $query->paginate(5);

        if ($products->isEmpty()) {
            if ($request->has('search')) {
                return response()->json([
                    'status' => false,
                    'message' => 'No products found with the name: ' . $request->query('search')
                ], 404);
            }

            return response()->json([
                'status' => false,
                'message' => 'There are no products.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $products->toArray(),
        ]);
    }

    public function store(ProductRequest  $request)
    {
        $product = Product::create($request->validated());

        $productData = $product->only(['id', 'sku', 'name', 'slug', 'description', 'image', 'category_id', 'created_at', 'updated_at']);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'product' => $productData,
        ], 201);
    }

    public function update(ProductRequest  $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 204);
    }


    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product does not exist',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ], 204);
    }
}
