<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\API\Order\Resources\OrderResource;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    private OrderRepositoryInterface $orderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        return $this->returnResponseSuccess(OrderResource::collection($this->orderRepository->getAll($request->user()->id)), 'List of user orders!');
    }

    public function cancel(int $id)
    {
        $order = $this->orderRepository->findById(Order::class, $id);
        if (!$order) {
            return $this->returnNotFoundError();
        }
        try {
            $order->update(['status' => Order::STATUS['cancelled']]);
            return $this->returnResponseSuccess('', 'Order cancelled');

        }catch (\Exception $e) {
            return $this->returnResponseError([], 'Something went wrong, please try again!', 424);
        }
    }

    /**
     * @param OrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeOrder(OrderRequest $request)
    {
        $user = $request->user();
        $validatedData = $request->validated();
        foreach ($validatedData['orders'] as $order) {
            $splitOrder = [];
            $productVariant = ProductVariant::find($order['product_variant_id']);
            if (!$productVariant) {
                return $this->returnNotFoundError();
            }
            $userProductData = [
                'user_id' => $user->id,
                'product_variant_id' => $order['product_variant_id'],
                'address' => $validatedData['address']
            ];
            $orderData = $userProductData + ['quantity' => $order['quantity']];
            if ($productVariant->in_stock > 0) {
                if ($order['quantity'] <= $productVariant->in_stock) {
                    $orderData += [
                        'status' => Order::STATUS['ordered'],
                        'items_sent' => $order['quantity'],
                        'sum' => $order['quantity'] * $productVariant->price
                    ];
                    $productVariant->update(
                        [
                            'in_stock' => $productVariant->in_stock - $order['quantity']
                        ]
                    );
                }else{
                    $orderData += [
                        'status' => Order::STATUS['ordered'],
                        'items_sent' => $productVariant->in_stock,
                        'sum' => $productVariant->in_stock * $productVariant->price
                    ];
                    //waiting for stock
                    $splitOrder = [
                        'status' => Order::STATUS['waiting'],
                        'items_sent' => 0,
                        'quantity' => $order['quantity'] - $productVariant->in_stock,
                        'sum' => ($order['quantity'] - $productVariant->in_stock) * $productVariant->price
                    ];
                    $productVariant->update(
                        [
                            'in_stock' => 0
                        ]);
                }
            }else{
                $orderData += [
                    'status' => Order::STATUS['waiting'],
                    'items_sent' => 0,
                    'sum' => $order['quantity'] * $productVariant->price
                ];
            }

            $mOrder = $this->orderRepository->makeOrder($orderData);

            if ($splitOrder) {
                $splitOrder += $userProductData + [
                    'related_order_id' => $mOrder->id
                ];
                $this->orderRepository->makeOrder($splitOrder);
            }
        }

        return $this->returnResponseSuccess([], 'Success');
    }
}
