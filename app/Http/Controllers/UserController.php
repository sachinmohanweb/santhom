<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    
    public function admin_index() : View
    {
        return view('index',[]);
    }

    public function admin_login(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = false;

        if($request['remember_password']){
            $remember = true;
        }

        if (Auth::guard('admin')->attempt($credentials,$remember)) {
            
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        else{

            return redirect()->route('index')->withErrors(['message' => 'Incorrect Credentials']);
        }
    }

    public function admin_logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/')->with('success', 'You have been successfully logged out.');
    }

    public function admin_dashboard() : View
    {
        return view('dashboard.index',[]);
    }

    public function admin_family_list() : View
    {
        return view('user.family.index',[]);
    }

    public function admin_family_members_list() : View
    {
        return view('user.members.index',[]);
    }

}
