<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;

class AuthController extends Controller
{





    public function registerView()
    {

        return view('auth.register');
    }

    public function loginView()
    {
        $roleUser = RoleUser::get();

        return view('auth.login', compact('roleUser'));
    }

    public function  getInputRegister(RegisterRequest $request)
    {
        /*

        */
        $validated = $request->validated();
        return $this->doRegister($validated['username'], $validated['password']);
    }
    private function doRegister($username, $password)
    {
        /*
            Register new user with role user
            Register for role admin only can created by admin
        */
        User::create([
            'name' => $username,
            'password' => Hash::make($password),
            'role_id' => RoleUser::where('role','User')->first()->id // get id  for role user
        ]);

        return redirect()->back()->with('success', 'Register Successfully');
    }

    public function getLoginInput(LoginRequest $request)
    {
        $validated = $request->validated();

        return $this->doLogin($validated['username'], $validated['password'], $validated['role_id']);
    }

    public function doLogin($username, $password, $roleId)
    {

        if (Auth::attempt(["name" => $username, "password" => $password, "role_id" => $roleId])) {


            return  $roleId == 1 ?  redirect()->to('/admin') : redirect()->to('/');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid Credential !');
        }
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
      
        return redirect()->to('/login');
    }
}
