<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'table_no' => $this->table_no,
            'order_date' => $this->order_date,
            'order_time' => $this->order_time,
            'status' => $this->status,
            'total' => $this->total,
            'order_detail' => $this->orderDetail->map(function ($detail) {
                return [
                    // 'order_id' => $detail->order_id,
                    'item_id' => $detail->item_id,
                    'price' => $detail->price,
                    'item' => [
                        'name' => $detail->item->name,
                    ],
                ];
            }),
            'waiterss' => $this->waiterss->name,
            'cashier' => $this->cashier ? $this->cashier->name : null,
        ];
    }
}
