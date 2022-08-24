<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryAdd;
use App\Http\Requests\SubCategoryCompar;
use App\Http\Requests\SubCategoryEdit;
use App\Http\Resources\SubCategoryRes;
use App\Models\AlternativeData;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubCategoryComparM;
use App\Models\SubCategoryM;
use Illuminate\Http\Request;
use Whoops\Run;

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
            return view('admin.subcategory.subcategory_edit', ['view' => $this->view, 'subcategory' => $subcategory, 'categories' => $categories]);
        }
    }

    public function editSubCategory(SubCategoryEdit $request)
    {
        $validated = $request->validated();


        SubCategory::where('id', $request->post('subcategory_id'))->update([
            'category_id' => $validated['category_id'],
            'subcategory_name' => $validated['subcategory_name']
        ]);

        return redirect()->to('/admin/subcategory')->with('success', 'Successfully edit 
        subcategory');
    }

    public function deleteSubCategory(Request $request)
    {
        $subcategories = SubCategory::where('id',$request->post('subcategory_id'))->first()->category->subcategory;
        
        foreach ($subcategories as $key => $value) {
            
            AlternativeData::where('subcategory_id',$value['id'])->delete();
        }

        
        SubCategoryComparM::where('category_id',SubCategory::where('id',$request->post('subcategory_id'))->first()->category->id)->delete();
        SubCategory::where('category_id',SubCategory::where('id',$request->post('subcategory_id'))->first()->category->id)->update(['final_score' => '0','is_compare' => '0']);
        SubCategory::where('id', $request->post('subcategory_id'))->delete();
        return redirect()->to('/admin/subcategory')->with('success', 'Successfully delete 
        subcategory');
    }

    private function getCategories()
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        if (count($categories) < 1) {
            return view('error.oops', ['msg' => 'Please Add Category Before !']);
        }

        return $categories;
    }

    public function comparSubcategoryView1()
    {
        $categories = $this->getCategories();
        return view('admin.subcategory.subcategory_compar_1', ['view' => $this->view, 'categories' => $categories]);
    }
    public function comparSubcategoryView2(Request $request)
    {

        $request->validate([
            'category_id' => 'required'
        ]);

        if (Category::where('id', $request->get('category_id'))->first()->subcategory()->count() < 2) {
            return view('error.oops', ['msg' => 'Please Add SubCategory at least 2 subcategory !']);
        }
        $category = Category::where('id', $request->get('category_id'))->first();
        $isCompareExist = SubCategory::where('category_id', $request->get('category_id'))->where('is_compare', '1')->get()->count() == 0 ? false : true;

        return view('admin.subcategory.subcategory_compar_2', ['view' => $this->view, 'category' => $category, 'isCompareExist' => $isCompareExist, 'category' => Category::where('id', $request->get('category_id'))->first()]);
    }
    public function subcategoryCompar(SubCategoryCompar $request)
    {

        // *Reset SubCategory Compare Table
        SubCategoryComparM::where('category_id', $request->post('category_id'))->delete();
        // *Make a format from [[a,value,b]] to [[a,value,b],[b,value,a],[a,1,a],[b,1,b]] 
        $subcategoryCompar = [];
        $arrayTemp = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match("/subcategory_compar_[0-9]/", $key)) {
                $subcategoryExplode = explode(',', $value);
                array_push($arrayTemp, $subcategoryExplode[2]);
                array_push($arrayTemp, $subcategoryExplode[0]);
                array_push($subcategoryCompar, $value);
                $valueTemp = 1 / (int) $subcategoryExplode[1];
                array_push($subcategoryCompar, "$subcategoryExplode[2],$valueTemp,$subcategoryExplode[0]");
            }
        }
        $arrayTemp = array_unique($arrayTemp);
        foreach ($arrayTemp as $key => $value) {
            array_push($subcategoryCompar, "$value,1,$value");
        }
        sort($subcategoryCompar);
        foreach ($subcategoryCompar as $key => $value) {
            $subcategoryExplode = explode(',', $value);

            SubCategoryComparM::create(["subcategory_id_a" => $subcategoryExplode[0], "value" => $subcategoryExplode[1], "subcategory_id_b" => $subcategoryExplode[2], 'category_id' => $request->post('category_id')]);
        }
        // *Update field is_compare to 1 (true)
        SubCategory::where('category_id', $request->post('category_id'))->update(['is_compare' => '1']);

        // *Cek have subcateogry ? 
        $count = SubCategory::where('category_id', $request->post('category_id'))->get()->count();

        if ($count < 2) {
            return view('error.oops', ['msg' => 'Please Add SubCategory Before']);
        }


        // *Make a query with order B side by id 
        $subcategoryComparA = SubCategoryComparM::where('category_id', $request->post('category_id'))->orderBy('subcategory_id_b', 'ASC')->get();
        if (count($subcategoryComparA) < 4) {
            return redirect()->to('error.oops', ['msg' => 'Please repeat compare subcategory']);
        } else {

            // *Make a simple format for count from query become like String "SideA,Value,SideB"
            $arrSubcategoryComparA = [];
            foreach ($subcategoryComparA as $key => $value) {
                $subcategoryIdA = $value['subcategory_id_a'];
                $subcategoryIdB = $value['subcategory_id_b'];
                $values = $value['value'];
                array_push($arrSubcategoryComparA, "$subcategoryIdA,$values,$subcategoryIdB");
            }
        }


        // *Get Eigen Value
        $eigen = $this->getEigen($arrSubcategoryComparA, $count);
        // *Save eigen value in database  
        foreach ($eigen as $key => $value) {
            $arrExplode = explode(',', $value);
            SubCategoryComparM::where([['subcategory_id_a', '=', (int) $arrExplode[0]], ['subcategory_id_b', '=', (int) $arrExplode[2]], ['category_id', '=', $request->post('category_id')]])->update(['eigen_value' => (float) $arrExplode[1]]);
        }
        if ($request->post('category_id') == null) {
            return view('error.oops', ['msg' => 'Need resource ! back to menu before and repeat']);
        }

        // *Cek have subcateogry ? 
        $count = SubCategory::where([['is_compare', '=', '1'], ['category_id', '=', $request->post('category_id')]])->get()->count();
        $countC = SubCategoryComparM::where('category_id', $request->post('category_id'))->get()->count();

        if ($count < 2) {
            return view('error.oops', ['msg' => 'Please Add SubCategory Before']);
        } else if ($countC < 4) {
            return view('error.oops', ['msg' => 'Please compare subcategory before !']);
        }

        // *Query category compare value by order A side and B side
        $subcategoryComparB = SubCategoryComparM::where('category_id', $request->post('category_id'))->orderBy('subcategory_id_a', 'ASC')->orderBy('subcategory_id_b', 'ASC')->get();

        if (count($subcategoryComparB) == 0) {
            return view('error.oops', ['msg' => 'Please compare subcategory before !']);
        } else {
            // *Make a format query from result query become  array [ [], [] ] for view 
            $inc = 0;
            $divider = 0;
            $arrSubcategoryComparB = [];
            foreach ($subcategoryComparB as $key => $value) {
                if ($inc  == $count) {
                    $inc = 0;
                    $divider++;
                }
                $arrSubcategoryComparB[$divider][$inc] = $value;

                $inc++;
            }
        }

        // *Count total and mean eigen value
        $inc = 0;
        $arrTotalEigen = [];
        $meanEigen = [];
        $totEigen = 0;
        foreach ($subcategoryComparB as $key => $value) {

            if ($inc == $count) {
                $inc = 0;
                array_push($arrTotalEigen, $totEigen);
                array_push($meanEigen, $totEigen / $count);

                $totEigen = 0;
            }
            if ($key == (count($subcategoryComparB) - 1)) {
                $totEigen += (float) $value['eigen_value'];
                array_push($arrTotalEigen, $totEigen);
                array_push($meanEigen, $totEigen / $count);
            }


            $totEigen += (float) $value['eigen_value'];
            $inc++;
        }


          // *Make a query with order B side by id 
          $subcategoryComparA = SubCategoryComparM::where('category_id', $request->post('category_id'))->orderBy('subcategory_id_b', 'ASC')->get();
          if (count($subcategoryComparA) < 4) {
              return redirect()->to('error.oops', ['msg' => 'Please repeat compare subcategory']);
          } else {
  
              // *Make a simple format for count from query become like String "SideA,Value,SideB"
              $arrSubcategoryComparA = [];
              foreach ($subcategoryComparA as $key => $value) {
                  $subcategoryIdA = $value['subcategory_id_a'];
                  $subcategoryIdB = $value['subcategory_id_b'];
                  $values = $value['value'];
                  array_push($arrSubcategoryComparA, "$subcategoryIdA,$values,$subcategoryIdB");
              }
          }
          
        //   *Get Total Compare
          $tempA = '';
          $totalComparA = [];
          $totalTemp = 0;
          foreach ($arrSubcategoryComparA as $key => $value) {
              $arrExplode = explode(',', $value);
  
              if ($tempA == $arrExplode[2]) {
                  $totalTemp += (float) $arrExplode[1];
                  if ($key == (count($arrSubcategoryComparA) - 1)) {
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

        // //   *Get Lamda Max
        //   $lMax = 0;
        // foreach ($meanEigen as $key => $value) {
        //    $lMax += ($meanEigen[$key]*$totalComparA[$key]);
        // }
       
        // // *Count CI value
        // if($lMax - $count == 0){
        //     $ci = 0;
        // }else{

        //     $ci = ($lMax - $count) / ($count - 1);
        // }
         
       
        // *Save final score to table subcategory
        $subcategories = SubCategory::where([['is_compare', '1'], ['category_id', $request->post('category_id')]])->orderBy('id', 'ASC')->get();
        foreach ($subcategories as $key => $subcategory) {
            $subcategory->update(['final_score' => $meanEigen[$key]]);
        }
        $id = $request->post('category_id');

        return redirect()->to("/admin/subcategory/compar/list/2?category_id=$id");
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

    public function listSubCategoryC1()
    {
        $categories = $this->getCategories();
        return view('admin.subcategory.subcategory_compar_list_1', ['view' => $this->view, 'categories' => $categories]);
    }
    public function listSubCategoryC2(Request $request)
    {
        if ($request->get('category_id') == null) {
            return view('error.oops', ['msg' => 'Need resource ! back to menu before and repeat']);
        }

        // *Cek have subcateogry ? 
        $count = SubCategory::where([['is_compare', '=', '1'], ['category_id', '=', $request->get('category_id')]])->get()->count();
        $countC = SubCategoryComparM::where('category_id', $request->get('category_id'))->get()->count();

        if ($count < 2) {
            return view('error.oops', ['msg' => 'Please Add  & Compare SubCategory Before']);
        } else if ($countC < 4) {
            return view('error.oops', ['msg' => 'Please compare subcategory before !']);
        }

        // *Query category compare value by order A side and B side
        $subcategoryComparB = SubCategoryComparM::where('category_id', $request->get('category_id'))->orderBy('subcategory_id_a', 'ASC')->orderBy('subcategory_id_b', 'ASC')->get();

        if (count($subcategoryComparB) == 0) {
            return view('error.oops', ['msg' => 'Please compare subcategory before !']);
        } else {
            // *Make a format query from result query become  array [ [], [] ] for view 
            $inc = 0;
            $divider = 0;
            $arrSubcategoryComparB = [];
            foreach ($subcategoryComparB as $key => $value) {
                if ($inc  == $count) {
                    $inc = 0;
                    $divider++;
                }
                $arrSubcategoryComparB[$divider][$inc] = $value;

                $inc++;
            }
        }

        // *Count total and mean eigen value
        $inc = 0;
        $arrTotalEigen = [];
        $meanEigen = [];
        $totEigen = 0;
        foreach ($subcategoryComparB as $key => $value) {

            if ($inc == $count) {
                $inc = 0;
                array_push($arrTotalEigen, $totEigen);
                array_push($meanEigen, $totEigen / $count);

                $totEigen = 0;
            }
            if ($key == (count($subcategoryComparB) - 1)) {
                $totEigen += (float) $value['eigen_value'];
                array_push($arrTotalEigen, $totEigen);
                array_push($meanEigen, $totEigen / $count);
            }


            $totEigen += (float) $value['eigen_value'];
            $inc++;
        }


          // *Make a query with order B side by id 
          $subcategoryComparA = SubCategoryComparM::where('category_id', $request->post('category_id'))->orderBy('subcategory_id_b', 'ASC')->get();
          if (count($subcategoryComparA) < 4) {
              return redirect()->to('error.oops', ['msg' => 'Please repeat compare subcategory']);
          } else {
  
              // *Make a simple format for count from query become like String "SideA,Value,SideB"
              $arrSubcategoryComparA = [];
              foreach ($subcategoryComparA as $key => $value) {
                  $subcategoryIdA = $value['subcategory_id_a'];
                  $subcategoryIdB = $value['subcategory_id_b'];
                  $values = $value['value'];
                  array_push($arrSubcategoryComparA, "$subcategoryIdA,$values,$subcategoryIdB");
              }
          }
          
        //   *Get Total Compare
          $tempA = '';
          $totalComparA = [];
          $totalTemp = 0;
          foreach ($arrSubcategoryComparA as $key => $value) {
              $arrExplode = explode(',', $value);
  
              if ($tempA == $arrExplode[2]) {
                  $totalTemp += (float) $arrExplode[1];
                  if ($key == (count($arrSubcategoryComparA) - 1)) {
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

        // //   *Get Lamda Max
        //   $lMax = 0;
        // foreach ($meanEigen as $key => $value) {
        //    $lMax += ($meanEigen[$key]*$totalComparA[$key]);
        // }
       
        // // *Count CI value
        // if($lMax - $count == 0){
        //     $ci = 0;
        // }else{

        //     $ci = ($lMax - $count) / ($count - 1);
        // }
         
       
        // *Save final score to table subcategory
        $subcategories = SubCategory::where([['is_compare', '1'], ['category_id', $request->get('category_id')]])->orderBy('id', 'ASC')->get();
        foreach ($subcategories as $key => $subcategory) {
            $subcategory->update(['final_score' => $meanEigen[$key]]);
        }
        // *Return view
        return view('admin.subcategory.subcategory_compar_list_2', ['subcategories' => SubCategory::where([['is_compare', '1'], ['category_id', $request->get('category_id')]])->orderBy('id', 'ASC')->get(), 'subcategory_compar' => $arrSubcategoryComparB, 'total_eigen' => $arrTotalEigen, 'mean_eigen' => $meanEigen]);
    }


    public function subcategoryComparEditV(Request $request)
    {
        if ($request->get('category_id') == null) {
            return view('error.oops', ['msg' => 'Need resource ! back to menu before and repeat']);
        }
        // *Cek have subcateogry ? 
        $count = SubCategory::where([['is_compare', '=', '1'], ['category_id', '=', $request->get('category_id')]])->get()->count();
        $countC = SubCategoryComparM::where('category_id', $request->get('category_id'))->get()->count();

        if ($count < 2) {
            return view('error.oops', ['msg' => 'Please Add SubCategory Before']);
        } else if ($countC < 4) {
            return view('error.oops', ['msg' => 'Please compare subcategory before !']);
        }


        $subcategory = SubCategory::where([['is_compare','=', '1'],['category_id','=',$request->get('category_id')]])->orderBy('id','ASC')->get();
        $tempC = [];
        $arrCompareEdit = [];

        $category = Category::where('id',$request->post('category_id'))->first();
        foreach ($subcategory as $key => $value) {
            array_push($tempC, $value['subcategory_name']);
            foreach ($subcategory as $key2 => $value2) {
                if ($value['subcategory_name'] != $value2['subcategory_name'] && !in_array($value2['subcategory_name'], $tempC)) {
                    array_push($arrCompareEdit, SubCategoryComparM::where(['subcategory_id_a' => $value['id'], 'subcategory_id_b' => $value2['id']])->first());
                }
            }
        }

        return view('admin.subcategory.subcategory_compar_edit', ['view' => $this->view, 'arrCompareEdit' => $arrCompareEdit,'category' => $category]);
        

    }
    public function editSubCategoryCompar(SubCategoryCompar $request){
        $validated = $request->validated();
     
        foreach ($validated as $key => $value) {
            if (preg_match("/subcategory_compar_[0-9]/", $key)) {
                $arrExplode = explode(',', $value);
                SubCategoryComparM::where(['subcategory_id_a' => (int) $arrExplode[0], 'subcategory_id_b' => (int)$arrExplode[2]])->update(['value' => strval((int) $arrExplode[1])]);
                SubCategoryComparM::where(['subcategory_id_a' => (int) $arrExplode[2], 'subcategory_id_b' => (int)$arrExplode[0]])->update(['value' => strval(1 / (float) $arrExplode[1])]);
            }
        }
        // *Make a query with order B side by id 
        $subcategoryComparA = SubCategoryComparM::orderBy('subcategory_id_B', 'ASC')->get();
        if (count($subcategoryComparA) < 4) {
            return redirect()->to('error.oops', ['msg' => 'Please repeat compare subcategory']);
        } else {

            // *Make a simple format for count from query become like String "SideA,Value,SideB"
            $arrSubcategoryComparA = [];
            foreach ($subcategoryComparA as $key => $value) {
                $subcategoryIdA = $value['subcategory_id_a'];
                $subcategoryIdB = $value['subcategory_id_b'];
                $values = $value['value'];
                array_push($arrSubcategoryComparA, "$subcategoryIdA,$values,$subcategoryIdB");
            }
        }
         // *Cek have subcateogry ? 
         $count = SubCategory::where([['is_compare','=', '1'],['category_id','=',$request->post('category_id')]])->get()->count();

         if ($count < 2) {
             return redirect()->to('/error/oops', ['msg' => 'Please Add Category Before']);
         }

          // *Get Eigen Value
        $eigen = $this->getEigen($arrSubcategoryComparA, $count);
        // *Save eigen value in database  
        foreach ($eigen as $key => $value) {
            $arrExplode = explode(',', $value);
            SubCategoryComparM::where([['subcategory_id_a', '=', (int) $arrExplode[0]], ['subcategory_id_b', '=', (int) $arrExplode[2]]])->update(['eigen_value' => (float) $arrExplode[1]]);
        }
        $id = $request->post('category_id');
        return redirect()->to("/admin/subcategory/compar/list/2?category_id=$id");
    }
}
