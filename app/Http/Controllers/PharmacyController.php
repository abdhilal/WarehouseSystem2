<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\Warehouse;
use App\Models\Area;
use App\Models\Representative;
use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\UpdatePharmacyRequest;
use Illuminate\Http\Request;
use App\Services\PharmacyService;

class PharmacyController extends Controller
{
    protected $service;

    public function __construct(PharmacyService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pharmacies = $this->service->getPharmacies($request);
        return view('pages.pharmacies.index', compact('pharmacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        $representatives = Representative::orderBy('name')->get();
        return view('pages.pharmacies.partials.create', compact('warehouses', 'areas', 'representatives'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePharmacyRequest $request)
    {
        $pharmacy = $this->service->createPharmacy($request->validated());
        return redirect()->route('pharmacies.index')
            ->with('success', __('Pharmacy created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        $warehouseId = auth()->user()->warehouse_id;
        $fileId = getDefaultFileId();

        // تحميل العلاقات الأساسية
        $pharmacy->load(['warehouse', 'area', 'representative']);

        // جلب العمليات paginated + علاقاتها
        $transactions = $pharmacy->transactions()
            ->with(['product', 'representative', 'file'])
            ->where('warehouse_id', $warehouseId)
            ->where('file_id', $fileId)
            ->latest()
            ->paginate(10);


        // استعلام أساسي واحد بدل 4 استعلامات مكررة
        $baseQuery = $pharmacy->transactions()
            ->where('warehouse_id', $warehouseId)
            ->where('file_id', $fileId);

        // نجمع الإحصائيات بكفاءة
        $stats = [
            'transactions_count' => (int) $baseQuery->count(),
            'value_income'       => (float) $baseQuery->sum('value_income'),
            'value_output'       => (float) $baseQuery->sum('value_output'),
            'value_gift'         => (float) $baseQuery->sum('value_gift'),
            'quantity_product'   => (int) $baseQuery->sum('quantity_product'),
            'quantity_gift'      => (int) $baseQuery->sum('quantity_gift'),

            'sales_count'   => (int) $baseQuery->where('type', 'Wholesale Sale')->count(),
            'returns_count' => (int) $baseQuery->where('type', 'Wholesale Return')->count(),
        ];

        return view('pages.pharmacies.partials.show', compact('pharmacy', 'transactions', 'stats'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $pharmacy)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        $representatives = Representative::orderBy('name')->get();
        return view('pages.pharmacies.partials.edit', compact('pharmacy', 'warehouses', 'areas', 'representatives'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacyRequest $request, Pharmacy $pharmacy)
    {
        $this->service->updatePharmacy($pharmacy, $request->validated());
        return redirect()->route('pharmacies.index')
            ->with('success', __('Pharmacy updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $this->service->deletePharmacy($pharmacy);
        return redirect()->back()
            ->with('success', __('Pharmacy deleted successfully.'));
    }
}
