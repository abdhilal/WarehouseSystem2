<?php

namespace App\Services;

use App\Models\AreaRepresentative;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Representative;

class RepresentativeMedicalService
{
    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    public function createRepresentativeMedical(array $data)
    {
        $data['type'] = 'medical';
        $data['warehouse_id'] = auth()->user()->warehouse_id;
        $representative =  Representative::create($data);


        $insertData = [];

        foreach ($data['area_ids'] as $area_id) {
            $insertData[] = [
                'representative_id' => $representative->id,
                'area_id' => $area_id,
            ];
        }

        $areaRepresentatives = AreaRepresentative::insert($insertData);
        return $areaRepresentatives;
    }

    public function updateRepresentativeMedical($representativeId, array $data)
    {
        $representative = Representative::find($representativeId);
        $representative->update(['name' => $data['name']]);

        AreaRepresentative::where('representative_id', $representative->id)->delete();


        $insertData = [];

        foreach ($data['area_ids'] as $area_id) {
            $insertData[] = [
                'representative_id' => $representative->id,
                'area_id' => $area_id,
            ];
        }
        $areaRepresentatives = AreaRepresentative::insert($insertData);
    }

    public function deleteRepresentativeMedical(Representative $representative): ?bool
    {
        return $representative->delete();
    }

    public function getRepresentativesMedical(Request $request = null)
    {
        $query = Representative::query()
            ->with(['warehouse', 'areas'])
            ->withCount(['areas'])
            ->where('type', 'medical');

        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        return $query->latest()->paginate(20);
    }
}
