<?php

namespace App\Services;

use App\Models\AreaRepresentative;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Representative;

class RepresentativeMedicalService
{
    public function getRepresentativesMedical(Request $request = null)
    {
        $query = Representative::query()->with(['warehouse'])->where('type', 'medical');


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

    public function createRepresentativeMedical(array $data): Representative
    {
        $data['type'] = 'medical';
        $data['warehouse_id'] = auth()->user()->warehouse_id;
        $representative =  Representative::create($data);

        return AreaRepresentative::create([
            $representative->id,
            $data['area_ids']
        ]);
    }

    public function updateRepresentativeMedical(Representative $representative, array $data): bool
    {
        return $representative->update($data);
    }

    public function deleteRepresentativeMedical(Representative $representative): ?bool
    {
        return $representative->delete();
    }
}
