<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //admin
    public function list(){
        $categories = Category::when(request('key'),function($query){
            $key = request("key");
            $query->where('name','like','%'.$key.'%');
        })
        ->orderBy("id","desc")
        ->paginate(4);
        return view("admin.category.list",compact("categories"));
    }

    // direct category create page
    public function createPage(){
        return view("admin.category.create");
    }

    // categor create
    public function create(Request $request){
       $this->validationCheck($request);
       $data = $this->requestCategoryData($request);
       Category::create($data);
        return redirect()->route("admin#categoryListPage");
    }

    // category delete
    public function delete($id){
        Category::where("id",$id)->delete();
        return redirect()->route("admin#categoryListPage")->with(["deleteSession" => "category delete success"]);
    }

    // edit page
    public function edit($id){
        $category = Category::where("id",$id)->first();
        return view('admin.category.edit',compact('category'));
    }

    // update page
    public function update($id,Request $request){
        $this->validationCheck($request);
        $data = $this->requestCategoryData($request);

        Category::where("id",$id)->update($data);
        return redirect()->route('admin#categoryListPage');
    }


    // category validation check
    private function validationCheck($request){

        Validator::make($request->all(),[
            "categoryName" => "required|min:4|unique:categories,name,".$request->id
        ])->validate();
    }

    // request category data
    private function requestCategoryData($request){
        return [
            "name" => $request->categoryName
        ];
    }
}
