<?php


namespace App\Repositories\Order;


use App\Models\Order;

class OrderRepository implements IOrderRepository
{
    private $model;
    public function __construct(Order $order)
    {
        $this->model = $order;

    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->with('customer')->find($id);
    }
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $order=$this->model->findOrFail($id);
        $order->description=$attributes['description'];
        $order->customer_id=$attributes['customer_id'];
        return $order->save();
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
