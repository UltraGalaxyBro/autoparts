<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Headquarter extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'visible',
        'name',
        'zip_code',
        'state',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',
        'telephone',
        'whatsapp',
        'map',
        'coordinates',
        'main_img'
    ];

    public function productLocations()
    {
        return $this->hasMany(ProductLocation::class);
    }

    public function productWithdrawals()
    {
        return $this->hasMany(ProductWithdrawal::class);
    }

    public function races()
    {
        return $this->hasMany(Race::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
