<?php

namespace App\Http\Controllers\file_tracking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::guard('fileuser')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember_me))
        {
            session()->flash('success','Welcome Admin !');
            return redirect()->route('filetrack.dashboard');
        }
        else {
            session()->flash('error','Invalid Username or Password !');
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        session()->flash('success','Logout Successfully !');
        return redirect('/');
    }

    public function dashboard()
    {
        return view('filetrack.dashboard');
    }
}
