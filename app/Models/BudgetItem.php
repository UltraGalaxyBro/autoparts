<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'description',
        'supplier_id',
        'supplier_reference',
        'cost',
        'deadline',
        'price',
        'quantity'
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
