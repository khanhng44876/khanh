<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Http\Resources\OrderResource;
use App\Jobs\SendEmailJob;
use App\Events\OrderEvent;


class OrderController extends Controller
{
    public function order_list(){
        $list = Auth::user()->order()->with('detail.product')->latest()->paginate(8);
        $orders = OrderResource::collection($list);
        return view('customer.order',compact('orders'));
    }

    public function create(Request $request){
        $cart = session()->get('cart',[]);

        if(empty($cart)){
            return back()->withErrors('Giỏ hàng trống, không thể đặt đơn');
        }

        $validated = $request->validate([
            'total' => ['required','numeric','min:1']
        ]);

        $order = Auth::user()->order()->create([
            'total' => $validated['total'],
            'status'=>'Chờ xác nhận',
        ]);

        foreach ($cart as $item) {
            $order->detail()->create([
                'product_id' => $item['id'],
                'quantity'   => $item['quantity'],
                'total'      => $item['total'],
                'status'     => 'Success', 
            ]);
            $product = Product::find($item['id']);
            if($product){
                $product->decrement('quantity', $item['quantity']);
                if($product->quantity === 0){
                    $product->update = ['status','Hết hàng'];
                }
            }
        }

        session()->forget('cart');

        SendEmailJob::dispatch($order);

        return redirect()
            ->route('order.page')
            ->with('success', 'Đơn hàng đã được lưu thành công!');
    }

    public function order_by_status(){
        $waitingOrder = Order::with('user')->where('status','Chờ xác nhận')->latest()->get();
        $waitingShip = Order::with('user')->where('status','Chờ giao hàng')->latest()->get();
        $shipping = Order::with('user')->where('status','Đang giao hàng')->latest()->get();
        $success = Order::with('user')->where('status','Success')->latest()->get();
        return view('admin.updateOrder', compact(
            'waitingOrder',
            'waitingShip',
            'shipping',
            'success'
        ));
    }

    public function updateStatusPage($id){
        $order = Order::with('detail.product')->findOrFail($id);
        return view('admin.update_order_page',compact('order'));
    }

    public function follow($id){
        $order = Order::findOrFail($id);
        $orderSteps = [
            'first' =>['label'=>'Chờ xác nhận','date'=>$order->created_at],
            'second'=>['label'=>'Chờ giao hàng','date'=>$order->confirmed_at],
            'third'=>['label'=>'Đang giao hàng','date'=>$order->shipping_at],
            'forth'=>['label'=>'Success','date'=>$order->updated_at],
        ];
        $key = array_keys($orderSteps);
        $current = array_search($order->status,$key,true);

        $step = array_slice(
            $orderSteps,0,$current + 1,true
        );
        return view('order.follow',compact('order','step'));
    }

    public function updateStatus($id){
        $order = Order::findOrFail($id);
        if($order->status === 'Chờ xác nhận'){
            $order->status = 'Chờ giao hàng';
            $order->confirmed_at = now();
        }else if($order->status === 'Chờ giao hàng'){
            $order->status = 'Đang giao hàng';
            $order->shipping_at = now();
        }else if($order->status === 'Đang giao hàng'){
            $order->status = 'Success';
        }
        $order->save();
        broadcast(new OrderEvent($order));
        return redirect()->back();
    }
}
