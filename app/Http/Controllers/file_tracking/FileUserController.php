<?php

namespace App\Http\Controllers\file_tracking;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Error;
use App\Models\FileUser;
use App\Models\OfficeDepartment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class FileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('fileuser')->user()->hasRole('Mid File User')) {

            $roles = Role::whereNotIn('name', ['Mid File User', 'Super Admin', 'Admin', 'Master File User'])->get();
            $employees = FileUser::where('department_id', Auth::guard('fileuser')->user()->department_id)->get();

            $department = Department::where('id', Auth::guard('fileuser')->user()->department_id)->where('active', true)->get();
        } else if (Auth::guard('fileuser')->user()->hasAnyRole(['Master File User', 'Super Admin', 'Admin'])) {
            $roles = Role::all();
            $employees = FileUser::get();

            $department = Department::where('active', true)->get();
        }
        $designation = Designation::where('active', true)->get();
        return view('filetrack.file_user', compact('employees', 'roles', 'department', 'designation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Log::info('request'.json_encode($request->all()));
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'nullable',
            'phone' => 'nullable',
            'email' => 'required',
            'pic' => 'image|nullable',
            'roleid' => 'required',
            'depoff' => 'required'
        ]);
        try {
            $fpic = '';
            if ($request->hasFile('pic')) {
                $fpic = $request->pic->store('fileuser', 'public');
            }
            $defaultPassword = '12345';
            $hashpassword = Hash::make($defaultPassword);
            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $hashpassword,
                'off_dep_id' => $request->depoff,
                'pic' => $fpic,
                'department_id' => $request->depoff,
                'branch_id' => $request->branch,
                'desigantion_id' => $request->designation,
            ];
            $role = Role::find($request->roleid);
            $res = FileUser::create($data);
            if ($res) {
                $res->assignRole($role->name);
                session()->flash('success', 'User Added Sucessfully');
            } else {
                session()->flash('error', 'User not added ');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('filetrack.user-profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::all();
        $employees = FileUser::get();
        $id = Crypt::decrypt($id);
        $editemployee = FileUser::find($id);
        if ($editemployee) {
            return view('filetrack.file_user', compact('employees', 'editemployee', 'roles'));
        } else {
            session::flash('error', 'Something Went Wrong OR Data is Deleted');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Log::info('update'.json_encode($request->all()));
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'nullable',
            'phone' => 'nullable',
            'email' => 'required',
            'pic' => 'image|nullable',
            'roleid' => 'required'
        ]);
        try {
            if ($request->hasFile('pic')) {
                $fpic = $request->pic->store('fileuser', 'public');
                $user = FileUser::find($id);
                if ($user->pic && str_starts_with($user->pic, 'upload/')) {
                    File::delete(public_path($user->pic));
                } else if ($user->pic) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->pic);
                }
                $user->update(['pic' => $fpic]);
            }
            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'off_dep_id' => $request->depoff,
            ];
            $role = Role::find($request->roleid);
            $res = FileUser::find($id)->update($data);

            if ($res) {
                FileUser::find($id)->syncRoles($role->name);
                session()->flash('success', 'User updated Sucessfully');
            } else {
                session()->flash('error', 'User not updated ');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $res = FileUser::find($id)->delete();
            if ($res) {
                session()->flash('success', 'User deleted sucessfully');
            } else {
                session()->flash('error', 'User not deleted ');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }

    public function changePassword()
    {
        return view('filetrack.change-password');
    }

    public function updateProfile(Request $request)
    {
        Log::info('update' . json_encode($request->all()));
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'nullable',
            'phone' => 'nullable',
            'email' => 'required',
            'pic' => 'image|nullable'
        ]);
        try {
            if ($request->hasFile('pic')) {
                $emppic = $request->pic->store('fileuser', 'public');
                $user = FileUser::find($request->id);
                if ($user->pic && str_starts_with($user->pic, 'upload/')) {
                    File::delete(public_path($user->pic));
                } else if ($user->pic) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->pic);
                }
                $user->update(['pic' => $emppic]);
            }
            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email
            ];
            $res = FileUser::find($request->id)->update($data);
            if ($res) {
                session()->flash('success', 'User updated Sucessfully');
            } else {
                session()->flash('error', 'User not updated ');
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'cnew_password' => 'required'
        ]);
        try {
            if ($request->new_password == $request->cnew_password) {
                $user = FileUser::find($request->id);
                if (Hash::check($request->current_password, $user->password)) {
                    $res = FileUser::find($request->id)->update(['password' => Hash::make($request->new_password)]);
                    if ($res) {
                        session()->flash('success', 'Password changed Sucessfully');
                        return redirect()->back();
                    } else {
                        session()->flash('error', 'Password not changed ');
                        return redirect()->back();
                    }
                } else {
                    session()->flash('error', 'Incorrect current password');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Password did not matched ');
                return redirect()->back();
            }
        } catch (Exception $ex) {
            $url = URL::current();
            Error::create(['url' => $url, 'message' => $ex->getMessage()]);
            Session::flash('error', 'Server Error ');
        }
        return redirect()->back();
    }

    public function get_branch(Request $req)
    {
        $branch = Branch::where('active', true)->where('department_id', $req->dep_id)->get();
        $op = '<option value="">--Select Branch--</option>';
        foreach ($branch as $b) {
            $op .= '<option value="' . $b->id . '">' . $b->name . '</option>';
        }
        return $op;
    }
}
