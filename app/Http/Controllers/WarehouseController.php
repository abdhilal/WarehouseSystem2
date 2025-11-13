<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Services\WarehouseService;


class WarehouseController extends Controller
{
    use AuthorizesRequests;

    protected $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index(Request $request)
    {
        $warehouses = $this->warehouseService->getWarehousesForUser($request);
        return view('pages.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('pages.warehouses.partials.create');
    }

    public function store(StoreWarehouseRequest $request)
    {
        $warehouse = $this->warehouseService->createWarehouse($request->validated());
        return redirect()->route('warehouses.index')
            ->with('success', __('Warehouse created successfully.'));
    }

    public function show(Warehouse $warehouse)
    {
        $warehouse->load('areas', 'pharmacies', 'products', 'transactions', 'users');
        $representatives = $warehouse->users()->role('Representative')->orderBy('name')->get();
        return view('pages.warehouses.partials.show', compact('warehouse', 'representatives'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('pages.warehouses.partials.edit', compact('warehouse'));
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $this->warehouseService->updateWarehouse($warehouse, $request->validated());
        return redirect()->route('warehouses.index')
            ->with('success', __('Warehouse updated successfully.'));
    }

    public function destroy(Warehouse $warehouse)
    {
        $this->warehouseService->deleteWarehouse($warehouse);
        return redirect()->back()
            ->with('success', __('Warehouse deleted successfully.'));
    }
}
