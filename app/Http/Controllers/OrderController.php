<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ShowOrderResource;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::all();
        return OrderResource::collection($order);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        // return $order->loadMissing('orderDetail:order_id,price,item_id', 'orderDetail.item:id,name');
        return new ShowOrderResource($order);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:100',
            'table_no' => 'required|max:5',
            'items' => 'required|array',
        ]);

        // menggunakan db transaction
        // disebabkan memerlukan input bersamaan antara order dan dorder detail, jadi untuk mencegah error
        // data akan dihapus apabila salah satu antara db order / db order_detail tidak terinput
        try {
            DB::beginTransaction();

            $data = $request->only('customer_name', 'table_no');
            $data['order_date'] = date('Y-m-d');
            $data['order_time'] = date('H:i:s');
            $data['status'] = 'ordered';
            $data['total'] = 0;
            $data['waiterss_id'] = auth()->user()->id;
            $data['items'] = $request->items;

            $order = Order::create($data);

            collect($data['items'])->map(function ($item) use ($order) {
                $footDrink = Item::where('id', $item)->first();
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $item,
                    'price' => $footDrink->price,
                ]);
            });

            // edit total order
            $order->total = $order->sumOrderPrice();
            $order->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response($th);
        }

        return response(['data' => $order]);
        // return response($data);
    }

    public function setAsDone($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'ordered') {
            return response('you cannot set to done because the status is not ordered', 403);
        }

        $order->status = 'done';
        $order->save();

        return new OrderResource($order);
    }

    public function payment($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'done') {
            return response('you cannot set to done because the status is not done', 403);
        }

        $order->status = 'paid';
        $order->save();

        return new OrderResource($order);
    }
}
