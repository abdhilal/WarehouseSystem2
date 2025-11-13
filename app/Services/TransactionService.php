<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionService
{
    public function getTransactions(Request $request = null)
    {
        $query = Transaction::query()->with(['warehouse', 'factory', 'pharmacy', 'representative', 'product']);
        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }
        return $query->latest()->paginate(20);
    }

    public function applySearch($query, string $term)
    {
        $query->where(function ($q) use ($term) {
            $q->where('type', 'LIKE', "%{$term}%")
              ->orWhereHas('product', function ($p) use ($term) {
                  $p->where('name', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('pharmacy', function ($ph) use ($term) {
                  $ph->where('name', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('representative', function ($r) use ($term) {
                  $r->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('email', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('factory', function ($f) use ($term) {
                  $f->where('name', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('warehouse', function ($w) use ($term) {
                  $w->where('name', 'LIKE', "%{$term}%");
              });
        });
    }

    public function createTransaction(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function updateTransaction(Transaction $transaction, array $data): Transaction
    {
        $transaction->update($data);
        return $transaction;
    }

    public function deleteTransaction(Transaction $transaction): void
    {
        $transaction->delete();
    }
}