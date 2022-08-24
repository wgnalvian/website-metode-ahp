<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryAddReq;
use App\Http\Requests\CategoryCompar;
use App\Http\Requests\CategoryEditReq;
use App\Models\AlternativeData;
use App\Models\Category;
use App\Models\CategoryComparM;
use App\Models\SubCategoryComparM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public $view = 'Category';
    public function categoryAddView()
    {
        $isExistCompareCategory = false;
        if (CategoryComparM::get()->count() != 0) {
            $isExistCompareCategory = true;
        }

        return view('admin.category.category_add', ['view' => $this->view, 'isExistCompareCategory' => $isExistCompareCategory]);
    }

    public function addCategory(CategoryAddReq $request)
    {
        // validate input user
        $validated = $request->validated();

        Category::create([

            'category_name' => $validated['category_name'],

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

    public function editCategory(CategoryEditReq $request)
    {
        $validated = $request->validated();

        Category::where('id', $request->post('category_id'))->update(['category_name' => $validated['category_name']]);


        return redirect()->to('/admin/category')->with('success', 'SUccessfully edit category !');
    }
    public function deleteCategory(Request $request)
    {

        if ($request->post('category_id')) {
            CategoryComparM::truncate();
            $subcategory = Category::where('id',$request->post('category_id'))->first()->subcategory;
    
                AlternativeData::truncate();
            

            SubCategoryComparM::where('category_id',$request->post('category_id'))->delete();
            Category::where('id',$request->post('category_id'))->delete();
            Category::query()->update(['final_score' => '0','is_compare' => '0']);
            return redirect()->back()->with('success', 'Successfully delete category');
        }
    }
    public function comparCateogryView()
    {

        $categories = $this->getCategories();
        if (count($categories) == 1) {
            return view('error.oops', ['msg' => 'Please Add Category at least a  2 category!']);
        }

        $isCompareExist = Category::where('is_compare', '1')->get()->count() == 0 ? false : true;
        return view('admin.category.category_compar', ['view' => $this->view, 'categories' => $categories, 'isCompareExist' => $isCompareExist]);
    }

    public function doComparCategory(CategoryCompar $request)
    {
        // *Reset Category Compare Table
        CategoryComparM::truncate();

        // *Make a format from [[a,value,b]] to [[a,value,b],[b,value,a],[a,1,a],[b,1,b]] 
        $categoryCompar = [];
        $arrayTemp = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match("/category_compar_[0-9]/", $key)) {
                $categoryExplode = explode(',', $value);
                array_push($arrayTemp, $categoryExplode[2]);
                array_push($arrayTemp, $categoryExplode[0]);
                array_push($categoryCompar, $value);
                $valueTemp = 1 / (int) $categoryExplode[1];
                array_push($categoryCompar, "$categoryExplode[2],$valueTemp,$categoryExplode[0]");
            }
        }
        $arrayTemp = array_unique($arrayTemp);
        foreach ($arrayTemp as $key => $value) {
            array_push($categoryCompar, "$value,1,$value");
        }

        sort($categoryCompar);
        foreach ($categoryCompar as $key => $value) {
            $categoryExplode = explode(',', $value);

            CategoryComparM::create(["category_id_a" => $categoryExplode[0], "value" => $categoryExplode[1], "category_id_b" => $categoryExplode[2]]);
        }
        // *Update field is_compare to 1 (true)
        Category::query()->update(['is_compare' => '1']);





        // *Cek have cateogry ? 
        $count = Category::get()->count();

        if ($count < 2) {
            return redirect()->to('/error/oops', ['msg' => 'Please Add Category Before']);
        }

        /** 
      
         * ? So in compare have A side and B side
         * ? A side use for  column 
         * ? B side use for  row
         * ? because for count AHP Method like count matriks
         * ? Like    
         * TODO        a b c  => A side
         * TODO    a
         * TODO    b => B side
         * TODO    c 

           

         */

        // *Make a query with order B side by id 
        $categoryComparA = CategoryComparM::orderBy('category_id_b', 'ASC')->get();
        if (count($categoryComparA) < 4) {
            return redirect()->to('error.oops', ['msg' => 'Please repeat compare category']);
        } else {

            // *Make a simple format for count from query become like String "SideA,Value,SideB"
            $arrCategoryComparA = [];
            foreach ($categoryComparA as $key => $value) {
                $categoryIdA = $value['category_id_a'];
                $categoryIdB = $value['category_id_b'];
                $values = $value['value'];
                array_push($arrCategoryComparA, "$categoryIdA,$values,$categoryIdB");
            }
        }


        // *Get Eigen Value
        $eigen = $this->getEigen($arrCategoryComparA, $count);
        // *Save eigen value in database  
        foreach ($eigen as $key => $value) {
            $arrExplode = explode(',', $value);
            CategoryComparM::where([['category_id_a', '=', (int) $arrExplode[0]], ['category_id_b', '=', (int) $arrExplode[2]]])->update(['eigen_value' => (float) $arrExplode[1]]);
        }

           // *Cek have cateogry ? 
           $count = Category::where('is_compare', '1')->get()->count();
           $countC = CategoryComparM::get()->count();
   
           if ($count < 2) {
               return view('error.oops', ['msg' => 'Please Add & Compare Category Before']);
           } else if ($countC < 4) {
               return view('error.oops', ['msg' => 'Please compare category before !']);
           }
   
   
   
           // *Query category compare value by order A side and B side
           $categoryComparB = CategoryComparM::orderBy('category_id_a', 'ASC')->orderBy('category_id_b', 'ASC')->get();
   
           if (count($categoryComparB) == 0) {
               return view('error.oops', ['msg' => 'Please compare category before !']);
           } else {
               // *Make a format query from result query become  array [ [], [] ] for view 
               $inc = 0;
               $divider = 0;
               $arrCategoryComparB = [];
               foreach ($categoryComparB as $key => $value) {
                   if ($inc  == $count) {
                       $inc = 0;
                       $divider++;
                   }
                   $arrCategoryComparB[$divider][$inc] = $value;
   
                   $inc++;
               }
           }
   
           // *Count total and mean eigen value
           $inc = 0;
           $arrTotalEigen = [];
           $meanEigen = [];
           $totEigen = 0;
           foreach ($categoryComparB as $key => $value) {
   
               if ($inc == $count) {
                   $inc = 0;
                   array_push($arrTotalEigen, $totEigen);
                   array_push($meanEigen, $totEigen / $count);
   
                   $totEigen = 0;
               }
               if ($key == (count($categoryComparB) - 1)) {
                   $totEigen += (float) $value['eigen_value'];
                   array_push($arrTotalEigen, $totEigen);
                   array_push($meanEigen, $totEigen / $count);
               }
   
   
               $totEigen += (float) $value['eigen_value'];
               $inc++;
           }
   
   
           // *Save final score to table category
           $categories = Category::where('is_compare', '1')->orderBy('id', 'ASC')->get();
           foreach ($categories as $key => $category) {
               $category->update(['final_score' => $meanEigen[$key]]);
           }
   

        return redirect()->to('/admin/category/compar/list');
    }
    private function getCategories()
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        if (count($categories) < 1) {
            return view('error.oops', ['msg' => 'Please Add Category Before !']);
        }

        return $categories;
    }

    public function categoryComparView()
    {
        // *Cek have cateogry ? 
        $count = Category::where('is_compare', '1')->get()->count();
        $countC = CategoryComparM::get()->count();

        if ($count < 2) {
            return view('error.oops', ['msg' => 'Please Add & Compare Category Before']);
        } else if ($countC < 4) {
            return view('error.oops', ['msg' => 'Please compare category before !']);
        }



        // *Query category compare value by order A side and B side
        $categoryComparB = CategoryComparM::orderBy('category_id_a', 'ASC')->orderBy('category_id_b', 'ASC')->get();

        if (count($categoryComparB) == 0) {
            return view('error.oops', ['msg' => 'Please compare category before !']);
        } else {
            // *Make a format query from result query become  array [ [], [] ] for view 
            $inc = 0;
            $divider = 0;
            $arrCategoryComparB = [];
            foreach ($categoryComparB as $key => $value) {
                if ($inc  == $count) {
                    $inc = 0;
                    $divider++;
                }
                $arrCategoryComparB[$divider][$inc] = $value;

                $inc++;
            }
        }

        // *Count total and mean eigen value
        $inc = 0;
        $arrTotalEigen = [];
        $meanEigen = [];
        $totEigen = 0;
        foreach ($categoryComparB as $key => $value) {

            if ($inc == $count) {
                $inc = 0;
                array_push($arrTotalEigen, $totEigen);
                array_push($meanEigen, $totEigen / $count);

                $totEigen = 0;
            }
            if ($key == (count($categoryComparB) - 1)) {
                $totEigen += (float) $value['eigen_value'];
                array_push($arrTotalEigen, $totEigen);
                array_push($meanEigen, $totEigen / $count);
            }


            $totEigen += (float) $value['eigen_value'];
            $inc++;
        }


        // *Save final score to table category
        $categories = Category::where('is_compare', '1')->orderBy('id', 'ASC')->get();
        foreach ($categories as $key => $category) {
            $category->update(['final_score' => $meanEigen[$key]]);
        }


        // *Return view
        return view('admin.category.category_compar_list', ['categories' => Category::where('is_compare', '1')->orderBy('id', 'ASC')->get(), 'category_compar' => $arrCategoryComparB, 'total_eigen' => $arrTotalEigen, 'mean_eigen' => $meanEigen]);
    }

    private function getEigen($arrayA, $count)
    {

        $tempA = '';
        $totalComparA = [];
        $totalTemp = 0;
        foreach ($arrayA as $key => $value) {
            $arrExplode = explode(',', $value);

            if ($tempA == $arrExplode[2]) {
                $totalTemp += (float) $arrExplode[1];
                if ($key == (count($arrayA) - 1)) {
                    array_push($totalComparA, $totalTemp);
                }
            } else if ($tempA == '') {
                $tempA = $arrExplode[2];
                $totalTemp += (float) $arrExplode[1];
            } else if ($tempA != $arrExplode[2]) {

                array_push($totalComparA, $totalTemp);

                $totalTemp = 0;
                $tempA = $arrExplode[2];
                $totalTemp += (float) $arrExplode[1];
            }
        }

        // -------------------------------------------
        $inc = 0;
        $divider = 0;
        $arrEigen = [];

        foreach ($arrayA as $key => $value) {
            $arrExplode = explode(',', $value);
            if ($inc == $count) {
                $inc = 0;
                $divider++;
                // --------------

            }

            $eigenValue = (float) $arrExplode[1] /  $totalComparA[$divider];
            $categoryA = $arrExplode[0];
            $categoryB = $arrExplode[2];
            array_push($arrEigen, "$categoryA,$eigenValue,$categoryB");
            if ($inc == $count) {
                $inc = 0;
                $divider++;
                // --------------

            }
            $inc++;
            // -------------


        }

        return $arrEigen;
    }
    public function categoryComparEditView()
    {
        // Cek have cateogry ? 
        $count = Category::where('is_compare', '1')->get()->count();
        $countC = CategoryComparM::get()->count();

        if ($count < 2) {
            return view('error.oops', ['msg' => 'Please Add Category Before']);
        } else if ($countC < 4) {
            return view('error.oops', ['msg' => 'Please compare category before !']);
        }
        // Get data compare category for editable
        $category = Category::where('is_compare', '1')->orderBy('id','ASC')->get();
        $tempC = [];
        $arrCompareEdit = [];

        foreach ($category as $key => $value) {
            array_push($tempC, $value['category_name']);
            foreach ($category as $key2 => $value2) {
                if ($value['category_name'] != $value2['category_name'] && !in_array($value2['category_name'], $tempC)) {
                    array_push($arrCompareEdit, CategoryComparM::where(['category_id_a' => $value['id'], 'category_id_b' => $value2['id']])->first());
                }
            }
        }
        return view('admin.category.category_compar_edit', ['view' => $this->view, 'arrCompareEdit' => $arrCompareEdit]);
    }

    public function editCategoryCompar(CategoryCompar $request)
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            if (preg_match("/category_compar_[0-9]/", $key)) {
                $arrExplode = explode(',', $value);
                CategoryComparM::where(['category_id_a' => (int) $arrExplode[0], 'category_id_b' => (int)$arrExplode[2]])->update(['value' => strval((int) $arrExplode[1])]);
                CategoryComparM::where(['category_id_a' => (int) $arrExplode[2], 'category_id_b' => (int)$arrExplode[0]])->update(['value' => strval(1 / (float) $arrExplode[1])]);
            }
        }
        // *Make a query with order B side by id 
        $categoryComparA = CategoryComparM::orderBy('category_id_B', 'ASC')->get();
        if (count($categoryComparA) < 4) {
            return redirect()->to('error.oops', ['msg' => 'Please repeat compare category']);
        } else {

            // *Make a simple format for count from query become like String "SideA,Value,SideB"
            $arrCategoryComparA = [];
            foreach ($categoryComparA as $key => $value) {
                $categoryIdA = $value['category_id_a'];
                $categoryIdB = $value['category_id_b'];
                $values = $value['value'];
                array_push($arrCategoryComparA, "$categoryIdA,$values,$categoryIdB");
            }
        }
        // *Cek have cateogry ? 
        $count = Category::where('is_compare', '1')->get()->count();

        if ($count < 2) {
            return redirect()->to('/error/oops', ['msg' => 'Please Add Category Before']);
        }

        // *Get Eigen Value
        $eigen = $this->getEigen($arrCategoryComparA, $count);
        // *Save eigen value in database  
        foreach ($eigen as $key => $value) {
            $arrExplode = explode(',', $value);
            CategoryComparM::where([['category_id_a', '=', (int) $arrExplode[0]], ['category_id_b', '=', (int) $arrExplode[2]]])->update(['eigen_value' => (float) $arrExplode[1]]);
        }

        return redirect()->to('/admin/category/compar/list');
    }
}
