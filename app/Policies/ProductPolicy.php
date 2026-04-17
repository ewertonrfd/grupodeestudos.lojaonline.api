<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function create(User $user): bool
    {
        return $user->tipo === 'LOJISTA';
    }

    public function update(User $user, Product $product): bool
    {
        return $user->tipo === 'LOJISTA';
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->tipo === 'LOJISTA';
    }
}
