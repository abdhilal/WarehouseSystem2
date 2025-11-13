<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Http\Requests\StoreFactoryRequest;
use App\Http\Requests\UpdateFactoryRequest;
use Illuminate\Http\Request;
use App\Services\FactoryService;

class FactoryController extends Controller
{
    protected $factoryService;

    public function __construct(FactoryService $factoryService)
    {
        $this->factoryService = $factoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $factories = $this->factoryService->getFactories($request);
        return view('pages.factories.index', compact('factories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.factories.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFactoryRequest $request)
    {
        $factory = $this->factoryService->createFactory($request->validated());
        return redirect()->route('factories.index')
            ->with('success', __('Factory created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Factory $factory)
    {
        return view('pages.factories.partials.show', compact('factory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factory $factory)
    {
        return view('pages.factories.partials.edit', compact('factory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFactoryRequest $request, Factory $factory)
    {
        $this->factoryService->updateFactory($factory, $request->validated());
        return redirect()->route('factories.index')
            ->with('success', __('Factory updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factory $factory)
    {
        $this->factoryService->deleteFactory($factory);
        return redirect()->back()
            ->with('success', __('Factory deleted successfully.'));
    }
}
