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
        $payload = [
            'warehouse_id'      => $data['warehouse_id'] ?? null,
            'factory_id'        => $data['factory_id'] ?? null,
            'pharmacy_id'       => $data['pharmacy_id'] ?? null,
            'representative_id' => $data['representative_id'] ?? null,
            'product_id'        => $data['product_id'] ?? null,
            'type'              => $data['type'] ?? null,
            'quantity_product'  => $data['quantity'] ?? 0,
            'quantity_gift'     => $data['quantity_gift'] ?? 0,
            'value_income'      => $data['value'] ?? 0,
            'value_output'      => $data['value_output'] ?? 0,
            'value_gift'        => $data['gift_value'] ?? 0,
        ];

        return Transaction::create($payload);
    }

    public function updateTransaction(Transaction $transaction, array $data): Transaction
    {
        $payload = [
            'warehouse_id'      => $data['warehouse_id'] ?? $transaction->warehouse_id,
            'factory_id'        => $data['factory_id'] ?? $transaction->factory_id,
            'pharmacy_id'       => $data['pharmacy_id'] ?? $transaction->pharmacy_id,
            'representative_id' => $data['representative_id'] ?? $transaction->representative_id,
            'product_id'        => $data['product_id'] ?? $transaction->product_id,
            'type'              => $data['type'] ?? $transaction->type,
            'quantity_product'  => $data['quantity'] ?? $transaction->quantity_product,
            'quantity_gift'     => $data['quantity_gift'] ?? $transaction->quantity_gift,
            'value_income'      => $data['value'] ?? $transaction->value_income,
            'value_output'      => $data['value_output'] ?? $transaction->value_output,
            'value_gift'        => $data['gift_value'] ?? $transaction->value_gift,
        ];

        $transaction->update($payload);
        return $transaction;
    }

    public function deleteTransaction(Transaction $transaction): void
    {
        $transaction->delete();
    }
}