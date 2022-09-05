<?php


use App\Http\Controllers\Backend\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Models\User;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;

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
    })->name('admin.dashboard')->middleware('auth:admin');
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

// Admin Brand All Route..............

Route::controller(BrandController::class)->prefix('brand')->group(function(){
    Route::get('/view', 'brandView')->name(('all.brand'));
    Route::post('/store', 'brandStore')->name(('brand.store'));
    Route::get('/edit/{id}', 'brandEdit')->name(('brand.edit'));
    Route::get('/delete/{id}', 'brandDelete')->name(('brand.delete'));
    Route::post('/update', 'brandUpdate')->name(('brand.update'));
});

// Admin Category All Route..............

    Route::controller(CategoryController::class)->prefix('category')->group(function(){
    Route::get('/view', 'categoryView')->name('all.category');
    Route::post('/store', 'categoryStore')->name(('category.store'));
    Route::get('/edit/{id}', 'categoryEdit')->name(('category.edit'));
    Route::get('/delete/{id}', 'categoryDelete')->name(('category.delete'));
    Route::post('/update', 'categoryUpdate')->name('category.update');


});

// Admin Sub-Category All Route..............

Route::controller(SubCategoryController::class)->prefix('category/sub')->group(function(){
Route::get('/view', 'subCategoryView')->name('all.subcategory');
Route::post('/store', 'subCategoryStore')->name(('subcategory.store'));
Route::get('/edit/{id}', 'subCategoryEdit')->name(('subcategory.edit'));
Route::post('/update', 'subCategoryUpdate')->name(('subcategory.update'));
Route::get('/delete/{id}', 'subCategoryDelete')->name(('subcategory.delete'));

// Admin Sub->SubCategory All Route...............

    Route::get('/sub/view', 'subSubCategoryView')->name('all.subsubcategory');
    Route::post('/sub/store', 'subSubCategoryStore')->name(('subsubcategory.store'));
    Route::get('/sub/edit/{id}', 'subSubCategoryEdit')->name(('subsubcategory.edit'));
    Route::post('/sub/update', 'subSubCategoryUpdate')->name(('subsubcategory.update'));
    Route::get('/sub/delete/{id}', 'subSubCategoryDelete')->name(('subsubcategory.delete'));


});

Route::get('/category/subcategory/ajax/{category_id}' , [SubCategoryController::class, 'getSubcategory']);

// Sub-Sub-Category

Route::get('/category/sub-subcategory/ajax/{subcategory_id}' , [SubCategoryController::class, 'getSubSubCategory']);

// Admin Product All Route..............

Route::controller(ProductController::class)->prefix('product')->group(function(){
    Route::get('/add', 'addProduct')->name('all.product');
    Route::post('/store', 'storeProduct')->name('product-store');
    Route::get('/manage', 'manageProduct')->name('manage.product');
    Route::get('/edit/{id}', 'editProduct')->name('edit.product');
    Route::post('/update', 'updateProduct')->name('update.product');
    Route::post('/image/update', 'MultiImageUpdate')->name('update-product-image');
    Route::post('/thumbnail/update', 'thumbnailImageUpdate')->name('update-product-thumbnail');
    Route::get('/multiImg/delete/{id}', 'MultiImageDelete')->name('product.multiImg.delete');
    Route::get('/active/{id}', 'productActive')->name('product.active');
    Route::get('/inactive/{id}', 'productInactive')->name('product.inactive');
    Route::get('/delete/{id}', 'productDelete')->name('product.delete');

});

//Amdin slider All Route....

Route::controller(SliderController::class)->prefix('slider')->group(function(){
    Route::get('/view', 'SliderView')->name('manage.slider');
    Route::post('/store', 'sliderStore')->name('slider.store');
    Route::get('/edit/{id}', 'sliderEdit')->name('slider.edit');
    Route::post('/update', 'sliderUpdate')->name('slider.update');
    Route::get('/delete/{id}', 'sliderDelete')->name('slider.delete');
    Route::get('/active/{id}', 'sliderActive')->name('slider.active');
    Route::get('/inactive/{id}', 'sliderInactive')->name('slider.inactive');



});
// Frontend Language All Route/////
Route::controller(LanguageController::class)->group(function(){
Route::get('/language/hindi', 'hindi')->name('hindi.language');
Route::get('/language/english', 'english')->name('english.language');

});

