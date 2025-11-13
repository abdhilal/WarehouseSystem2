<?php

namespace App\Services;

use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyService
{
    public function getPharmacies(Request $request = null)
    {
        $query = Pharmacy::query()->with(['warehouse', 'area', 'representative']);
        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }
        return $query->latest()->paginate(20);
    }

    public function applySearch($query, string $term)
    {
        $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhereHas('warehouse', function ($w) use ($term) {
                  $w->where('name', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('area', function ($a) use ($term) {
                  $a->where('name', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('representative', function ($r) use ($term) {
                  $r->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('email', 'LIKE', "%{$term}%");
              });
        });
    }

    public function createPharmacy(array $data): Pharmacy
    {
        return Pharmacy::create($data);
    }

    public function updatePharmacy(Pharmacy $pharmacy, array $data): Pharmacy
    {
        $pharmacy->update($data);
        return $pharmacy;
    }

    public function deletePharmacy(Pharmacy $pharmacy): void
    {
        $pharmacy->delete();
    }
}