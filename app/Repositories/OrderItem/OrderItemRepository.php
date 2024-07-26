<?php


namespace App\Repositories\OrderItem;


use App\Models\OrderItem;

class OrderItemRepository implements IOrderItemRepository
{
    private $model;
    public function __construct(OrderItem $orderItem)
    {
        $this->model = $orderItem;

    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->with('order')->with('product')->find($id);
    }
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $orderItem=$this->model->findOrFail($id);
        $orderItem->remark=$attributes['remark'];
        $orderItem->product_id=$attributes['product_id'];
        $orderItem->price=$attributes['price'];
        $orderItem->status=$attributes['status'];
        $orderItem->quantity=$attributes['quantity'];
        $orderItem->order_id=$attributes['order_id'];
        return $orderItem->save();
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
