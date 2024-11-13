<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin(){
        return view('login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' =>'required|email|max:255',
            'password' => 'required|min:4'
        ]);

        if($validator->passes()){
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if(Auth::attempt($credentials)){
                return redirect()->route('dashboard.index');
            }else{
                return redirect()->back()->with('error', 'Invalid email or password');
            }
        }else{
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
    }


    public function register(Request $request){
        //validator
        $validator = Validator::make($request->all(),[
            'email' =>'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:4',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->passes()){
            $user = new User();
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->save();

            return redirect()->route('auth.login.show')->with('success','You have successfully registered');

        }else{
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        
    }


    public function showRegister(){

        return view('register');
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('auth.login.show')->with('success','You have logged out successful');
    }
}
