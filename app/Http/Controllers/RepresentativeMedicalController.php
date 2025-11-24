<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Representative;
use Illuminate\Support\Facades\Hash;
use App\Services\RepresentativeMedicalService;
use App\Http\Requests\StoreRepresentativeRequest;
use App\Http\Requests\UpdateRepresentativeRequest;

class RepresentativeMedicalController extends Controller
{
    protected $service;

    public function __construct(RepresentativeMedicalService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $representativesMedical = $this->service->getRepresentativesMedical($request);

        $repAreaTotals = [];
        foreach ($representativesMedical as $rep) {
            $areaIds = $rep->areas->pluck('id');
            $repAreaTotals[$rep->id] = [
                'income' => (float) Transaction::where('file_id', getDefaultFileId())->whereIn('area_id', $areaIds)->sum('value_income'),
                'output' => (float) Transaction::where('file_id', getDefaultFileId())->whereIn('area_id', $areaIds)->sum('value_output'),
            ];
        }

        return view('pages.representativesMedical.index', compact('representativesMedical', 'repAreaTotals'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->doesntHave('medicalReps')->get();

        return view('pages.representativesMedical.partials.create', compact('warehouses', 'areas'));
    }

    public function store(StoreRepresentativeRequest $request)
    {
        $data = $request->validated();
        $this->service->createRepresentativeMedical($data);
        return redirect()->route('representativesMedical.index')
            ->with('success', __('Representative Medical created successfully.'));
    }



    public function show($representativeId)
    {
        // جلب المندوب العلمي مع المخزن والمناطق
        $representative = Representative::with(['warehouse', 'areas'])->findOrFail($representativeId);

        $fileId = getDefaultFileId();
        $areaIds = $representative->areas->pluck('id');

        // جلب كل المعاملات الموجودة في مناطق هذا المندوب حسب الملف
        $transactions = Transaction::with(['product', 'pharmacy', 'file'])
            ->where('file_id', $fileId)
            ->whereIn('area_id', $areaIds)
            ->get();

        // جلب المناطق مع مجموع الدخل والخرج لكل منطقة بناءً على نفس الملف
        $areas = Area::with('warehouse')
            ->whereIn('id', $areaIds)
            ->withSum(['transactions' => function ($q) use ($fileId) {
                $q->where('file_id', $fileId);
            }], 'value_income')
            ->withSum(['transactions' => function ($q) use ($fileId) {
                $q->where('file_id', $fileId);
            }], 'value_output')
            ->get();

        // حساب المجموعات لجميع المعاملات في المناطق
        $date = [
            'value_income' => (float) $transactions->sum('value_income'),
            'value_output' => (float) $transactions->sum('value_output'),
            'value_gift' => (float) $transactions->sum('value_gift'),
            'quantity_gift' => (int) $transactions->sum('quantity_gift'),
            'quantity_product' => (int) $transactions->sum('quantity_product'),
            'Wholesale_Sale' => $transactions->where('type', 'Wholesale Sale')->count(),
            'Wholesale_Return' => $transactions->where('type', 'Wholesale Return')->count(),
        ];

        return view('pages.representativesMedical.partials.show', compact(
            'representative',
            'transactions',
            'date',
            'areas'
        ));
    }




    public function edit($representativeId)
    {
        $representative = Representative::with(['warehouse', 'areas'])->find($representativeId);
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('pages.representativesMedical.partials.edit', compact('representative', 'warehouses', 'areas'));
    }

    public function update(UpdateRepresentativeRequest $request,  $representativeId)
    {
        $data = $request->validated();

        $this->service->updateRepresentativeMedical($representativeId, $data);
        return redirect()->route('representativesMedical.index')
            ->with('success', __('Representative Medical updated successfully.'));
    }

    public function destroy(Representative $representative)
    {
        $this->service->deleteRepresentativeMedical($representative);
        return redirect()->back()
            ->with('success', __('Representative deleted successfully.'));
    }
}
