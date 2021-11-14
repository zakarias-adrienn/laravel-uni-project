<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddItemToCartRequest;
use App\Http\Requests\SendCartRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderedItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function showAll()
    {
        $orders = Order::where('status', 'CART')->where('user_id', Auth::id())->get();
        return view('cart', compact('orders'));
    }

    public function remove($itemId) {
        // ki kell szedni az ordersből
        // ki kell szedni az ordereditemből
        $oncart = Order::where('status', 'CART')->first()->ordered_items;
        $ordereditem = null;
        foreach($oncart as $o){
            if($o->item_id==$itemId){
                $ordereditem = $o;
            break;
            }
        }
        if ($ordereditem==null){
            return redirect()->route('items');
        }

        $name = $ordereditem->item->name;
        $ordereditem->delete();

        $orders = Order::where('status', 'CART')->where('user_id', Auth::id())->get();
        foreach($orders as $order){
            if(empty($order->ordered_items->toArray())){
                $order->delete();
            }
        }

        return redirect()->route('cart')->with('item_deleted', $name);
    }

    public function add(AddItemToCartRequest $request, $itemId) {
        $orders = Order::where('status', 'CART')->where('user_id', Auth::id())->get();

        $data = $request->all();
        // var_dump($data);
        // új Order - default address
        // ha már bent van a kosárban, akkor csak a mennyiség növekedjen
        $items = Item::all();
        $order = null;
        $oi = null;
        $itemK = null;
        $found = false;
        if($orders->first()!==null) {
            foreach($orders->first()->ordered_items as $oe){
                if((int)$oe->item->id===(int)$itemId){
                    $found = true;
                    $itemK = $oe->item;
                    $oi = $oe;
                break;
                }
            }
        }

        // ha van CART Order akkor ahhoz adjuk hozzá
        // különben hozzunk létre egyet
        if(empty($orders->toArray())){
            $order = new Order();
            $order['status'] = 'CART';
            $order->user()->associate(Auth::user());
            $order->save();
        } else {
            $order = $orders[0];
        }

        if($found===false){

            // új Ordered_Item
            $ordereditem = new OrderedItem();
            $ordereditem['quantity'] = $data['quantity'];
            $ordereditem->order()->associate($order);
            $item = Item::find($itemId);
            $ordereditem->item()->associate($item);
            $ordereditem->save();
            $item->ordered_items()->save($ordereditem);
            $item->save();
            $order->ordered_items()->save($ordereditem);
            $order->save();
        } else {
            $oi['quantity'] = $oi['quantity'] + $data['quantity'];
            $oi->save();
            $itemK->ordered_items()->save($oi);
            $itemK->save();
            $order->ordered_items()->save($oi);
            $order->save();
        }


        return redirect()->route('cart');
    }

    public function send(SendCartRequest $request) {
        $data = $request->all();
        if(!isset($data['payment_method'])){
            return redirect()->route('cart');
        }
        // át kellene állítani a CART-ot valamire
        $order = Order::where('user_id', Auth::id())->where('status','CART')->first();
        $order->status = 'RECEIVED';
        $order->received_on = date_create('now');

        // order adatait beállítani
        $order->address = $data['address'];
        // comment ha csak van - ez valamiért nem jó TODO
        if(isset($data['comment'])){
            $order->comment = $data['comment'];
        }
        $order->payment_method = $data['payment_method'];
        $order->save();

        return redirect()->route('items')->with('success_order', true);
    }
}
