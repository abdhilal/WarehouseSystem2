<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class RepresentativeService
{
    public function getRepresentatives(Request $request = null)
    {
        $query = User::query()->with(['warehouse', 'area'])
            ->role('Representative');

        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        return $query->latest()->paginate(20);
    }

    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    public function createRepresentative(array $data): User
    {
        return User::create($data);
    }

    public function updateRepresentative(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function deleteRepresentative(User $user): ?bool
    {
        return $user->delete();
    }
}