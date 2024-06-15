<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProductSale extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'product_id',
        'headquarter_id',
        'sale_mode',
        'user_id',
        'quantity_sold',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productWithdrawals()
    {
        return $this->hasMany(ProductWithdrawal::class);
    }
}
