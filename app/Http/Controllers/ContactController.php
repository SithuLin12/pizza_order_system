<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // user contact page
    public function contactPage(){
        return view("user.contact.contact");
    }

    // user contact process
    public function contact(Request $request){
        $this->contactValidation($request);
        $data = $this->contactData($request);
        Contact::create($data);
        return redirect()->route("user#home")->with(["contactMessage" => "contact us your message accepted"]);
    }

    // contact validation
    private function contactValidation($request){
        Validator::make($request->all(),[
            "name" => "required|min:5",
            "email" => "required|min:5",
            "message" => "required|min:5"
        ])->validate();
    }

    // contact data
    private function contactData($request){
        return [
            "user_id" => Auth::user()->id,
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message
        ];
    }
}
