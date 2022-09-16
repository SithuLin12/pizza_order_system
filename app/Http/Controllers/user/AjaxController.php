<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //
    public function pizzaList(Request $request){
        // logger($request->status);
        if($request->status == "asc"){
            $data = Product::orderBy("created_at","asc")->get();
        }else{
            $data = Product::orderBy("created_at","desc")->get();
        }

        return $data;
    }

    // return pizza list
    public function addToCart(Request $request){
        $data = $this->getOrderData($request);

        Cart::create($data);

        $response = [
            "message" => "add to cart complete",
            "status" => "success"
        ];
         return response()->json($response, 200);
    }

    // get order data
    public function getOrderData($request){
        return [
            "user_id" => $request->userId,
            "product_id"=> $request->pizzaId,
            "qty" => $request->count,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];
    }

    // order list
    public function order(Request $request){
        $total = 0;
         foreach($request->all() as $item){
            $data = OrderList::create([
                "user_id" => $item["user_id"],
                "product_id" => $item["product_id"],
                "qty" => $item["qty"],
                "total" => $item["total"],
                "order_code" => $item["order_code"]
            ]);
            $total += $data->total;
        }

        Cart::where("user_id",Auth::user()->id)->delete();

        Order::create([
            "user_id" => Auth::user()->id,
            "order_code" =>$data->order_code,
            "total_price" => $total + 3000
        ]);

        return response()->json([
            "status" => "success",
        ], 200);
    }

    // clear cart process
    public function clearCart(){
        Cart::where("user_id",Auth::user()->id)->delete();
    }

    // clear row cart
    public function clearRowCart(Request $request){
        Cart::where("user_id",Auth::user()->id)
            ->where("product_id",$request->productId)
            ->where("id",$request->orderId)
            ->delete();
    }

    // increaseViewCount
    public function increaseViewCount(Request $request){
        $pizza = Product::where("id",$request->productId)->first();

        $data = [
            "view_count" => $pizza->view_count + 1
        ];
        Product::where("id",$request->productId)->update($data);
    }
}
