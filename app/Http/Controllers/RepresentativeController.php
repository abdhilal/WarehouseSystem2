<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Representative;
use Illuminate\Support\Facades\Hash;
use App\Services\RepresentativeService;
use App\Http\Requests\StoreRepresentativeRequest;
use App\Http\Requests\UpdateRepresentativeRequest;

class RepresentativeController extends Controller
{
    protected $service;

    public function __construct(RepresentativeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $representatives = $this->service->getRepresentatives($request);
        return view('pages.representatives.index', compact('representatives'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('pages.representatives.partials.create', compact('warehouses', 'areas'));
    }

    public function store(StoreRepresentativeRequest $request)
    {
        $data = $request->validated();
        $user = $this->service->createRepresentative($data);
        return redirect()->route('representatives.index')
            ->with('success', __('Representative created successfully.'));
    }



    public function show(Representative $representative)
    {
        $representative->load(['warehouse', 'pharmacies.area', 'pharmacies.warehouse'])->whereHas('transactions', function ($q) {
            $q->where('file_id', getDefaultFileId());
        });

        $transactions = Transaction::where('file_id', getDefaultFileId())->with(['product', 'pharmacy', 'file'])->where('representative_id', $representative->id)->get();
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

        $pharmacyTotals = $transactions->groupBy('pharmacy_id')->map(function ($ts) {
            return [
                'income' => (float) $ts->sum('value_income'),
                'output' => (float) $ts->sum('value_output'),
            ];
        });

        return view('pages.representatives.partials.show', compact('representative', 'transactions', 'date', 'areas', 'pharmacyTotals'));

    }
    public function edit(Representative $representative)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('pages.representatives.partials.edit', compact('representative', 'warehouses', 'areas'));
    }

    public function update(UpdateRepresentativeRequest $request, Representative $representative)
    {
        $data = $request->validated();

        $this->service->updateRepresentative($representative, $data);
        return redirect()->route('representatives.index')
            ->with('success', __('Representative updated successfully.'));
    }

    public function destroy(Representative $representative)
    {
        $this->service->deleteRepresentative($representative);
        return redirect()->back()
            ->with('success', __('Representative deleted successfully.'));
    }
}
