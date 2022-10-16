<?php

namespace App\Http\Controllers\file_tracking;

use App\Http\Controllers\Controller;
use App\Models\DocumentFile;
use App\Models\FileUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::guard('fileuser')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember_me))
        {
            $welcomeMessage = 'Welcome '. Auth::guard('fileuser')->user()->first_name. ' !';
            session()->flash('success', $welcomeMessage);
            return redirect()->route('filetrack.dashboard');
        }
        else {
            session()->flash('error','Invalid Username or Password !');
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::guard('fileuser')->logout();
        Session::flush();
        session()->flash('success','Logout Successfully !');
        return redirect('/');
    }

    public function dashboard()
    {
        $users=0;
        $todayfile=0;
        $monthfile=0;
        $weekfile=0;
        if(Auth::guard('fileuser')->user()->hasAnyRole(['Master File User','Admin','Super Admin'])){
            $users=FileUser::count();
            $todayfile=DocumentFile::where('created_at',Carbon::today())->count();
            $monthfile=DocumentFile::whereMonth('created_at',Carbon::now()->month)->count();
            $weekfile=DocumentFile::whereBetween('created_at', [Carbon::now()->startOfWeek(Carbon::SUNDAY), Carbon::now()->endOfWeek(Carbon::SATURDAY)])->count();
        }
        else if(Auth::guard('fileuser')->user()->hasRole('Mid File User')){
            $users=FileUser::where('department_id',Auth::guard('fileuser')->user()->department_id)->count();
            $todayfile=DocumentFile::where('file_type_main_id',Auth::guard('fileuser')->user()->dep_off_id)->where('created_at',Carbon::today())->count();
            $monthfile=DocumentFile::where('file_type_main_id',Auth::guard('fileuser')->user()->dep_off_id)->whereMonth('created_at',Carbon::now()->month)->count();
            $weekfile=DocumentFile::where('file_type_main_id',Auth::guard('fileuser')->user()->dep_off_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(Carbon::SUNDAY), Carbon::now()->endOfWeek(Carbon::SATURDAY)])->count();
        }

        

        return view('filetrack.dashboard',compact('users','todayfile','monthfile','weekfile'));
    }
}
