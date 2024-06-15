<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'telephone',
        'celphone',
        'whatsapp',
        'email',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
