<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Representative;

class RepresentativeService
{
    public function getRepresentatives(Request $request = null)
    {
        $fileId = getDefaultFileId();
        $warehouseId = auth()->user()->warehouse_id;

        $query = Representative::query()
            ->where('type', 'sales')
            ->where('warehouse_id', $warehouseId)

            // تحميل العلاقات
            ->with(['warehouse'])
            ->withCount(['pharmacies', 'areas'])

            // إجماليات الدخل والخرج
            ->withSum(['transactions as total_income' => function ($q) use ($fileId) {
                $q->where('file_id', $fileId);
            }], 'value_income')

            ->withSum(['transactions as total_output' => function ($q) use ($fileId) {
                $q->where('file_id', $fileId);
            }], 'value_output')

            // يظهر فقط من لديه عمليات (حسب الفايل)
            ->whereHas('transactions', function ($q) use ($fileId) {
                $q->where('file_id', $fileId);
            });

        // البحث
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
