<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct order list page
    public function list(){
        $order = Order::when(request('key'),function($query){
            $key = request('key');
            $query->where("order_code","like","%".$key."%");
        })
        ->select("orders.*","users.name as user_name")
        ->leftJoin("users","orders.user_id","users.id")
        ->orderBy("created_at","desc")->get();
        return view("admin.order.list",compact("order"));
    }

    // sort with ajax
    public function changeStatus (Request $request){
        // if($request->status = $request->status == null ? "" : $request->status);

        // ->get();
        $order = Order::select("orders.*","users.name as user_name")
                    ->leftJoin("users","orders.user_id","users.id")
                    ->orderBy("created_at","desc");

        if($request->orderStauts  == null){
            $order = $order->get();
        }else{
            $order = $order->Where("orders.status",$request->orderStauts)->get();
        }

        return view("admin.order.list",compact("order"));

    }

    // ajax change status
    public function ajaxChangeStatus(Request $request){
        Order::where("id",$request->orderId)->update([
            'status' => $request->status
        ]);
        $order = Order::select("orders.*","users.name as user_name")
                    ->leftJoin("users","orders.user_id","users.id")
                    ->orderBy("created_at","desc");
                    return response()->json($order,200);
    }

    // order list info
    public function listInfo($orderCode){
        $order =  Order::where("order_code",$orderCode)->first();
        $orderList = OrderList::select("order_lists.*","users.name as user_name","products.name as product_name","products.image as product_image")
                    ->leftJoin("users","order_lists.user_id","users.id")
                    ->leftJoin("products","order_lists.product_id","products.id")
                    ->where("order_code",$orderCode)->get();
                    // dd($orderList->toArray());
        return view("admin.order.productList",compact("orderList","order"));
    }
}
