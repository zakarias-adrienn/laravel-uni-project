<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showAll() {
        $orders = Order::where('user_id', Auth::id())->where('status', '!=', 'CART')->get();
        return view('orders', compact('orders'));
    }

    public function showReceived() {
        $orders = Order::where('status', 'RECEIVED')->get();
        return view('received-orders', compact('orders'));
    }

    public function showProcessed() {
        $orders = Order::where('status', 'REJECTED')->orWhere('status','ACCEPTED')->get();
        return view('processed-orders', compact('orders'));
    }

    public function seeOrder($id){
        $order = Order::find($id);
        if($order === null){
            return redirect()->route('main');
        }
        return view('see-received-order', compact('order'));
    }

    public function acceptOrder(Request $request, $orderId){
        $order = Order::find($orderId);
        if($order === null){
            return redirect()->route('main');
        }
        $order->status = 'ACCEPTED';
        $order->processed_on = date_create('now');
        $order->save();
        return redirect()->route('received.orders')->with('order_accepted', true);
    }

    public function rejectOrder(Request $request, $orderId){
        $order = Order::find($orderId);
        if($order === null){
            return redirect()->route('main');
        }
        $order->status = 'REJECTED';
        $order->processed_on = date_create('now');
        $order->save();
        return redirect()->route('received.orders')->with('order_rejected', true);
    }
}
