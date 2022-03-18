<?php


namespace App\Repositories\SolarPanel;

use App\Models\SolarPanel;

class SolarPanelRepository implements ISolarPanelRepository
{
    private $model;
    public function __construct(SolarPanel $solarPanel)
    {
        $this->model = $solarPanel;

    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->with('category')->find($id);
    }
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $solarPanel=$this->model->findOrFail($id);
        $solarPanel->model=$attributes['model'];
        $solarPanel->price=$attributes['price'];
        $solarPanel->description=$attributes['description'];
        $solarPanel->category_id=$attributes['category_id'];
        $solarPanel->manufactured_date=$attributes['manufactured_date'];
        return $solarPanel->save();
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
