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


        $representative->areas()->attach($data['area_ids']);
        $representative->files()->attach($data['file_ids']);
        return $representative;
    }

    public function updateRepresentativeMedical($representativeId, array $data)
    {
        $representative = Representative::find($representativeId);
        $representative->update(['name' => $data['name']]);

        $representative->areas()->detach();
        $representative->files()->detach();

        $representative->areas()->attach($data['area_ids']);
        $representative->files()->attach($data['file_ids']);
        return $representative;
    }

    public function deleteRepresentativeMedical($representativeId): ?bool
    {
        $representative = Representative::find($representativeId);
        return $representative->delete();
    }

    public function isActiveRepresentativeMedical(Representative $representative): void
    {
        $representative->is_active = ! (bool) $representative->is_active;
        $representative->save();
    }

    public function getRepresentativesMedical(Request $request = null)
    {
        // dd($request);


        $currentFileId = getDefaultFileId();

        $query = Representative::query()
            ->with(['warehouse', 'areas'])
            ->where('warehouse_id', auth()->user()->warehouse_id)
            ->withCount('areas')
            ->where('type', 'medical');

        if (!($request && $request->boolean('all'))) {
            $query->whereHas('files', function ($q) use ($currentFileId) {
                $q->where('file_id', $currentFileId);
            });
        }

        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        $perPage = 20;
        if ($request && $request->boolean('all')) {
            $perPage = max(1, (clone $query)->count());
        }

        return $query->latest()->paginate($perPage);
    }
}
