<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProductWithdrawal extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'product_id',
        'headquarter_id',
        'user_id',
        'indoor_location',
        'quantity',
        'required_by',
        'withdrawal_status',
        'completed_by',
        'product_sale_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function productSale()
    {
        return $this->belongsTo(ProductSale::class);
    }
}
