<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{File, Transaction, Representative, Area};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();
        $warehouseId = $user->warehouse_id;

        if ($request->has('file_id')) {
            $activeFileId = $request->filled('file_id') ? $request->integer('file_id') : null;
        } else {
            $activeFileId = getDefaultFileId();
        }
        $type = $request->filled('type') ? $request->string('type')->toString() : null;

        $fileKey = is_null($activeFileId) ? 'all' : $activeFileId;
        $cacheKey = "dashboard_v5_stats_sort_output_{$warehouseId}_{$fileKey}_{$type}";
        $data = Cache::remember($cacheKey, 300, function () use ($warehouseId, $activeFileId, $type) {
            $query = Transaction::query()
                ->where('warehouse_id', $warehouseId)
                ->when(!is_null($activeFileId), fn($q) => $q->where('file_id', $activeFileId))
                ->when($type, fn($q) => $q->where('type', $type))
                ->with(['area', 'pharmacy', 'product', 'representative']);

            $transactions = $query->get();
            $summary = [
                'transactions' => $transactions->count(),
                'value_income' => (float) $transactions->sum('value_income'),
                'value_output' => (float) $transactions->sum('value_output'),
                'net_profit'   => (float) ($transactions->sum('value_income') - $transactions->sum('value_output')),
                'quantity_product' => (int) $transactions->sum('quantity_product'),
                'quantity_gift'    => (int) $transactions->sum('quantity_gift'),
                'value_gift'       => (float) $transactions->sum('value_gift'),
                'warehouses' => 1,
                'areas' => Area::where('warehouse_id', $warehouseId)->count(),
                'pharmacies' => \App\Models\Pharmacy::where('warehouse_id', $warehouseId)->count(),
                'representatives_sales' => Representative::where('warehouse_id', $warehouseId)->where('type', 'sales')->count(),
                'representatives_medical' => Representative::where('warehouse_id', $warehouseId)->where('type', 'medical')->count(),
                'products' => \App\Models\Product::where('warehouse_id', $warehouseId)->count(),
            ];

            $by_type = $transactions->groupBy('type')
                ->map(fn($g) => [
                    'count' => $g->count(),
                    'income' => (float) $g->sum('value_income'),
                    'output' => (float) $g->sum('value_output'),
                ])->toArray();

            $grouped_by_product = $transactions->groupBy(fn($t) => optional($t->product)->name ?? 'غير محدد')
                ->map(function ($g) {
                    $sold = $g->filter(fn($t) => $t->type === 'Wholesale Sale');
                    return [
                        'count'  => $g->count(),
                        'value_income' => (float) $g->sum('value_income'),
                        'value_output' => (float) $g->sum('value_output'),
                        'pieces' => (int) ($sold->sum('quantity_product') + $sold->sum('quantity_gift')),
                    ];
                })->sortByDesc('pieces')->take(10);

            $grouped_by_pharmacy = $transactions->groupBy(fn($t) => optional($t->pharmacy)->name ?? 'غير محدد')
                ->map(fn($g) => [
                    'count'  => $g->count(),
                    'value_income' => (float) $g->sum('value_income'),
                    'value_output' => (float) $g->sum('value_output'),
                ])->sortByDesc('value_output')->take(10);

            $sales_reps_stats = Representative::where('warehouse_id', $warehouseId)
                ->where('type', 'sales')
                ->withCount(['transactions as transactions_count' => fn($q) => $q->when(!is_null($activeFileId), fn($qq) => $qq->where('file_id', $activeFileId))])
                ->withSum(['transactions as income' => fn($q) => $q->when(!is_null($activeFileId), fn($qq) => $qq->where('file_id', $activeFileId))], 'value_income')
                ->withSum(['transactions as output' => fn($q) => $q->when(!is_null($activeFileId), fn($qq) => $qq->where('file_id', $activeFileId))], 'value_output')
                ->get()
                ->map(fn($r) => [
                    'name'   => $r->name,
                    'count'  => (int) ($r->transactions_count ?? 0),
                    'income' => (float) ($r->income ?? 0),
                    'output' => (float) ($r->output ?? 0),
                ])->sortByDesc('output');

            $medical_reps_stats = Representative::where('warehouse_id', $warehouseId)
                ->whereIn('type', ['medical'])
                ->with('areas')
                ->get()
                ->map(function ($rep) use ($activeFileId, $warehouseId) {
                    $areaIds = $rep->areas->pluck('id');
                    $base = Transaction::where('warehouse_id', $warehouseId);
                    $base = $areaIds->isNotEmpty()
                        ? $base->whereIn('area_id', $areaIds)
                        : $base->where('representative_id', $rep->id);
                    $base = !is_null($activeFileId) ? $base->where('file_id', $activeFileId) : $base;
                    return [
                        'name'   => $rep->name,
                        'count'  => (int) $base->count(),
                        'income' => (float) $base->sum('value_income'),
                        'output' => (float) $base->sum('value_output'),
                    ];
                })->sortByDesc('output');


            $areas_summary = Area::where('warehouse_id', $warehouseId)
                ->withCount(['transactions' => function ($q) use ($activeFileId) { $q->when(!is_null($activeFileId), fn($qq) => $qq->where('file_id', $activeFileId)); }])
                ->withSum(['transactions' => function ($q) use ($activeFileId) { $q->when(!is_null($activeFileId), fn($qq) => $qq->where('file_id', $activeFileId)); }], 'value_income')
                ->withSum(['transactions' => function ($q) use ($activeFileId) { $q->when(!is_null($activeFileId), fn($qq) => $qq->where('file_id', $activeFileId)); }], 'value_output')
                ->get()
                ->sortByDesc('transactions_sum_value_output')
                ->values();

            $latest_transactions = Transaction::with(['pharmacy', 'product', 'representative', 'area'])
                ->where('warehouse_id', $warehouseId)
                ->when(!is_null($activeFileId), fn($q) => $q->where('file_id', $activeFileId))
                ->latest()
                ->take(15)
                ->get();

            return [
                'summary' => $summary,
                'by_type' => $by_type,
                'grouped' => [
                    'by_product' => $grouped_by_product,
                    'by_pharmacy' => $grouped_by_pharmacy,
                ],
                'sales_reps_stats' => $sales_reps_stats,
                'medical_reps_stats' => $medical_reps_stats,
                'areas_summary' => $areas_summary,
                'transactions' => $latest_transactions,
            ];
        });

        $files = File::orderByDesc('is_default')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get(['id', 'code', 'month', 'year', 'is_default']);

        return view('pages.welcome', array_merge($data, [
            'files' => $files,
            'active_file_id' => $activeFileId,
            'active_type' => $type,
        ]));
    }

    public function stats(Request $request)
    {
        $user = Auth::user();
        $warehouseId = $user->warehouse_id;
        if ($request->has('file_id')) {
            $fileId = $request->filled('file_id') ? $request->integer('file_id') : null;
        } else {
            $fileId = getDefaultFileId();
        }
        $type = $request->string('type')->toString() ?: null;

        $fileKey = is_null($fileId) ? 'all' : $fileId;
        $cacheKey = "live_stats_sort_output_{$warehouseId}_{$fileKey}_{$type}";
        $data = Cache::remember($cacheKey, 60, function () use ($warehouseId, $fileId, $type) {
            $query = Transaction::where('warehouse_id', $warehouseId)
                ->when(!is_null($fileId), fn($q) => $q->where('file_id', $fileId))
                ->when($type, fn($q) => $q->where('type', $type));

            $transactions = $query->get();

            return [
                'summary' => [
                    'transactions' => $transactions->count(),
                    'value_income' => $transactions->sum('value_income'),
                    'value_output' => $transactions->sum('value_output'),
                    'net_profit'   => $transactions->sum('value_income') - $transactions->sum('value_output'),
                ],
                'by_area' => $transactions->groupBy(fn($t) => optional($t->area)->name ?? 'غير محدد')
                    ->map(fn($g) => [
                        'income' => $g->sum('value_income'),
                        'output' => $g->sum('value_output'),
                    ])->sortByDesc('output')->take(12)->toArray(),
            ];
        });

        return response()->json($data);
    }
}
