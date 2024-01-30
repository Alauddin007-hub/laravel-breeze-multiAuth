<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $data['title'] = "Login";
        return view('admin.login',$data);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin_login_form');
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }
}
