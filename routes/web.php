<?php

use App\Http\Controllers\file_tracking\AdminController;
use App\Http\Controllers\file_tracking\FileController;
use App\Http\Controllers\file_tracking\FileUserController;
use App\Http\Controllers\file_tracking\PermissionController;
use App\Http\Controllers\file_tracking\RoleController;
use App\Http\Controllers\LetterController;
use App\Models\FileUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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




Route::group(['prefix' => 'filetracking', 'as' => 'filetrack.', 'middleware' => 'auth:fileuser'], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    Route::resource('fileuser', FileUserController::class);
    Route::resource('file-generate', FileController::class);
    Route::get('track-file/{id}', [FileController::class, 'trackingFile'])->name('trackingFile');
    Route::get('file-old', [FileController::class, 'oldfile'])->name('add-old');
    Route::post('file-old-save', [FileController::class, 'storeold'])->name('storeold');
    Route::get('file-generate-showAll', [FileController::class, 'showAllFiles'])->name('show-all');
    Route::get('generated-files', [FileController::class, 'generatedFiles'])->name('generated-Files');
    Route::post('file-transfer', [FileController::class, 'transfer_file'])->name('file-transfer');
    Route::get('pending-files', [FileController::class, 'pending_files'])->name('pending-files');
    Route::get('arriving-files', [FileController::class, 'arriving_files'])->name('arriving-files');
    Route::post('file-accept', [FileController::class, 'accept_reject_file'])->name('file-accept');
    Route::get('file-search', [FileController::class, 'file_search'])->name('file-search');
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::get('user-permission', [PermissionController::class, 'userPermission'])->name('userPermission');
    Route::post('assign-permission', [PermissionController::class, 'assignPermission'])->name('assignPermission');
    Route::get('roles-has-permission', [PermissionController::class, 'roleHasPermission'])->name('roleHasPermission');
    Route::get('view-role/{id}', [RoleController::class, 'viewRole'])->name('viewRole');
    Route::get('change-password', [FileUserController::class, 'changePassword'])->name('fileuser.changepassword');
    Route::post('update-profile', [FileUserController::class, 'updateProfile'])->name('fileuser.updateProfile');
    Route::post('update-password', [FileUserController::class, 'updatePassword'])->name('fileuser.updatePassword');
    Route::post('get-branch', [FileUserController::class, 'get_branch'])->name('get-branch');
    Route::get('notification-read/{id}', [FileController::class, 'notice_read'])->name('notification-read');
    // Letter routes
    Route::get('letter-dispatch', [LetterController::class, 'letter_dispatch_list'])->name('letter-dispatch');
    Route::get('letter-dispatch-create', [LetterController::class, 'letter_dispatch_create'])->name('letter-dispatch-create');
    Route::post('letter-dispatch-store', [LetterController::class, 'store_letter_dispatch'])->name('store-dispatch-file');
    Route::get('letter-receive', [LetterController::class, 'letter_receive'])->name('letter-receive');
    Route::post('letter-receive', [LetterController::class, 'store_letter_receive'])->name('store-receive-file');
    Route::post('add-letter-dispatch-user', [LetterController::class, 'add_letter_dispatch_user'])->name('new-letter-dispatch-user');
    Route::get('letter/{id}', [LetterController::class, 'letter_view'])->name('letter-view');



});

Route::get('/optimize', function () {
    Artisan::call('optimize');
});
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
});
Route::post('/login', [AdminController::class, 'login'])->name('login');

Route::get('/assign', function () {
    $user = FileUser::find(2);
    if ($user->assignRole('Superadmin')) {
        return 'Role assigned successfully';
    }

});
Route::post('/file-store', [FileController::class, 'store'])->name('file-store');
// Route::get('assign',function(){
//     $role=Role::first();
//     $role->givePermissionTo(Permission::all());
// });
