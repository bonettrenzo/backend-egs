<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Dtos\ProductSearchResource;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $products = Product::all();
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json($product, 200);
    }

    public function search(Request $request) {
        $param = $request->query('q');

        if (!$param) {
        return response()->json(['error' => 'Parametro de busqueda requerido'], 400);
        }

        $searchService = new \App\Services\ProductSearchService();
        $results = $searchService->search($param);

        $products = array_map(function ($hit) {
            return ProductSearchResource::fromElastic($hit)->toArray();
        }, $results['hits']['hits']);

        return response()->json($products, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204); 
    }
}
