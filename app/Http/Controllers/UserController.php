<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEdit;
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

        return view('dashboard');
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
