<?php


namespace App\Repositories\Category;


use App\Models\Category;

class CategoryRepository implements ICategoryRepository
{
    private $model;
    public function __construct(Category $category)
    {
        $this->model = $category;

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
        $category=$this->model->findOrFail($id);
        $category->name=$attributes['name'];
        return $category->save();
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