//Product Details all Route

Route::controller(UserController::class)->group(function(){

Route::get('/product/details/{id}/{slug}', 'ProductDetails');

//product Tags route

Route::get('/product/tag/{tag}', 'tagWiseProduct');


//Product View Modal with ajax

Route::get('/product/view/modal/{id}', 'productViewAjax');

});




///.......Cart All Rpute.....


Route::controller(CartController::class)->group(function(){
// Add to Cart Store Data
Route::post('/cart/data/store/{id}', 'AddToCart');

// Get Data from mini cart
Route::get('/product/mini/cart/','AddMiniCart');

// Remove mini cart
Route::get('/minicart/product-remove/{rowId}','RemoveMiniCart');

// Add to Wishlist
Route::post('/add-to-wishlist/{product_id}', 'AddToWishlist');

// Frontend Coupon Option

Route::post('/coupon-apply', 'CouponApply');

Route::get('/coupon-calculation', 'CouponCalculation');

Route::get('/coupon-remove', 'CouponRemove');

});

Route::controller(WishlistController::class)->prefix('user')->middleware('user','auth')->group(function(){

// Wishlist Page

Route::get('/wishlist', 'viewWishlist')->name('wishlist');
Route::get('/get-wishlist-product', 'GetWishlistProduct');
Route::get('/wishlist-remove/{id}','removeWishlistProduct');

});
Route::middleware(['auth'])->group(function () {

Route::post('/stripe/order', [StripeController::class, 'StripeOrder'])->name('stripe.order');

});







// My Cart Page All Routes
Route::controller(CartPageController::class)->group(function(){

Route::get('/mycart','myCart')->name('mycart');
Route::get('/user/get-cart-product', 'getCartProduct');
Route::get('/user/cart-remove/{rowId}', 'removeCartProduct');
Route::get('/cart-increment/{rowId}', 'CartIncrement');
Route::get('/cart-decrement/{rowId}','CartDecrement');
});

// Admin Coupons All Routes

Route::controller(CouponController::class)->prefix('coupons')->group(function(){

    Route::get('/view', 'CouponView')->name('manage-coupon');

    Route::post('/store',  'CouponStore')->name('coupon.store');

    Route::get('/edit/{id}',  'CouponEdit')->name('coupon.edit');
    Route::post('/update/{id}' , 'CouponUpdate')->name('coupon.update');

    Route::get('/delete/{id}',  'CouponDelete')->name('coupon.delete');

    });

    // Admin Shipping All Routes

Route::controller(ShippingAreaController::class)->prefix('shipping')->group(function(){

    // Ship Division
    Route::get('/division/view', 'DivisionView')->name('manage-division');

    Route::post('/division/store', 'DivisionStore')->name('division.store');

    Route::get('/division/edit/{id}', 'DivisionEdit')->name('division.edit');

    Route::post('/division/update/{id}', 'DivisionUpdate')->name('division.update');

    Route::get('/division/delete/{id}', 'DivisionDelete')->name('division.delete');



// Ship District

Route::get('/district/view', 'DistrictView')->name('manage-district');

Route::post('/district/store', 'DistrictStore')->name('district.store');

Route::get('/district/edit/{id}', 'DistrictEdit')->name('district.edit');

Route::post('/district/update/{id}', 'DistrictUpdate')->name('district.update');

Route::get('/district/delete/{id}', 'DistrictDelete')->name('district.delete');

// Ship State
Route::get('/state/view', 'StateView')->name('manage-state');

Route::post('/state/store', 'StateStore')->name('state.store');

Route::get('/state/edit/{id}', 'StateEdit')->name('state.edit');

Route::post('/state/update/{id}', 'StateUpdate')->name('state.update');

Route::get('/state/delete/{id}', 'StateDelete')->name('state.delete');

});

// Checkout Routes

Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');
Route::get('/district-get/ajax/{division_id}', [CheckoutController::class, 'DistrictGetAjax']);
Route::get('/state-get/ajax/{district_id}', [CheckoutController::class, 'StateGetAjax']);
Route::post('/checkout/store', [CheckoutController::class, 'CheckoutStore'])->name('checkout.store');


