<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryAddReq;
use App\Http\Requests\CategoryCompar;
use App\Http\Requests\CategoryEditReq;
use App\Models\Category;
use App\Models\CategoryComparM;
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
            Category::find($request->post('category_id'))->delete();
            return redirect()->back()->with('success','Successfully delete category');
        }
    }
    public function comparCateogryView()
    {
        $categories = $this->getCategories();
        if(count($categories) == 1){
            return view('error.oops', ['msg' => 'Please Add Category at least a  2 category!']);
        }
        return view('admin.category.category_compar', ['view' => $this->view, 'categories' => $categories]);
    }

    public function doComparCategory(CategoryCompar $request)
    {

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

        // Cek have cateogry ? 
        $count = Category::get()->count();

        if ($count < 2) {
            return redirect()->to('/error/oops', ['msg' => 'Please Add Category Before']);
        }

        /*
      
      So in compare have A side and B side
      A side use for  column 
      B side use for  row
      because for count AHP Method like count matriks
      Like    
              a b c  => A side
           a
           b => B side
           c 

           

  */

        // Make a query with order B side by id 
        $categoryComparA = CategoryComparM::orderBy('category_id_B', 'ASC')->get();
        if (count($categoryComparA) < 4) {
            return redirect()->to('error.oops', ['msg' => 'Please repeat compare category']);
        } else {

            // Make a simple format for count from query become like String "SideA,Value,SideB"
            $arrCategoryComparA = [];
            foreach ($categoryComparA as $key => $value) {
                $categoryIdA = $value['category_id_a'];
                $categoryIdB = $value['category_id_b'];
                $values = $value['value'];
                array_push($arrCategoryComparA, "$categoryIdA,$values,$categoryIdB");
            }
        }


        // Get Eigen Value
        $eigen = $this->getEigen($arrCategoryComparA, $count);
        // Save eigen value in database  
        foreach ($eigen as $key => $value) {
            $arrExplode = explode(',', $value);
            CategoryComparM::where([['category_id_a', '=', (int) $arrExplode[0]], ['category_id_b', '=', (int) $arrExplode[2]]])->update(['eigen_value' => (float) $arrExplode[1]]);
        }

        return redirect()->to('/admin/category');
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
        // Cek have cateogry ? 
        $count = Category::get()->count();

        if ($count < 2) {
            return view('error.oops', ['msg' => 'Please Add Category Before']);
        }
        // Query category compare value by order A side and B side
        $categoryComparB = CategoryComparM::orderBy('category_id_A', 'ASC')->orderBy('category_id_B', 'ASC')->get();

        if (count($categoryComparB) == 0) {
            return view('error.oops', ['msg' => 'Please compare category before !']);
        } else {
            // Make a format query from result query become  array [ [], [] ] for view 
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

        // Count total and mean eigen value
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

        return view('admin.category.category_compar_list', ['categories' => Category::get(), 'category_compar' => $arrCategoryComparB, 'total_eigen' => $arrTotalEigen, 'mean_eigen' => $meanEigen]);
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
}
