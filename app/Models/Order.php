<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['table_number','invoice_number', 'total', 'cart_data'];

    protected $casts = [
        'cart_data' => 'array', // automatically convert JSON to array
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
