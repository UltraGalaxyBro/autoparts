<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Cart extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
