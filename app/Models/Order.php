<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'table_no',
        'order_date',
        'order_time',
        'status',
        'total',
        'waiterss_id',
        'cashier_id'
    ];

    public function sumOrderPrice()
    {
        $orderDetail = OrderDetail::where('order_id', $this->id)->pluck('price');

        $sum = collect($orderDetail)->sum();
        return $sum;
    }

    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function waiterss(): BelongsTo
    {
        return $this->belongsTo(User::class, 'waiterss_id', 'id');
    }
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }
}
