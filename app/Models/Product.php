<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'active_products';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function variants()
    {
        return $this->hasMany(Variant::class, 'master_product_id');
    }

    public function toppings()
    {
        return $this->hasMany(Topping::class, 'master_product_id');
    }
}
