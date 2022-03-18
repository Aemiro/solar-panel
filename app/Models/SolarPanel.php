<?php

namespace App\Models;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolarPanel extends Model
{
    use HasFactory, HasUuid;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'category_id',
        'description',
        'price',
        'manufactured_date',
        'model'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
