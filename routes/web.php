<?php

use App\Http\Controllers\file_tracking\AdminController;
use App\Http\Controllers\file_tracking\FileController;
use App\Http\Controllers\file_tracking\FileUserController;
use App\Http\Controllers\file_tracking\PermissionController;
use App\Http\Controllers\file_tracking\RoleController;
use App\Models\FileUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::post('/login', [AdminController::class, 'login'])->name('login');




Route::group(['prefix'=>'filetracking','as'=>'filetrack.','middleware'=>'auth:fileuser'],function(){
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('logout',[AdminController::class,'logout'])->name('logout');
    Route::resource('fileuser',FileUserController::class);
    Route::resource('file-generate',FileController::class);
    Route::get('generated-files',[FileController::class,'generatedFiles'])->name('generated-Files');
    Route::post('file-transfer',[FileController::class,'transfer_file'])->name('file-transfer');
    Route::get('pending-files',[FileController::class,'pending_files'])->name('pending-files');
    Route::get('arriving-files',[FileController::class,'arriving_files'])->name('arriving-files');
    Route::post('file-accept',[FileController::class,'accept_reject_file'])->name('file-accept');
    Route::resource('role',RoleController::class);
    Route::resource('permission',PermissionController::class);
    Route::get('user-permission',[PermissionController::class,'userPermission'])->name('userPermission');
    Route::post('assign-permission',[PermissionController::class,'assignPermission'])->name('assignPermission');
    Route::get('roles-has-permission',[PermissionController::class,'roleHasPermission'])->name('roleHasPermission');
    Route::get('view-role/{id}',[RoleController::class,'viewRole'])->name('viewRole');
    Route::get('change-password',[FileUserController::class, 'changePassword'])->name('fileuser.changepassword');
    Route::post('update-profile',[FileUserController::class, 'updateProfile'])->name('fileuser.updateProfile');
    Route::post('update-password',[FileUserController::class, 'updatePassword'])->name('fileuser.updatePassword');


});

Route::get('/optimize', function(){
    Artisan::call('optimize');
});
Route::get('/optimize-clear', function(){
    Artisan::call('optimize:clear');
});
Route::post('/login', [AdminController::class, 'login'])->name('login');

Route::get('/assign', function(){
    $user= FileUser::find(2);
    if($user->assignRole('Superadmin')){
        return 'Role assigned successfully';
    }

});
Route::post('/file-store',[FileController::class,'store'])->name('file-store');
