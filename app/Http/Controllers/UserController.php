<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEdit;
use App\Models\Category;
use App\Models\Mahasiswa;
use App\Models\SubCategory;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Whoops\Run;

class UserController extends Controller
{
    public function dashboardView()
    {

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

    public function profileV()
    {
        $user = User::where('id', Auth::id())->first();

        return view('user.profile.user_profile', ['user' => $user]);
    }

    public function profileEditV()
    {
        $user = User::where('id', Auth::id())->first();

        return view('user.profile.user_edit', ['user' => $user]);
    }
    public function profileEdit(ProfileEdit $request)
    {
        $date = strtotime('now');
        $file = $request->file('userimage')->getClientOriginalName();
        $imageName =  "$date$file" ;
        
        User::where('id', Auth::id())->update(['name' => $request->post('username'), 'image' => $imageName]);

       $request->file('userimage')->move(public_path('image'),$imageName);

        return redirect()->to('/profile')->with('success','Successfully edit profile');
    }

    public function changePasswordV(){
        return view('user.profile.change_password');
    }

    public function changePassword(Request $request){
        $request->validate(["old_password" => 'required','new_password' => 'required']);
    
        if(Hash::check($request->post('old_password'),Auth::user()->password)){
          
            $newPassword = Hash::make($request->post('new_password'));
            User::where('id',Auth::id())->update([
                'password' => $newPassword
            ]);
            return redirect()->to('/logout')->with('success','Please login use new password');
        }else{
            return redirect()->back()->with('error','Wrong old password');
        }



    }
}
