<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryAdd;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public $view = 'SubCategory';
    public function addSubCategoryView(){
        
    }
    public function addSubCategory(SubCategoryAdd $request)
    {
        // validate input user
        $validated = $request->validated();

        SubCategory::create([
         
            'category_id' => $validated['category_id'],
            'subcategory_name' => $validated['subcategory_name']
        ]);

        return redirect()->back()->with('success', 'Successfully add category !');
    }
}
