<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\File;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\AreaService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;

class AreaController extends Controller
{
    protected $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $areas = $this->areaService->getAreasForUser($request);



        return view('pages.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $warehouses = Warehouse::orderBy('name')->get();
    //     return view('pages.areas.partials.create', compact('warehouses'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreAreaRequest $request)
    // {
    //     $area = $this->areaService->createArea($request->validated());
    //     return redirect()->route('areas.index')
    //         ->with('success', __('Area created successfully.'));
    // }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        $area->load([
            'warehouse',
            'pharmacies.warehouse',
            'pharmacies.representative',
            'representatives.warehouse',
            'transactions.product',
            'transactions.pharmacy',
            'transactions.representative',
            'transactions.file',
        ])->where('warehouse_id', Auth::user()->warehouse_id);

        $files = File::where('warehouse_id', auth()->user()->warehouse_id)->orderBy('month_year', 'desc')->get();




        $summary = [];

        foreach ($files as $file) {
            // جلب جميع المعاملات للملف الحالي والمناطق المحددة
            $filtered = Transaction::where('file_id', $file->id)
                ->where('area_id', $area->id) // هنا نحدد المناطق
                ->get();

            $summary[$file->id] = [
                'value_income'     => (float) $filtered->sum('value_income'),
                'value_output'     => (float) $filtered->sum('value_output'),
                'date'             => $file->month_year,
            ];
        }

        $stats = [
            'transactions_count' => $area->transactions()->where('file_id', getDefaultFileId())->count(),
            'value_income' => (float) $area->transactions()->where('file_id', getDefaultFileId())->sum('value_income'),
            'value_output' => (float) $area->transactions()->where('file_id', getDefaultFileId())->sum('value_output'),
            'value_gift' => (float) $area->transactions()->where('file_id', getDefaultFileId())->sum('value_gift'),
            'quantity_product' => (int) $area->transactions()->where('file_id', getDefaultFileId())->sum('quantity_product'),
            'quantity_gift' => (int) $area->transactions()->where('file_id', getDefaultFileId())->sum('quantity_gift'),
            'sales_count' => $area->transactions()->where('file_id', getDefaultFileId())->where('type', 'Wholesale Sale')->count(),
            'returns_count' => $area->transactions()->where('file_id', getDefaultFileId())->where('type', 'Wholesale Return')->count(),
            'summary' => $summary,

        ];


        return view('pages.areas.partials.show', compact('area', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Area $area)
    // {
    //     $warehouses = Warehouse::orderBy('name')->get();
    //     return view('pages.areas.partials.edit', compact('area', 'warehouses'));
    // }

    /**
 * Update the specified resource in storage.
 */
    // public function update(UpdateAreaRequest $request, Area $area)
    // {
    //     $this->areaService->updateArea($area, $request->validated());
    //     return redirect()->route('areas.index')
    //         ->with('success', __('Area updated successfully.'));
    // }

    /**
 * Remove the specified resource from storage.
 */
    // public function destroy(Area $area)
    // {
    //     $this->areaService->deleteArea($area);
    //     return redirect()->back()
    //         ->with('success', __('Area deleted successfully.'));
    // }
}
