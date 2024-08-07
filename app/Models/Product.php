<?php

namespace App\Models;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuid;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'model'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
        public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
