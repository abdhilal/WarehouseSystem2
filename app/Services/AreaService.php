<?php

namespace App\Services;

use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;

class AreaService
{
    public function getAreasForUser(Request $request = null, ?User $user = null)
    {
        $user = $user ?? auth()->user();
        $query = Area::with('warehouse', 'transactions')
            ->withSum('transactions', 'value_income')
            ->withSum('transactions', 'value_output');



        if (!$user->hasPermissionTo('view-area')) {
            $query->where('warehouse_id', $user->warehouse_id);
        }

        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        return $query->latest()->paginate(20);
    }

    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('warehouse', function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%");
                });
        });
    }

    public function createArea(array $data): Area
    {
        return Area::create($data);
    }

    public function updateArea(Area $area, array $data): bool
    {
        return $area->update($data);
    }

    public function deleteArea(Area $area): ?bool
    {
        return $area->delete();
    }
}
