<?php


namespace App\Repositories\Customer;


use App\Models\Customer;

class CustomerRepository implements ICustomerRepository
{
    private $model;
    public function __construct(Customer $customer)
    {
        $this->model = $customer;

    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->with('orders')->find($id);
    }
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $customer=$this->model->findOrFail($id);
        $customer->name=$attributes['name'];
        $customer->email=$attributes['email'];
        $customer->phone=$attributes['phone'];
        $customer->gender=$attributes['gender'];
        return $customer->save();
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
