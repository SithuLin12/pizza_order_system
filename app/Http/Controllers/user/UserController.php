<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //direct user home page
    public function home(){
        $pizza = Product::orderBy("created_at","desc")->get();
        $categories = Category::get();
        $cart = Cart::where("user_id",Auth::user()->id)->get();
        $order = Order::where("user_id",Auth::user()->id)->get();
        return view("user.main.home",compact("pizza","categories","cart","order"));
    }

    // change password page
    public function change(){
        return view("user.password.change");
    }

    // change password process
    public function changePassword(Request $request){
        $this->passwordValidation($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbPassword = $user->password;

        if(Hash::check($request->oldPassword,$dbPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            return back()->with(["successPassword" => "change password is successful!"]);
        }
    }

    // user account change page
    public function accountChange(){
        return view("user.profile.account");
    }

    // user userAccountChange
    public function userAccountChange($id, Request $request){
        $this->accoutValidation($request);
        $data  = $this->getUserData($request);

        if($request->hasFile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs("public",$fileName);
            $data["image"] = $fileName;
        }

        User::where("id",$id)->update($data);
        return back()->with(["updateSession" => "Account Updated..."]);
    }

    // filter pizza
    public function filter($categoryId){
        $pizza = Product::where("category_id",$categoryId)->orderBy("created_at","desc")->get();
        $categories = Category::get();
        $cart = Cart::where("user_id",Auth::user()->id)->get();
        $order = Order::where("user_id",Auth::user()->id)->get();
        return view("user.main.home",compact("pizza","categories","cart","order"));
    }

    // direct pizza detals
    public function pizzaDetails($pizzaId){
        $pizza = Product::where("id",$pizzaId)->first();
        $pizzaList = Product::get();
        return view("user.main.details",compact('pizza','pizzaList'));
    }

    // cart list page
    public function cartList(){
        $cart = Cart::select("carts.*","products.name as product_name","products.price as product_price","products.image as product_image")
            ->leftJoin("products","products.id","carts.product_id")
            ->where("carts.user_id",Auth::user()->id)->get();

        $totalPrice = 0;
        foreach($cart as $c){
            $totalPrice += $c->product_price * $c->qty;
        }
        return view("user.main.cart",compact("cart","totalPrice"));
    }

    // user history
    public function history(){
        $order = Order::orderBy("created_at","desc")->where("user_id",Auth::user()->id)->paginate(6);
        return view("user.main.history",compact("order"));
    }




    // password validation check
    private function passwordValidation($request){

        Validator::make($request->all(),[
            "oldPassword" => "required|min:6|max:10",
            "newPassword" => "required|min:6|max:10",
            "confirmPassword" => "required|min:6|same:newPassword|max:10"
        ])->validate();
    }

    // accout validation check
    private function accoutValidation($request){

        Validator::make($request->all(),[
            "name" => "required",
            'email' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,webp|file',
            'address' => 'required',
            'gender' => 'required'
        ])->validate();
    }

    // get user data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender
        ];
    }
}
