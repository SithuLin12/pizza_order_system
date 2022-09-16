<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product list
    public function list(){
        $pizza = Product::select('products.*','categories.name as category_name')
            ->when(request('key'),function($query){
            $key = request('key');
            $query->where("products.name",'like','%'.$key.'%');
        })
        ->leftjoin("categories","products.category_id","categories.id")
        ->orderBy("products.created_at","desc")
        ->paginate(3);

        return view("admin.product.pizzaList",compact("pizza"));
    }

    // direct createPage
    public function createPage(){
        $categories = Category::select('id','name')->get();
        return view("admin.product.create",compact("categories"));
    }

    public function create(Request $request){
        $this->productValidationCheck($request,"create");

        $data = $this->productInfo($request);

            $fileName =uniqid() . $request->file("pizzaImage")->getClientOriginalName();
            $request->file("pizzaImage")->storeAs('public',$fileName);
            $data["image"] = $fileName;
        Product::create($data);
        return redirect()->route("product#list");
    }


    // delete pizza
    public function delete($id){
        Product::where("id",$id)->delete();
        return redirect()->route("product#list")->with(["deleteSession" => "product delete success"]);
    }

    // edit pizza
    public function edit($id){
        $pizza = Product::select("products.*","categories.name as category_name" )
                    ->leftjoin("categories","products.category_id","categories.id")
                    ->where("products.id",$id)->first();
        return view("admin.product.edit",compact('pizza'));
    }

    // update page
    public function updatePage($id){
        $pizza = Product::where("id",$id)->first();
        $categories = Category::get();
        return view("admin.product.update",compact('pizza','categories'));
    }

    // update pizza process
    public function update(Request $request){

        $this->productValidationCheck($request,"update");
        $data = $this->productInfo($request);

        if($request->hasFile("pizzaImage")){
            $oldImageName = Product::where("id",$request->pizzaId)->first();
            $oldImageName = $oldImageName->image;


                Storage::delete('public/'.$oldImageName);


            $fileName = uniqid() . $request->file("pizzaImage")->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public/',$fileName);
            $data["image"] = $fileName;
        }

        Product::where("id",$request->pizzaId)->update($data);
        return redirect()->route("product#list");
    }

    // product validation
    private function productValidationCheck($request,$action){


        $validationRule = [
            "pizzaName" => "required|min:5|unique:products,name,".$request->id,
            "pizzaCategory" => "required",
            "pizzaDescription" => "required|min:10",
            "pizzaWaitingTime" => "required",
            "pizzaPrice" => "required"
        ];

        $validationRule["pizzaImage"] = $action == "create" ? "required|mimes:jpg,webp,jpeg,png|file" : "mimes:jpg,webp,jpeg,png|file";

        Validator::make($request->all(),$validationRule)->validate();
    }

    // product get data
    private function productInfo($request){
        return [
        "category_id" => $request->pizzaCategory,
        "name" => $request->pizzaName,
        "description" => $request->pizzaDescription,
        "waiting_time" => $request->pizzaWaitingTime,
        'price' => $request->pizzaPrice
        ];
    }
}
