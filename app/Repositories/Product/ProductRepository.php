<?php


namespace App\Repositories\Product;


use App\Models\Product;

class ProductRepository implements IProductRepository
{
    private $model;
    public function __construct(Product $Product)
    {
        $this->model = $Product;

    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->with('solar_panels')->find($id);
    }
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $Product=$this->model->findOrFail($id);
        $Product->name=$attributes['name'];
        $Product->description=$attributes['description'];

        return $Product->save();
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
