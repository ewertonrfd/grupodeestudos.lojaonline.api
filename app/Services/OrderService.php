<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Exception;

class OrderService
{
    protected $orderRepository;
    protected $productRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function getAllOrders($user)
    {
        if ($user->tipo === 'LOJISTA') {
            return $this->orderRepository->getAll();
        }
        return $this->orderRepository->getByUserId($user->id);
    }

    public function getOrderById($id, $user)
    {
        $order = $this->orderRepository->find($id);

        if ($user->tipo !== 'LOJISTA' && $order->user_id !== $user->id) {
            throw new Exception("Unauthorized access to this order.", 403);
        }

        return $order;
    }

    public function createOrder($userId, array $itemsData)
    {
        $valorTotal = 0;
        $items = [];

        foreach ($itemsData as $item) {
            $product = $this->productRepository->find($item['product_id']);

            if ($product->estoque < $item['quantidade']) {
                throw new Exception("Estoque insuficiente para o produto: {$product->nome}");
            }

            // Deduct stock
            $this->productRepository->update($product->id, [
                'estoque' => $product->estoque - $item['quantidade']
            ]);

            $precoUnitario = $product->preco;
            $valorTotal += $precoUnitario * $item['quantidade'];

            $items[] = [
                'product_id' => $product->id,
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $precoUnitario,
            ];
        }

        return $this->orderRepository->create([
            'user_id' => $userId,
            'valor_total' => $valorTotal,
            'items' => $items,
        ]);
    }
}
