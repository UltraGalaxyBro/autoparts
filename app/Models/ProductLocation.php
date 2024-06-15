<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProductLocation extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'product_id',
        'supplier_id',
        'supplier_code',
        'headquarter_id',
        'indoor_location',
        'quantity',
        'stock_alert_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

}
