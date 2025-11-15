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
        return view('pages.representativesMedical.index', compact('representativesMedical'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('pages.representativesMedical.partials.create', compact('warehouses', 'areas'));
    }

    public function store(StoreRepresentativeRequest $request)
    {
        $data = $request->validated();
        $user = $this->service->createRepresentativeMedical($data);
        return redirect()->route('representativesMedical.index')
            ->with('success', __('Representative Medical created successfully.'));
    }



    public function show($representativeId)
    {

        $representative = Representative::with(['warehouse', 'areas'])->find($representativeId);
        return $representative;
        $transactions = Transaction::with(['product', 'pharmacy', 'file'])->where('representative_id', $representative->id)->get();
        $areas = Area::with('warehouse', 'transactions')
            ->whereHas('representatives', function ($query) use ($representative) {
                $query->where('representative_id', $representative->id);
            })
            ->withSum('transactions', 'value_income')
            ->withSum('transactions', 'value_output')
            ->get();

        $date = [
            'value_income' => $transactions->sum('value_income'),
            'value_output' => $transactions->sum('value_output'),
            'value_gift' => $transactions->sum('value_gift'),
            'quantity_gift' => $transactions->sum('quantity_gift'),
            'quantity_product' => $transactions->sum('quantity_product'),
            'Wholesale_Sale' => $transactions->where('type', 'Wholesale Sale')->count(),
            'Wholesale_Return' => $transactions->where('type', 'Wholesale Return')->count(),
        ];

        // return $date;
        return view('pages.representativesMedical.partials.show', compact('representative', 'transactions', 'date', 'areas'));
    }

    public function edit(Representative $representative)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('pages.representativesMedical.partials.edit', compact('representative', 'warehouses', 'areas'));
    }

    public function update(UpdateRepresentativeRequest $request, Representative $representative)
    {
        $data = $request->validated();

        $this->service->updateRepresentativeMedical($representative, $data);
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
