<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(BannerProduct::class, 'banner_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function productList()
    {
        return $this->hasManyThrough(
            Product::class,
            BannerProduct::class,
            'banner_id', // Kunci asing di tabel BannerProduct yang menghubungkan ke Banner
            'id', // Kunci primer di tabel Banner
            'id', // Kunci asing di tabel BannerProduct yang menghubungkan ke Product
            'product_id' // Kunci primer di tabel Product
        );
    }
}
