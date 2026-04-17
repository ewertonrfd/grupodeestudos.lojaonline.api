<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function getAll()
    {
        return Order::with('items.product')->get();
    }

    public function getByUserId($userId)
    {
        return Order::with('items.product')->where('user_id', $userId)->get();
    }

    public function find($id)
    {
        return Order::with('items.product')->findOrFail($id);
    }

    public function create(array $data)
    {
        $order = Order::create([
            'user_id' => $data['user_id'],
            'valor_total' => $data['valor_total'],
            'status' => 'pending',
        ]);

        foreach ($data['items'] as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['preco_unitario'],
            ]);
        }

        return $order->load('items.product');
    }
}
