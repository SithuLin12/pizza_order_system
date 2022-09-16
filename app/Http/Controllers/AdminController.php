<?php

namespace App\Http\Controllers;
use Storage;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage(){
        return view("admin.account.change");
    }

    // change passwor
    public function changePassword(Request $request){

        $this->passwordValidation($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbPassword = $user->password;

        if(Hash::check($request->oldPassword,$dbPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            return redirect()->route("admin#changePasswordPage")->with(["successPassword" => "change password is successful!"]);
        }
        return redirect()->route("admin#changePasswordPage")->with(["notMatch" => 'The old Password not Match Try again']);
    }

    // admin direct details page
    public function details(){
        return view("admin.account.details");
    }

    // admin details edit
    public function edit(){
        return view("admin.account.edit");
    }

    // admin update
    public function update($id,Request $request){

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
        return redirect()->route("admin#details")->with(["updateSession" => "Admin Account Updated..."]);
    }

    // admin list
    public function list(){
        $admin = User::when(request("key"),function($query){
                    $query->orWhere("name",'like','%'.request("key").'%')
                        ->orWhere("email",'like','%'.request("key").'%')
                        ->orWhere("phone",'like','%'.request("key").'%')
                        ->orWhere("address",'like','%'.request("key").'%');
                })
                    ->where('role','admin')->paginate(3);
        return view("admin.account.list",compact('admin'));
    }

    // admin list delete
    public function delete($id){
        User::where("id",$id)->delete();
        return redirect()->route("admin#list")->with(["deleteSession" => "Admin List Delete"]);
    }

    // admin change role
    public function changeRole($id){
        $account = User::where("id",$id)->first();
        return view("admin.account.changeRole",compact("account"));
    }

    // admin change role update process
    public function roleUpdate($id,Request $request){
        $data = $this->changeRoleData($request);
        User::where("id",$id)->update($data);
        return redirect()->route("admin#list");
    }

    // admin change role
    public function ajaxChangeRole(Request $request){
        $changeRole = User::where("id",$request->userId)->update([
            'role' => $request->status
        ]);
        return response()->json([
            "status" => "success",
        ], 200);
    }

    // users list page
    public function usersList(){
        $users = User::when(request("key"),function($query){
            $key = request("key");
            $query->orWhere("name","like","%".$key."%")
                    ->orWhere("email","like","%".$key."%");
        })

        ->orderBy("created_at","desc")->where("role","user")->paginate(3);
        return view("admin.userAccount.list",compact("users"));
    }

    // users list delete
    public function usersDelete($id){
        User::where("id",$id)->delete();
        return back();
    }

    // users list admin change role
    public function userChangeRole(Request $request){
        $data = [
            "role" => $request->status
        ];
        User::where("id",$request->userId)->update($data);
    }

    // admin contact list
    public function contactList(){
        $contact =  Contact::get();
        return view("admin.contact.list",compact("contact"));
    }

    // admin contact details
    public function contactDetails($id){
        $contactDetails = Contact::where("id",$id)->first();
        return view("admin.contact.details",compact("contactDetails"));
    }

    // admin contact ban account
    public function block($id){
        User::where("id",$id)->delete();
        Contact::where("user_id",$id)->delete();
        Order::where("user_id",$id)->delete();
        OrderList::where("user_id",$id)->delete();
        return back();
    }

    // admin change role get data
    private function changeRoleData($request){
        return [
            "role" => $request->role
        ];
    }

    // password validation check
    private function passwordValidation($request){

        Validator::make($request->all(),[
            "oldPassword" => "required|min:6",
            "newPassword" => "required|min:6",
            "confirmPassword" => "required|min:6|same:newPassword"
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

    // update  get data
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
