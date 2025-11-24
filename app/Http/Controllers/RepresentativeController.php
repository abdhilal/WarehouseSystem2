<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Representative;
use Illuminate\Support\Facades\Auth;
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
        $fileId = getDefaultFileId();

        // جميع معاملات هذا المندوب على الملف الحالي
        $transactions = Transaction::with(['product', 'pharmacy.area'])
            ->where('representative_id', $representative->id)
            ->where('file_id', $fileId)
            ->get();

        // استخراج ID الصيدليات التي لديها معاملات في هذا الملف
        $pharmacyIds = $transactions->pluck('pharmacy_id')->unique();

        // جلب الصيدليات التابعة لهذا المندوب ومرتبطة بالملف
        $pharmacies = Pharmacy::with(['area'])
            ->whereIn('id', $pharmacyIds)
            ->get();

        // حساب الإجمالي لكل صيدلية
        $pharmacyTotals = $transactions->groupBy('pharmacy_id')->map(function ($ts) {
            return [
                'income' => (float) $ts->sum('value_income'),
                'output' => (float) $ts->sum('value_output'),
            ];
        });

        // حساب إحصائيات عامة
        $date = [
            'value_income' => (float) $transactions->sum('value_income'),
            'value_output' => (float) $transactions->sum('value_output'),
            'value_gift' => (float) $transactions->sum('value_gift'),
            'quantity_gift' => (int) $transactions->sum('quantity_gift'),
            'quantity_product' => (int) $transactions->sum('quantity_product'),
            'Wholesale_Sale' => $transactions->where('type', 'Wholesale Sale')->count(),
            'Wholesale_Return' => $transactions->where('type', 'Wholesale Return')->count(),
        ];

        // المناطق
        $areas = Area::with('warehouse')->where('warehouse_id', Auth::user()->warehouse_id)
            ->whereHas('representatives', fn($q) => $q->where('representative_id', $representative->id))
            ->withSum(['transactions as income_sum' => fn($q) => $q->where('file_id', $fileId)], 'value_income')
            ->withSum(['transactions as output_sum' => fn($q) => $q->where('file_id', $fileId)], 'value_output')
            ->get();

        return view('pages.representatives.partials.show', compact(
            'representative',
            'transactions',
            'pharmacies',
            'pharmacyTotals',
            'areas',
            'date'
        ));
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
