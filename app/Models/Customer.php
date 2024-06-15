<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'user_id',
        'customer_level_id',
        'telephone',
        'celphone',
        'whatsapp',
        'type_buyer',
        'cpf',
        'company',
        'cnpj',
        'ie',
        'purchases',
        'last_purchase_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customerLevel()
    {
        return $this->belongsTo(CustomerLevel::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
