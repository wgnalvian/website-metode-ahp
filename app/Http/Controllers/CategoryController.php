<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryAddReq;
use App\Http\Requests\CategoryEditReq;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public $view = 'Category';
    public function categoryAddView()
    {

        return view('admin.category.category_add', ['view' => $this->view]);
    }

    public function addCategory(CategoryAddReq $request)
    {
        // validate input user
        $validated = $request->validated();

        Category::create([
         
            'category_name' => $validated['category_name'],
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Successfully add category !');
    }
    public function listCategoryView()
    {

        $categories = Category::orderBy('id', 'asc')->get();

        return view('admin.category.category_list', ['view' => $this->view, 'categories' => $categories]);
    }

    public function editCategoryView(Request $request)
    {
        if ($request->get('category_id') != null) {
            $category = Category::where('id', $request->get('category_id'))->first();
            return view('admin.category.category_edit', ['view' => $this->view, 'category' => $category]);
        }
    }

    public function editCategory(CategoryEditReq $request){
        $validated = $request->validated();
        dd($request->all());
        Category::where('id',$request->post('category_id'))->update(['category_name' => $validated['category_name']]);


        return redirect()->to('/category')->with('success','SUccessfully edit category !');
    }
    public function deleteCategory(Request $request){
        
        if($request->post('category_id')){
            Category::find($request->post('category_id'))->delete();
            return redirect()->back()->with('success','Successfully delete category');
        }
    }
}
