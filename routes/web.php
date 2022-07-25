<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Frontend\UserController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
    return view('welcome');
});

//.......Admin All Routes.........

Route::group(['prefix' => 'admin', 'middleware'=>['admin:admin']],function (){


    Route::get('/login',[AdminController::class,'loginForm'] );
    Route::post('/login1', [AdminController::class,'store'])->name('admin.login');


});

Route::middleware([
    'auth:sanctum,admin', config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    });
});



Route::get('/admin/logout',[AdminController::class, 'destroy'])->name('admin.logout');

Route::controller(AdminProfileController::class)->group(function (){

    Route::get('/admin/profile','adminProfile')->name('admin.profile');
    Route::get('/admin/profile/edit','adminProfileEdit')->name('admin.profile.edit');
    Route::post('/admin/profile/update','adminProfileUpdate')->name('admin.profile.update');
    Route::get('/admin/password/change', 'adminChangePassword')->name('admin.change.password');
    Route::post('/admin/password/update', 'adminUpdatePassword')->name('update.change.password');


});

// ................User All Route................

Route::middleware([
    'auth:sanctum,web', config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('dashboard',compact('user'));
    })->name('dashboard');
});

Route::controller(UserController::class)->group(function(){

    Route::get('/', 'index');
    Route::get('/user/logout', 'userLogout')->name('user.logout');
    Route::get('/user/profile', 'userProfile')->name('user.profile');
    Route::post('/user/profile/store', 'userProfileStore')->name('user.profile.store');
    Route::get('/user/change/password', 'userChangePassword')->name('change.password');
    Route::post('/user/update/password', 'userUpdatePassword')->name('user.password.update');

});
