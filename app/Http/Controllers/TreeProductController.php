<?php

namespace App\Http\Controllers;

use App\Models\TreeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\TreeProductsExport;
use App\Imports\TreeProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreTreeProductRequest;
use App\Http\Requests\UpdateTreeProductRequest;



class TreeProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = TreeProduct::query()
            ->where('warehouse_id', $user->warehouse_id);

        $date = $request->filled('date') ? $request->string('date')->toString() : null;
        $search = $request->filled('search') ? $request->string('search')->toString() : null;
        if ($date) {
            $query->whereDate('month_year', $date);
        }
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $treeProducts = $query->orderBy('month_year', 'desc')->paginate(20);

        $dates = TreeProduct::query()
            ->where('warehouse_id', $user->warehouse_id)
            ->select('month_year')
            ->distinct()
            ->orderBy('month_year', 'desc')
            ->pluck('month_year');

        return view('pages.treeProducts.index', compact('treeProducts', 'dates', 'date', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function upload()
    {
        return view('pages.treeProducts.partials.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        DB::beginTransaction();
        $file = $request->file('file');
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';


        Excel::import(new TreeProductsImport(auth()->user()->warehouse_id, $year, $month, $month_year), $file);
        DB::commit();
        return redirect()->route('TreeProducts.index')->with('success', __('Tree Products uploaded successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(TreeProduct $treeProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreeProduct $treeProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreeProductRequest $request, TreeProduct $treeProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($date)
    {
        $user = auth()->user();
        TreeProduct::where('warehouse_id', $user->warehouse_id)
            ->whereDate('month_year', $date)
            ->delete();
        return redirect()->route('TreeProducts.index')->with('success', __('Tree Product deleted successfully'));
    }

    public function export()
    {
        $filename = 'TREE-PRODUCTS-STANDER-' . now()->format('Y-m-d');
        return Excel::download(new TreeProductsExport, $filename . '.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function Management()
    {
        $user = auth()->user();
        $dates = TreeProduct::query()
            ->where('warehouse_id', $user->warehouse_id)
            ->select('month_year')
            ->distinct()
            ->orderBy('month_year', 'desc')
            ->pluck('month_year');
        return view('pages.treeProducts.partials.management', compact('dates'));
    }
}
