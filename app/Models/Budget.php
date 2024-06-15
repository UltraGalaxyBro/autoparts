<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', //LEMBRANDO QUE ESTE, APESAR DE SER O USER_ID, REPRESENTA NA MERDADE AQUELE USUÁRIO QUE POSSUI A AUTORIZAÇÃO PARA REALIZAR COTAÇÕES
        'customer_id',
        'validity',
        'payment_method',
        'payment_details_bol',
        'payment_details_credit',
        'freight_type',
        'freight_price',
        'discount',
        'expenses',
        'total_price',
        'chassis_number',
        'observation',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    }
}
