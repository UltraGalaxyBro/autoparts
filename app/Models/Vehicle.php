<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Vehicle extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'type',
        'name',
        'license_plate'
    ];

    public function races()
    {
        return $this->hasMany(Race::class);
    }
}
