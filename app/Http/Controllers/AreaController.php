<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Warehouse;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use Illuminate\Http\Request;
use App\Services\AreaService;

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
    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        return view('pages.areas.partials.create', compact('warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest $request)
    {
        $area = $this->areaService->createArea($request->validated());
        return redirect()->route('areas.index')
            ->with('success', __('Area created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        $area->load('warehouse');
        return view('pages.areas.partials.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        return view('pages.areas.partials.edit', compact('area', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, Area $area)
    {
        $this->areaService->updateArea($area, $request->validated());
        return redirect()->route('areas.index')
            ->with('success', __('Area updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $this->areaService->deleteArea($area);
        return redirect()->back()
            ->with('success', __('Area deleted successfully.'));
    }
}
