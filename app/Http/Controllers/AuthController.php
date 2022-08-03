<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerView()
    {
        return view('auth.register');
    }

    public function  getInputRegister(RegisterRequest $request)
    {
        /*

        */
        $validated = $request->validated();
        return $this->doRegister($validated['username'], $validated['password']);
    }
    public function doRegister($username, $password)
    {
        User::create([
            'username' => $username,
            'password' => Hash::make($password)
        ]);

        return redirect()->back()->with('success', 'Register Successfully');
    }
}
