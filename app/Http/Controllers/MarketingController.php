<?php

namespace App\Http\Controllers;

use App\Models\Marketing_officer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MarketingController extends Controller
{
    public function index()
    {
        $data['title'] = "Login";
        return view('marketing.login',$data);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        if(Auth::guard('marketing')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect()->route('marketing.dashboard');
        } else {
            return redirect()->route('marketing_login_form');
        }
    }

    public function dashboard()
    {
        return view('marketing.dashboard');
    }

    public function logout(Request $request){
        Auth::guard('marketing')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('marketing/login');
    }

    public function marketing_create()
    {
        return view('marketing.register');
    }

    public function marketing_store(Request $request)
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        $user = Marketing_officer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new($user));

        Auth::login($user);

        return redirect('marketing/dashboard');
    }
}
