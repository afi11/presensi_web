<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    
    public function showLoginForm() 
    {
        return view('auth.login');
    }

    public function post_login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
  
        $username = $request->username;
        $password = $request->password;
        
        $cek = User::where('username',$username);
        if($cek->count() > 0){
            $akun = $cek->first();
            if(Hash::check($password, $akun->password)){
                Session::put('userid',$akun->userid);
                Session::put('tipeakun',$akun->tipeakun);
                return redirect('/');
            }else{
                return redirect('login')->with("error","Periksa username & password anda");
            }
        }else{
            return redirect('login')->with("error","Periksa username & password anda");
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }


}
