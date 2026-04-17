<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // The service filters what they can see
    }

    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id || $user->tipo === 'LOJISTA';
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create an order
    }
}
