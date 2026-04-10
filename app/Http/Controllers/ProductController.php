<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'required|string',
            'precio'      => 'required|numeric|min:0.01',
            'categoria'   => 'required|string|max:80',
            'stock'       => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);
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
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nombre'      => 'sometimes|string|max:150',
            'precio'      => 'sometimes|numeric|min:0.01',
            'stock'       => 'sometimes|integer|min:0',
        ]);

        $product->update($validated);
        return response()->json($product, 200);
    }

    public function search(Request $request) {
        $param = $request->query('q');

        if (!$param) {
        return response()->json(['error' => 'Parametro de busqueda requerido'], 400);
        }

        $searchService = new \App\Services\ProductSearchService();
        $results = $searchService->search($param);

        if(!$results["hits"]) {
            return response()->json(['error' => 'No se encontraron resultados'], 404);
        }

        return response()->json($results["hits"], 200);
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
