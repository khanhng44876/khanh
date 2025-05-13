<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    //
    public function index(){
        $cart = session()->get('cart',[]);
        return view('cart.index',compact('cart'));
    }

    public function add(Request $request,$id){
        $product = Product::findOrFail($id);
        $cart = session()->get('cart',[]);
        $inCart = $cart[$id]['quantity'] ?? 0;
        $available = $product->quantity - $inCart;

        $validated = $request->validate([
            'quantity' => ['required','integer','min:1','max:'.$available]
        ],[
            'quantity.required'=>'Vui lòng điền vào trường này',
            'quantity.integer'=>'Vui lòng điền số nguyên',
            'quantity.min'=>'Vui lòng nhập số lớn hơn 0',
            'quantity.max'=>"Chỉ còn {$available} sản phẩm trong kho!"
        ]);
        if(isset($cart[$id])){
            $cart[$id]['quantity'] += $validated['quantity'];
            $cart[$id]['total'] = $cart[$id]['price'] * $cart[$id]['quantity'];
        }else{
            $cart[$id] = [  
                "id"=>$product->id,
                "code_product"=>$product->code_product,
                "name"=>$product->name,
                "price"=>$product->price,
                "total"=>$product->price * $validated['quantity'],
                "quantity"=>$validated['quantity'],
                "img"=>$product->img
            ];
        }
        session()->put('cart',$cart);
        return redirect()->back()->with('success','Them vao gio thanh cong');
    }

    public function delete($id){
        $cart = session()->get('cart',[]);
        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart',$cart);

        }
        return redirect()->back()->with('success','Thanh cong');
    }
}
