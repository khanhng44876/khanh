<?php

namespace App\Services;

use App\Models\Product;

class ProductService{

    public function show(){
        return Product::orderBy('created_at','desc')->paginate(5);
    }

    public function homeView(){
        return Product::where('status', 'Còn hàng')->orderBy('created_at', 'desc')->paginate(8);
    }

    public function create(array $data):Product{
        return Product::create($data);
    }

    public function update(array $data , $id):Product{
        $product = Product::findOrFail($id);
        $product->code_product = $data['code_product'];
        $product->name = $data['name'];
        $product->quantity = $data['quantity'];
        $product->price = $data['price'];
        $product->img = $data['img'];
        $product->save();
        return $product;
    }

    public function search($term){
        $result = Product::where('code_product','like',"%{$term}%")
            ->orWhere('name','like',"%{$term}%")
            ->limit(10)
            ->get(['id','code_product','name']);
        return $result->map(fn($p)=>[
            'id'=>$p->id,
            'label'=>"{$p->code_product}-{$p->name}",
            'value'=>$p->name
        ]);
    }

    public function sort(array $data){
        $query = Product::query();
        if($data['sort'] === 'desc'){
            $query->orderBy('price','desc');
        }elseif($data['sort'] === 'asc'){
            $query->orderBy('price','asc');
        }else{
            $query->orderBy('created_at','desc');
        }
        return $query->paginate(8)->appends(['sort' => $data['sort']]);
    }
}