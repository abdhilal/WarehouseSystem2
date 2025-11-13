<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Factory;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->service->getProducts($request);
        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $factories = Factory::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        return view('pages.products.partials.create', compact('factories', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->service->createProduct($request->validated());
        return redirect()->route('products.index')
            ->with('success', __('Product created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['factory', 'warehouse']);
        return view('pages.products.partials.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $factories = Factory::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        return view('pages.products.partials.edit', compact('product', 'factories', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->service->updateProduct($product, $request->validated());
        return redirect()->route('products.index')
            ->with('success', __('Product updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->service->deleteProduct($product);
        return redirect()->back()
            ->with('success', __('Product deleted successfully.'));
    }
}
