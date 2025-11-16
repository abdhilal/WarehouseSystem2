<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Representative;

class RepresentativeService
{
    public function getRepresentatives(Request $request = null)
    {
        $query = Representative::query()
            ->with(['warehouse'])
            ->withCount(['pharmacies', 'areas'])
            ->withSum('transactions', 'value_income')
            ->withSum('transactions', 'value_output')
            ->where('type', 'sales')->where('warehouse_id', auth()->user()->warehouse_id);

        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        return $query->latest()->paginate(20);
    }

    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    public function createRepresentative(array $data): Representative
    {
        return Representative::create($data);
    }

    public function updateRepresentative(Representative $representative, array $data): bool
    {
        return $representative->update($data);
    }

    public function deleteRepresentative(Representative $representative): ?bool
    {
        return $representative->delete();
    }

}
