<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerLevel extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'name',
        'discount',
        'description',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
