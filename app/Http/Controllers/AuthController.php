<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function validateError()
    {
        if(isset($validator) && $validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }
    }
    public function login()
    {
        if(Auth::check()) { return redirect('/'); }
        return view('auth.login', [
            //
        ]);
    }
    public function register()
    {
        if(Auth::check()) { return redirect('/'); }
        return view('auth.register', [
            //
        ]);
    }
    public function store(StoreUserRequest $request)
    {
        $this->validateError();
        $user = User::create([
            "email" => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'Registered successfully!',
            'user' => $user,
        ], 200);
    }
    public function authenticate(Request $request)
    {
        $remember = ($request->remember == 'true') ? true : false;
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(Auth::attempt([
                'email' => $request->email, 'password' => $request['password']
            ], $remember)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
        } else {
            if(Auth::attempt([
                'name' => $request->email, 'password' => $request['password']
            ], $remember)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
        }
        return back()->with('error', 'Your email or password is incorrect!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
