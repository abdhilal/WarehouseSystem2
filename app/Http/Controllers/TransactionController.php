<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Warehouse;
use App\Models\Factory;
use App\Models\Pharmacy;
use App\Models\Representative;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = $this->service->getTransactions($request);
        return view('pages.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $factories = Factory::orderBy('name')->get();
        $pharmacies = Pharmacy::orderBy('name')->get();
        $representatives = Representative::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $types = ['Wholesale Sale', 'Wholesale Return', 'Gift'];
        return view('pages.transactions.partials.create', compact('warehouses','factories','pharmacies','representatives','products','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->service->createTransaction($request->validated());
        return redirect()->route('transactions.index')
            ->with('success', __('Transaction created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['warehouse','factory','pharmacy','representative','product']);
        return view('pages.transactions.partials.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $factories = Factory::orderBy('name')->get();
        $pharmacies = Pharmacy::orderBy('name')->get();
        $representatives = Representative::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $types = ['Wholesale Sale', 'Wholesale Return', 'Gift'];
        return view('pages.transactions.partials.edit', compact('transaction','warehouses','factories','pharmacies','representatives','products','types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $this->service->updateTransaction($transaction, $request->validated());
        return redirect()->route('transactions.index')
            ->with('success', __('Transaction updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->service->deleteTransaction($transaction);
        return redirect()->back()
            ->with('success', __('Transaction deleted successfully.'));
    }
}
