<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'name',
        'shard_code'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
