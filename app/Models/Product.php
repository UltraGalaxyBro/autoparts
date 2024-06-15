<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'name',
        'category_id',
        'automaker_id',
        'original_code',
        'brand_id',
        'brand_code',
        'cross_code',
        'condition',
        'measure',
        'cost',
        'price',
        'ncm',
        'visible',
        'sale',
        'sale_price',
        'sale_period_until',
        'aplication',
        'description',
        'height',
        'width',
        'lenght',
        'weight',
        'freight',
        'packaging',
        'keywords',
        'inside_code',
        'main_img',
        'extra_img',
        'extra_img2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function automaker()
    {
        return $this->belongsTo(Automaker::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productLocations()
    {
        return $this->hasMany(ProductLocation::class);
    }

    public function getTotalStockAttribute()
    {
        return $this->productLocations->sum('quantity');
    }

    public function getIndoorLocationAttribute()
    {
        return $this->productLocations->pluck('indoor_location')->implode(', ');
    }

    public function productWithdrawals()
    {
        return $this->hasMany(ProductWithdrawal::class);
    }

    public function productSales()
    {
        return $this->hasMany(ProductSale::class);
    }

    public function getTotalQuantitySaleAttribute()
    {
        return $this->productSales->sum('quantity_sold');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
