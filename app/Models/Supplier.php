<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//AUDITORIA
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Supplier extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'name'
    ];

    public function productLocations()
    {
        return $this->hasMany(ProductLocation::class);
    }

    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    }

    public function supplierContacts()
    {
        return $this->hasMany(SupplierContact::class);
    }
}
