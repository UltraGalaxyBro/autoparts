<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class RaceStop extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'race_id',
        'name',
        'latitude',
        'longitude',
        'distance'
    ];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
