<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryAdd;
use App\Http\Requests\SubCategoryEdit;
use App\Http\Resources\SubCategoryRes;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public $view = 'SubCategory';
    public function addSubCategoryView()
    {
        $categories = $this->getCategories();
        

        return view('admin.subcategory.subcategory_add', ['categories' => $categories, 'view' => $this->view]);
    }
    public function addSubCategory(SubCategoryAdd $request)
    {
        // validate input user
        $validated = $request->validated();

        SubCategory::create([

            'category_id' => $validated['category_id'],
            'subcategory_name' => $validated['subcategory_name']
        ]);

        return redirect()->back()->with('success', 'Successfully add subcategory !');
    }
    public function listSubCategoryView()
    {
        $data =  SubCategoryRes::collection(Category::get())->resolve();
        return view('admin.subcategory.subcategory_list', ['view' => $this->view, 'data' => $data]);
    }

    public function editSubCategoryView(Request $request)
    {
        $categories = $this->getCategories();
        if ($request->get('subcategory_id') != null) {
            $subcategory = SubCategory::find($request->get('subcategory_id'));
            return view('admin.subcategory.subcategory_edit', ['view' => $this->view, 'subcategory' => $subcategory,'categories' => $categories]);
        }
    }

    public function editSubCategory(SubCategoryEdit $request){
        $validated = $request->validated();
    

        SubCategory::where('id',$request->post('subcategory_id'))->update([
            'category_id' => $validated['category_id'],
            'subcategory_name' => $validated['subcategory_name']
        ]);

        return redirect()->to('/admin/subcategory')->with('success','Successfully edit 
        subcategory');
    }

    public function deleteSubCategory(Request $request){
        SubCategory::where('id',$request->post('subcategory_id'))->delete();
        return redirect()->to('/admin/subcategory')->with('success','Successfully delete 
        subcategory');
    }

    private function getCategories(){
        $categories = Category::orderBy('category_name', 'ASC')->get();
        if (count($categories) < 1) {
            return view('error.oops', ['msg' => 'Please Add Category Before !']);
        }

        return $categories;
    }
}
