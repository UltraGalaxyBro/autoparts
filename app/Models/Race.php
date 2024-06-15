<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Race extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'user_id',
        'headquarter_id',
        'vehicle_id',
        'arrival_time',
        'observation',
        'status',
        'total_distance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function raceStops()
    {
        return $this->hasMany(RaceStop::class);
    }
}
