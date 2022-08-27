<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryCompar;
use App\Models\AlternativeData;
use App\Models\Category;
use App\Models\CategoryComparM;
use App\Models\Mahasiswa;
use App\Models\SubCategory;
use App\Models\SubCategoryComparM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboardView(){
        $data = [];
        $data['category'] = Category::get()->count();
        $data['subcategory'] = SubCategory::get()->count();
        $data['mahasiswa'] = Mahasiswa::where('user_id',Auth::id())->get()->count();

        $mahasiswas = Mahasiswa::where('user_id', Auth::id())->orderBy('id', 'ASC')->get();
        if (count($mahasiswas) < 1) {
           $data['result'] = [];
        }else{

            
                    $arrRangking = [];
                    $arrTemp = [];
                    $totalTemp = 0;
                    foreach ($mahasiswas as $key => $value) {
                        $totalTemp = 0;
                        foreach ($value->alternativeData as $key => $item) {
                            if (count($value->alternativeData) < 1) {
                                $totalTemp = 0;
                            } else {
            
                                $totalTemp += ((float) $item->subcategory->final_score * (float)$item->subcategory->category->final_score);
                            }
                        }
                        array_push($arrRangking, ['mahasiswa' => $value, 'total_score' => $totalTemp]);
                        array_push($arrTemp, $totalTemp);
                    }
                    $arrSortedTemp = $arrTemp;
                    sort($arrSortedTemp);
                    $arrSortedTemp = array_reverse($arrSortedTemp);
            
                    $arrRanknull = [];
                    foreach ($arrRangking as $key => $value) {
                        if ($arrRangking[$key]['total_score'] == 0) {
                            array_push($arrRanknull, $arrRangking[$key]);
                        }
                    }
            
                    $arrRankingFilter = [];
                    foreach ($arrSortedTemp as $key => $value) {
            
            
                        $key2 = array_search($value, $arrTemp);
            
                        $arrRankingFilter[$key] = $arrRangking[$key2];
                         unset($arrTemp[$key2]);
                        unset($arrRangking[$key2]);
                    }
            
            
                    foreach ($arrRankingFilter as $key => $value) {
                        if ($arrRankingFilter[$key]['total_score'] == 0) {
                            unset($arrRankingFilter[$key]);
                        }
                    }
            
                    array_push($arrRankingFilter, ...$arrRanknull);
                    $result = [];
                    foreach ($arrRankingFilter as $key => $value) {
                        array_push($result,$value);
                    }
            
            
                    $data['result'] = $result;
        }

        return view('dashboard',['data' => $data]);
    }


    public function listUser(){
        $users = User::get();

        return view('admin.user_list',['users' => $users]);
    }

    public function deleteUser(Request $request){
        if($request->post('user_id')){
            User::where('id',$request->post('user_id'))->delete();
            return redirect()->back()->with('success','Successfully Delete user');
        }
    }
    public function toAdmin(Request $request){
        
        if($request->post('user_id')){
            User::where('id',$request->post('user_id'))->update(['role_id' => 1]);
            return redirect()->back()->with('success','Successfully update user');
        }
    }
    public function appSettingV(){
        return view('admin.app_setting');
    }

    public function resetApp(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       AlternativeData::truncate();
       Mahasiswa::truncate();
       SubCategoryComparM::truncate();
       SubCategory::truncate();
       CategoryComparM::truncate();
       Category::truncate();
       DB::statement('SET FOREIGN_KEY_CHECKS=1;');

       return redirect()->back()->with('success','Successfully reset app');
    }
}
