<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Contracts\Service\Attribute\Required;

class AdminController extends Controller
{
    //view
    // public function index() 
    // {
    //     return view('admin/registration');
    // }
    public function index(){
        $url = url('/admin');
        $title = "Admin Registration form";
        $data = compact('url','title');
        return view('admin/registration')->with($data);
    }
    //Customer information store
    public function store(Request $res)
    {
        // $res->validate(
        //     [
        //         'name'=>'required',
        //         'gmail'=>'required',
        //         'address'=>'required',
        //         'password'=>'required | Confirmed',
        //         'date_of_birth'=>'required',
        //         'image' => 'required',
        //     ]
        //     );
        echo "<pre>";
        print_r($res->all());
        $admin = new Admin;
        $admin->name = $res -> name;
        $admin->gmail = $res -> gmail;
        $admin->address = $res -> address;
        $admin->password = Hash::make($res->password);
        $admin->date_of_birth = $res -> date_of_birth;
        $admin->image = $res -> image;
        $admin->save();
    }

    //Customer Information Show
    public function show(Request $req) 
    {
        $customer = Customer::all();
        $data = compact('customer');
        return view('admin.customer_info_show')->with($data);
    }

    public function product() 
    {
        $url = url('/add_product');
        $title = "Add Product";
        $data = compact('url','title');
        return view('admin/product')->with($data);
    } 
    public function show_product(Request $req) 
    {
        $product = Product::all();
        $data = compact('product');
        return view('admin.product_show')->with($data);
    }
    public function add_product(Request $req) 
    {
        $product = new Product;
        $product->product_name = $req -> product_name;
        $product->product_price = $req -> product_price;
        $product->product_description = $req -> product_description;
        $product->image = $req -> image;
        $product->quantity = $req -> quantity;
        $product->category = $req -> category;
        $product->size = $req -> size;
        $product->save();
        return redirect('show_product');
    }
    
    public function delete($id) 
    {
        $product=Product::find($id);
        if(!is_null($product)) 
        {
            $product->delete();
        }
        return redirect('show_product');
    }

    public function edit($id)
    {
        $product= Product::find($id);
        if(is_null($product)){
            
            return redirect('show_product');
        }
        else{
            $title = "Update Product";
            $url = url('/show_product/update') ."/". $id;
            $data = compact('product', 'url','title');
            return redirect('show_product');
        }
    }
    public function update($id, Request $req)
    {
        $product = Product::find($id);
        $product->product_name = $req -> product_name;
        $product->product_price = $req -> product_price;
        $product->product_description = $req -> product_description;
        $product->image = $req -> image;
        $product->quantity = $req -> quantity;
        $product->category = $req -> category;
        $product->size = $req -> size;
        $product->save();

        return redirect('show_product');
    }
}