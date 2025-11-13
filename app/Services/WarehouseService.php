<?php

namespace App\Services;

use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Http\Request;

class WarehouseService
{
    /**
     * Get all warehouses with pagination and related data.
     */
    public function getAllWarehouses()
    {
        return Warehouse::paginate(20);
    }

    /**
     * Get a warehouse by ID with related data.
     */
    public function getWarehouseById(int $id)
    {
        return Warehouse::findOrFail($id);
    }

    /**
     * Get warehouses based on user role and permissions with search functionality
     */
    public function getWarehousesForUser(Request $request = null, ?User $user = null)
    {
        $user = $user ?? auth()->user();

        $query = Warehouse::query();

        // Apply user role restrictions
        if (!$user->hasPermissionTo('view-all-warehouses')) {
            $query->where('id', $user->warehouse_id);
        }

        // Apply search if provided
        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        return $query->latest()->paginate(20);
    }

    /**
     * Apply search filters to the warehouse query
     */
    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    /**
     * Search warehouses for API or autocomplete
     */
    public function searchWarehouses(string $query, int $perPage = 10)
    {
        return Warehouse::where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('location', 'LIKE', "%{$query}%");
            })
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Create a new warehouse.
     */
    public function createWarehouse(array $data): Warehouse
    {
        return Warehouse::create($data);
    }

    /**
     * Update an existing warehouse.
     */
    public function updateWarehouse(Warehouse $warehouse, array $data): bool
    {
        return $warehouse->update($data);
    }

    /**
     * Delete a warehouse.
     */
    public function deleteWarehouse(Warehouse $warehouse): ?bool
    {
        return $warehouse->delete();
    }
}
