<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\Rule;
use App\Services\ProductService;


class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service){
        $this->service = $service;
    }

    //
    public function show(){
        $product = $this->service->show();
        return view('admin.admin',compact('product'));
    }

    public function homeView()
    {
        $listProduct = $this->service->homeView();

        return view('customer.customer', compact('listProduct'));
    }

    public function search(Request $request){
        $term = $request->get('term','');

        $suggest = $this->service->search($term);

        return response()->json($suggest);   
    }

    public function sort(Request $request){
        $valid = $request->validate([
            'sort'=>['nullable','in:desc,asc']
        ]);

        $data = $valid;

        $listProduct = $this->service->sort($data);
        
        return view('customer.customer', compact('listProduct'));
    }

    public function detail($id){
        $product = Product::findOrFail($id);
        return view('customer.detail',compact('product'));
    }

    public function create(Request $request){
        $validated = $request->validate([
            "code_product"=>['required','string','unique:product,code_product'],
            "name"=>['required','string','max:255'],
            "quantity"=>['required','integer','min:1'],
            "price"=>['required','numeric','min:1'],
            'img'=>['required']
        ],[
            'code_product.required'=>'Không được bỏ trống trường này',
            'code_product.string'=>'Phải là chuỗi',
            'code_product.unique'=>'Mã này đã tồn tại',
            'name.required'=>'Không được để trống trường này',
            'name.string'     => 'Tên phải là chuỗi ký tự.',
            'name.max'        => 'Tên không vượt quá 255 ký tự.',
            'quantity.required'=>'Không được bỏ trống trường này',
            'price.required'=>'Không được bỏ trống trường này',
            'quantity.integer'=>'Số này phải là int',
            'quantity.min'=>'Nhập số lớn hơn 0',
            'price.numeric'=>'Nhập số',
            'price.min'=>'Nhập số lớn hơn 0',
        ]);
        $data = $validated;

        $product = $this->service->create($data);

        return redirect()->route('product.manager')->with('success','Thành công');
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            "code_product"=>['required','string',Rule::unique('product','code_product')->ignore($id)],
            "name"=>['required','string','max:255'],
            "quantity"=>['required','integer','min:1'],
            "price"=>['required','numeric','min:1'],
            'img'=>['required']
        ],[
            'code_product.required'=>'Không được bỏ trống trường này',
            'code_product.string'=>'Phải là chuỗi',
            'code_product.unique'=>'Mã này đã tồn tại',
            'name.required'=>'Không được để trống trường này',
            'name.string'     => 'Tên phải là chuỗi ký tự.',
            'name.max'        => 'Tên không vượt quá 255 ký tự.',
            'quantity.required'=>'Không được bỏ trống trường này',
            'price.required'=>'Không được bỏ trống trường này',
            'quantity.integer'=>'Số này phải là int',
            'quantity.min'=>'Nhập số lớn hơn 0',
            'price.numeric'=>'Nhập số',
            'price.min'=>'Nhập số lớn hơn 0',
        ]);

        $data = $validated;

        $product = $this->service->update($data,$id);

        return redirect()->route('product.manager')->with('success','Thanh cong');
    }

    public function updatePage($id){
        $product = Product::findOrFail($id);
        return view('admin.updateProduct',compact('product'));
    }

    public function delete($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.manager')->with('success','Thành công');
    }
}
