<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //product and category api
    public function productList(){
        $products = Product::get();
        $categories = Category::get();

        $data = [
            "products" => $products,
            "categories" => $categories
        ];
        return response()->json($data, 200);
    }

    // orders list api
    public function ordersList(){
        $orders = Order::get();
        return response()->json($orders, 200);
    }

    //users list api
    public function userList(){
        $users = User::get();
        return response()->json($users, 200);
    }

    // create pizza
    public function create(Request $request){
        $data = [
            "name" => $request->name,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];

       $response = Category::create($data);
       return response()->json($response, 200);
    }

    // create contact
    public function contact(Request $request){
        $data = $this->getContactData($request);
        Contact::create($data);

        $contacts = Contact::get();
        return response()->json($contacts, 200);
    }

    // deleteCategory
    public function deleteCategory($id){
        $deleteList = Category::where("id",$id)->first();
        if(isset($deleteList)){
            $data = Category::where("id",$id)->delete();
            return response()->json(["message" => "delete success"], 200);
        }else{
            return response()->json(["message" => "delete id no category"], 500,);
        }
    }

    // details category
    public function detailCategory($id){
        $detail = Category::where("id",$id)->first();
        if(isset($detail)){
            $categoryDetail = Category::where("id",$id)->first();
            return response()->json($categoryDetail, 200);
        }else{
            return response()->json(["message" => "no category id not found"], 500);
        }
    }

    // update category
    public function updateCategory(Request $request){
         $categoryId = $request->category_id;
         $data = $this->getUpdateCategoryData($request);

        $category  =  Category::where("id",$categoryId)->first();
        if(isset($category)){
            $categoryUpdate =  Category::where("id",$categoryId)->update($data);
            return response()->json($data, 200,);
        }else{
            return response()->json(["message" => "category_id no found"], 500,);
        }
    }

    // get contact data
    private function getContactData($request){
        return [
            "user_id" => $request->user_id,
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];
    }

    // update category data
    private function getUpdateCategoryData($request){
        return [
            "name" => $request->name,
            "updated_at" => Carbon::now()
        ];
    }
}
