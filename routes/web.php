<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminBarcodeController;
use App\Http\Controllers\Admin\AdminBranchController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminForcastController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminMctPayController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPromotionController;
use App\Http\Controllers\Admin\AdminReturnController;
use App\Http\Controllers\Admin\AdminShippingChargeController;
use App\Http\Controllers\Admin\AdminUserProfileController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminWalletController;
use App\Http\Controllers\Admin\AdminAffilateMarketingController;
use App\Http\Controllers\Admin\AdminMatchingBonusController;
use App\Http\Controllers\Admin\AdminDirectSponserController;
use App\Http\Controllers\Admin\AdminLeadershipBonusController;
use App\Http\Controllers\Admin\AdminWithDrawController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MLM\MLMDirectBonus;
use App\Http\Controllers\MLM\MLMMatchingBonusController;
use App\Http\Controllers\MLM\MLMRegisterController;
use App\Http\Controllers\MLM\MLMTreeController;
use App\Http\Controllers\MLM\MLMWithDrawController;
use App\Http\Controllers\MLM\MLMLoyalityPointsContoller;
use App\Http\Controllers\MLM\MLMLeadershipController;
use App\Http\Controllers\User\UserAddressController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserInvoiceController;
use App\Http\Controllers\User\UserCouponController;
use App\Http\Controllers\User\UserDeliveryChargeController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserPaymentController;
use App\Http\Controllers\User\UserProductsController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserPurchaseHistoryController;
use App\Http\Controllers\User\UserThanksController;
use App\Http\Controllers\User\UserWalletController;
use App\Http\Controllers\User\UserWelcomeController;
use App\Http\Controllers\User\UserWishlistController;
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



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



// for all country
use PragmaRX\Countries\Package\Countries;

Route::get('/country_list', function () {
    $countries = new Countries();
    $all = $countries->all()->pluck('name.common')->toArray();
    echo json_encode($all);
})->name('get_all_country');

Route::get('search_product', [UserWelcomeController::class, 'search_product'])->name('users.search_product');
Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::resource('/Dashboard', AdminDashboardController::class)->names([
        'index' => 'dashboard.index'
    ]);



    Route::post('/delete_warehouse', [AdminInventoryController::class, 'delete_ware_house'])->name('ware_house.delete');
    Route::post('/addWarehouse', [AdminInventoryController::class, 'addWarehouse'])->name('addWarehouse');
    Route::get('/showWareHouse', [AdminInventoryController::class, 'showWareHouse'])->name('showWareHouse');
    Route::post('/addRack', [AdminInventoryController::class, 'addRack'])->name('addRack');
    Route::get('/warehouse_with_rack', [AdminInventoryController::class, 'showRack'])->name('showRack');
    Route::get('/getAllWarehouseDetails', [AdminInventoryController::class, 'getAllWarehouseDetails'])->name('getAllWarehouseDetails');
    Route::get('/showeditinventory', [AdminInventoryController::class, 'showeditinventoryData'])->name('showeditinventoryData');
    Route::post('/updateInventory', [AdminInventoryController::class, 'updateInventory'])->name('updateInventory');
    Route::post('/inventory/delete', [AdminInventoryController::class, 'deleteInventory'])->name('inventory.delete');
    Route::resource('inventory', AdminInventoryController::class)->names([
        'index'     => 'inventory.index',
        'store'     => 'inventory.store',
        'create'    => 'inventory.create',
    ]);


    Route::get('/getReturnData', [AdminReturnController::class, 'showReturnDataById'])->name('return.showData');
    Route::post('/updateRetutn', [AdminReturnController::class, 'updateReturn'])->name('return.updateReturn');
    Route::post('/deleteRetutn', [AdminReturnController::class, 'deleteReturn'])->name('retutn.delete');
    Route::resource('product/return', AdminReturnController::class)->names([
        'index' => 'return.index',
        'store' => 'return.store',
        'create' => 'return.create'
    ]);


    Route::resource('forcast', AdminForcastController::class)->names([
        'index' => 'forcast.index'
    ]);


    Route::get('category/showEditData', [AdminCategoryController::class, 'showEditData'])->name('category.showEditData');
    Route::post('categoty/update', [AdminCategoryController::class, 'updateCategory'])->name('category.updateCategory');
    Route::post('/deleteCategory', [AdminCategoryController::class, 'deleteCategory'])->name('category.deleteCategory');
    Route::resource('category', AdminCategoryController::class)->names([
        'index' => 'category.index',
        'store' => 'category.store'
    ]);

    Route::post('/get_edit_data', [AdminProductController::class, 'get_edit_data'])->name('product.get_edit_data')->middleware('signed');
    Route::post('/deleteProduct', [AdminProductController::class, 'deleteProduct'])->name('product.deleteProduct');
    Route::get('ad_categoryList', [AdminProductController::class, 'categoryList'])->name('product.categoryList');
    Route::resource('/adminproduct', AdminProductController::class)->names([
        'index'  => 'product.index',
        'create' => 'product.create',
        'edit'   => 'product.edit',
        'store'  => 'product.store',
        'update' => 'products.update'
    ]);

    Route::get('/showEditData', [AdminBranchController::class, 'showEditData'])->name('branch.showEditData');
    Route::post('updateBranch', [AdminBranchController::class, 'updateBranch'])->name('branch.updateBranch');
    Route::post('deleteBranch', [AdminBranchController::class, 'deleteBranch'])->name('branch.delete');
    Route::resource('branch', AdminBranchController::class)->names([
        'index' => 'branch.index',
        'store' => 'branch.store'
    ]);



    // coupon 
    Route::post('/deleteCoupon', [AdminCouponController::class, 'deleteCoupon'])->name('coupon.delete');
    Route::resource('coupon', AdminCouponController::class)->names([
        'index'     => 'coupon.index',
        'store'     => 'coupon.store',
        'create'    => 'coupon.create',
    ]);
    // end coupon

    // shipping charge
    Route::post('/deleteShipc', [AdminShippingChargeController::class, 'deleteShipc'])->name('shipc.delete');
    Route::resource('shipping_charge', AdminShippingChargeController::class)->names([
        'index'     => 'shipc.index',
        'store'     => 'shipc.store',
        'create'    => 'shipc.create',
    ]);
    // end shipping charge

    // barcode
    Route::get('/show_Barcode', [AdminBarcodeController::class, 'index'])->name('barcode.index');
    Route::get('/barcodelist', [AdminBarcodeController::class, 'barcodeList'])->name('barcode.barcodeList');
    Route::get('barcodeImage', [AdminBarcodeController::class, 'barcodeImage'])->name('barcode.barcodeImage');
    Route::get('/barcodedownload', [AdminBarcodeController::class, 'download'])->name('barcode.download');
    Route::post('/get_barcode_product_details', [AdminBarcodeController::class, 'get_barcode_product_details'])->name('get_barcode_product_details')->middleware('signed');
    // end barcode

    // banner
    Route::post('/deleteBanner', [AdminBannerController::class, 'deleteBanner'])->name('banner.deleteBanner');
    Route::resource('banner', AdminBannerController::class)->names([
        'index'     => 'banner.index',
        'create'    => 'banner.create',
        'store'     => 'banner.store'
    ]);
    // end banner

    // user
    Route::post('/userDetails', [AdminUsersController::class, 'getUserDetails'])->name('users.getUserDetails');
    Route::post('/updateUser', [AdminUsersController::class, 'updateUser'])->name('users.updateUser');
    Route::post('/deleteUser', [AdminUsersController::class, 'deleteUser'])->name('users.deleteUser');
    Route::resource('user', AdminUsersController::class)->names([
        'index'  => 'users.index',
        'create' => 'users.create'
    ]);
    // end user

    // affilate marketing

    Route::resource('getmatchingbonusdetails', AdminMatchingBonusController::class)->names([
        'index'  => 'getmatchingbonusdetails.index',
        'create'  => 'getmatchingbonusdetails.create'
    ]);
    Route::resource('getdirectsponserdetails', AdminDirectSponserController::class)->names([
        'index'  => 'getdirectsponserdetails.index',
        'create'  => 'getdirectsponserdetails.create'
    ]);

    Route::any('/get_affilate_details', [AdminAffilateMarketingController::class, 'get_affilate_details'])->name('get_affilate_details');
    Route::any('/view_affilate_details', [AdminAffilateMarketingController::class, 'view_affilate_details'])->name('view_affilate_details');
    Route::any('/edit_affilate_details', [AdminAffilateMarketingController::class, 'edit_affilate_details'])->name('edit_affilate_details');
    Route::resource('affilatemarketing', AdminAffilateMarketingController::class)->names([
        'index'  => 'affilatemarketing.index',
        'create' => 'affilatemarketing.create',
    ]);
    Route::resource('getleadershipbonusdetails', AdminLeadershipBonusController::class)->names([
        'index'  => 'getleadershipbonusdetails.index',
        'create'  => 'getleadershipbonusdetails.create'
    ]);

    // end affilate marketing

    //start withdraw bonus
    //Route::get('/approvewithdraw', [AdminOrderController::class, 'approvewithdraw']);
    Route::get('/approvewithdraw', [AdminWithDrawController::class, 'approvewithdraw'])->name('approvewithdraw');
    Route::get('/view_user_details', [AdminWithDrawController::class, 'view_user_details'])->name('view_user_details');
    Route::resource('withdrawbonus', AdminWithDrawController::class)->names([
        'index'  => 'withdrawbonus.index',
        'create' => 'withdrawbonus.create'
    ]);
    // end withdraw bonus

    Route::resource('getleadershipbonusdetails', AdminLeadershipBonusController::class)->names([
        'index'  => 'getleadershipbonusdetails.index',
        'create'  => 'getleadershipbonusdetails.create'
    ]);

    // end affilate marketing

    //start withdraw bonus
    //Route::get('/approvewithdraw', [AdminOrderController::class, 'approvewithdraw']);
    Route::get('/approvewithdraw', [AdminWithDrawController::class, 'approvewithdraw'])->name('approvewithdraw');
    Route::resource('withdrawbonus', AdminWithDrawController::class)->names([
        'index'  => 'withdrawbonus.index',
        'create' => 'withdrawbonus.create'
    ]);
    // end withdraw bonus

	Route::resource('getleadershipbonusdetails', AdminLeadershipBonusController::class)->names([
	'index'  => 'getleadershipbonusdetails.index',
	'create'  => 'getleadershipbonusdetails.create'
	 ]);
	
	// end affilate marketing
	
	//start withdraw bonus
	//Route::get('/approvewithdraw', [AdminOrderController::class, 'approvewithdraw']);
	Route::get('/approvewithdraw', [AdminWithDrawController::class, 'approvewithdraw'])->name('approvewithdraw');
	Route::resource('withdrawbonus', AdminWithDrawController::class)->names([
        'index'  => 'withdrawbonus.index',
        'create' => 'withdrawbonus.create'
    ]);	
	// end withdraw bonus
	
    // order details
    Route::get('/download_invoice/{id}', [AdminOrderController::class, 'downloadInvoic'])->name('download.order.invoice');
    Route::get('/ad_order_detils/{id}', [AdminOrderController::class, 'show_order_details'])->name('show_order_details');
    Route::post('delete_order', [AdminOrderController::class, 'delete_Order'])->name('delete_order')->middleware('signed');
    Route::resource('ad_all_orders', AdminOrderController::class)->names([
        'index'     => 'orders.index',
        'create'    => 'orders.create',
        'store'     => 'orders.change_status'
    ])->middleware('signed');
    Route::resource('order', 'OrderController')->middleware('auth');
    // end order details

    // invoice
    Route::resource('invoice', AdminInvoiceController::class)->names([
        'show' => 'invoice.show'
    ]);
    // end invoice

    // start promotion
    Route::post('/delete_promotion_Banner', [AdminPromotionController::class, 'delete_Banner'])->name('promotion.delete_Banner')->middleware('signed');
    Route::resource('promotion', AdminPromotionController::class)->names([
        'index' => 'promotion.index',
        'store' => 'promotion.store',
        'create' => 'promotion.create'
    ])->middleware('signed');
    // end promotion

    // payment
    Route::get('payment_details/{id}', [AdminPaymentController::class, 'show'])->name('payment.show_details');
    Route::resource('payment', AdminPaymentController::class)->names([
        'index' => 'payment.index',
        'create' => 'payment.create',
        'store' => 'payment.store.approve'
    ])->middleware('signed');
    // end payment

    Route::get('ad_user_profile/{id}', [AdminUserProfileController::class, 'show'])->name('profile.show');

    Route::get('wallet/show_details', [AdminWalletController::class, 'show_details'])->name('wallet.show_details');
    Route::resource('wallet', AdminWalletController::class)->names([
        'index' => 'wallet.index',
        'store' => 'wallet.store'
    ])->middleware('signed');

    Route::get('mct_pay_show/{id}', [AdminMctPayController::class, 'show'])->name('mct.show');
    Route::resource('mct_pay', AdminMctPayController::class)->names([
        'create' => 'mct.create',
        'store' => 'mct.store'
    ])->middleware('signed');
});

// language change
Route::get('/change_language/{lang}', [LanguageController::class, 'changeLanguage'])->name('change.lang');


// for user operation

Route::get('/', [UserWelcomeController::class, 'index'])->name('users.index')->middleware('LangSwitch');
Route::get('/about-us', [UserWelcomeController::class, 'about_us'])->name('users.aboutus');
Route::get('/contact-us', [UserWelcomeController::class, 'contact_us'])->name('users.contactus');

Route::get('/index_item', [UserWelcomeController::class, 'create'])->name('users.index.item')->middleware(['LangSwitch']);
Route::get('/get_all_product', [UserWelcomeController::class, 'get_all_product'])->name('users.all_product')->middleware(['LangSwitch', 'signed']);
Route::get('/product-list', [UserWelcomeController::class, 'view_product_list'])->name('users.view_product_list')->middleware(['signed', 'LangSwitch']);
Route::get('/product-details/{id}', [UserProductsController::class, 'show'])->name('users.product_details.show')->middleware(['signed', 'LangSwitch']);
Route::get('/product_details', [UserProductsController::class, 'index'])->name('user.product_details.index');
Route::post('get_product_details', [UserProductsController::class, 'create'])->name('user.product_details.create')->middleware(['signed', 'LangSwitch']);
Route::get('/show_product_rating', [UserProductsController::class, 'show_product_rating'])->name('users.product_details.show_product_rating');

Route::post('store_contact', [UserWelcomeController::class, 'store_contact_us'])->name('store_contact_us');

Route::middleware(['auth', 'LangSwitch'])->name('users.')->group(function () {
    Route::resource('product-details', UserProductsController::class)->names([
        'store' => 'product_details.rating.store'
    ])->middleware('signed');

    Route::post('update_cart', [UserCartController::class, 'update_cart'])->name('update.cart')->middleware('signed');
    Route::post('delete_from_cart', [UserCartController::class, 'delete_from_cart'])->name('delete.cart')->middleware('signed');
    Route::resource('cart', UserCartController::class)->names([
        'store'     => 'cart.store',
        'create'    => 'cart.create',
        'index'     => 'cart.index'
    ])->middleware('signed');

    Route::resource('whishlist', UserWishlistController::class)->names([
        'index'   => 'wishlist.index',
        'store'   => 'wishlist.store',
        'create'  => 'wishlist.create'
    ])->middleware('signed');

    Route::resource('address', UserAddressController::class)->names([
        'create' => 'address.create'
    ])->middleware('signed');

    Route::post('/validate_form', [UserOrderController::class, 'validate_form'])->name('order.validate_form')->middleware('signed');
    Route::resource('order', UserOrderController::class)->names([
        'store' => 'order.store'
    ])->middleware('signed');

    Route::resource('coupon', UserCouponController::class)->names([
        'store' => 'coupon.store'
    ])->middleware('signed');

    Route::resource('delivery_charge', UserDeliveryChargeController::class)->names([
        'store' => 'delivery_charge.store'
    ])->middleware('signed');

    Route::resource('payment_option', UserPaymentController::class)->names([
        'store' => 'payment_option.store'
    ])->middleware('signed');

    Route::get('/redirect_thanks', [UserThanksController::class, 'index'])->name('thank.index');
    Route::resource('thanks', UserThanksController::class)->names([
        'show' => 'thank.show',
    ])->middleware('signed');


    Route::get('purchase_history', [UserPurchaseHistoryController::class, 'index'])->name('purchase_history.index');
    Route::resource('shoW_purchase_history', UserPurchaseHistoryController::class)->names([
        'show' => 'purchase_history.show'
    ])->middleware('signed');


    Route::resource('invoice', UserInvoiceController::class)->names([
        'show' => 'invoice.show'
    ])->middleware('signed');
    Route::get('/show_completed', [UserProfileController::class, 'show_completed'])->name('show_completed')->middleware('signed');
    Route::get('show_collect', [UserProfileController::class, 'show_collect'])->name('show_collect')->middleware('signed');
    Route::get('show_rate', [UserProfileController::class, 'show_rate'])->name('show_rate')->middleware('signed');

    Route::get('payment_history', [UserProfileController::class, 'payment_history'])->name('payment_history');
    Route::get('show_to_receive', [UserProfileController::class, 'show_to_receive'])->name('show_to_receive')->middleware('signed');
    Route::get('/show_pending_payment', [UserProfileController::class, 'show_pending_payment'])->name('show_pending_payment')->middleware('signed');
    Route::get('/show_to_ship', [UserProfileController::class, 'show_to_ship'])->name('show_to_ship')->middleware('signed');
    Route::get('/show_royalty', [UserWalletController::class, 'show_royalty_page'])->name('show_royalty')->middleware('signed');
    Route::any('/redeem_wallet_bonus', [UserWalletController::class, 'redeem_wallet_bonus'])->name('redeem_wallet_bonus');
    Route::any('/get_wallet_bonus', [UserWalletController::class, 'get_wallet_bonus'])->name('get_wallet_bonus');
    Route::any('/get_full_wallet_amount', [UserWalletController::class, 'get_full_wallet_amount'])->name('get_full_wallet_amount');
    Route::post('get_pv_history', [UserProfileController::class, 'get_pv_point_history'])->name('profile.get_pv_point_history')->middleware('signed');
    Route::resource('user_profile', UserProfileController::class)->names([
        'index' => 'profile.index',
        'store' => 'profile.store'
    ])->middleware('signed');


    Route::get('show_wallet_page', [UserWalletController::class, 'show_wallet_page'])->name('show_wallet_page')->middleware('signed');
    Route::post('get_qr_code_for_wallet', [UserWalletController::class, 'get_qr_code_for_wallet'])->name('get_qr_code_for_wallet')->middleware('signed');
    Route::post('store_wallet_payment', [UserWalletController::class, 'store_wallet_payment'])->name('store_wallet_payment')->middleware('signed');
    Route::get('get_all_payment', [UserWalletController::class, 'get_all_payment'])->name('get_all_payment')->middleware('signed');
});


Route::middleware(['auth', 'LangSwitch'])->name('MLM.')->prefix('MLM')->group(function () {

    Route::get('/search_user', [MLMRegisterController::class, 'search_user'])->name('register.search_user');
    Route::post('/check_user_status', [MLMRegisterController::class, 'check_user_status'])->name('register.check_user_status')->middleware('signed');
    Route::post('get_placement_id', [MLMRegisterController::class, 'get_placement_id'])->name('register.get_placement_id')->middleware('signed');
    Route::post('/get_pv_point', [MLMRegisterController::class, 'get_pv_point'])->middleware('signed')->name('register.get_pv_point');
    Route::post('/get_placement', [MLMRegisterController::class, 'get_placement'])->name('register.get_placement')->middleware('signed');
    Route::resource('mlm_register', MLMRegisterController::class)->names([
        'index'  => 'register.index',
        'create' => 'register.create',
        'store'  => 'register.store'
    ])->middleware('signed');


    Route::resource('tree', MLMTreeController::class)->names([
        'index' => 'tree.index',
        'create' => 'tree.create'
    ])->middleware('signed');

    Route::resource('direct-bonus', MLMDirectBonus::class)->names([
        'index' => 'direct_bonus.index',
        'create' => 'direct_bonus.create'
    ])->middleware('signed');


    Route::resource('matching-bonus', MLMMatchingBonusController::class)->names([
        'index' => 'matching_bonus.index',
        'create' => 'matching_bonus.create',
    ])->middleware('signed');

    Route::resource('leadership-bonus-details', MLMLeadershipController::class)->names([
        'index' => 'leadership_bonus_details.index',
        'create' => 'leadership_bonus_details.create',
    ])->middleware('signed');

    //Route::any('/commissionbonus', [MLMMatchingBonusController::class, 'commissionbonus']);

    Route::any('/commission-bonus', [AdminOrderController::class, 'commissionbonus']);

    Route::any('/leadership-bonus', [AdminOrderController::class, 'leadershipbonus']);

    Route::any('/deducated_bonus', [MLMWithDrawController::class, 'deducated_bonus'])->name('deducated_bonus');

    Route::any('/get_bonus_details', [MLMWithDrawController::class, 'get_bonus_details'])->name('get_bonus_details');

    Route::resource('withdrawform', MLMWithDrawController::class)->names([
        'index'  => 'withdrawform.index',
        'create' => 'withdrawform.create'
    ]);

    //start Loyality Points withdraw

    Route::resource('loyalitypoints_withdraw', MLMLoyalityPointsContoller::class)->names([
        'index'  => 'loyalitypoints_withdraw.index',
        'create' => 'loyalitypoints_withdraw.create'
    ]);

    // End Loyality Points withdraw

    //start Loyality Points withdraw
    Route::any('/redeem_loyality_bonus', [MLMLoyalityPointsContoller::class, 'redeem_loyality_bonus'])->name('redeem_loyality_bonus');
    Route::any('/redeem_full_loyality_bonus', [MLMLoyalityPointsContoller::class, 'redeem_full_loyality_bonus'])->name('redeem_full_loyality_bonus');
    Route::any('/get_loyalitypoint_history', [MLMLoyalityPointsContoller::class, 'get_loyalitypoint_history'])->name('get_loyalitypoint_history');
    Route::resource('loyalitypoints_withdraw', MLMLoyalityPointsContoller::class)->names([
        'index'  => 'loyalitypoints_withdraw.index',
        'create' => 'loyalitypoints_withdraw.create',
        'store' => 'loyalitypoints_withdraw.store'
    ]);

    // End Loyality Points withdraw


});


Route::get('/d', function () {
    return view('mail.order_create');
});



require __DIR__ . '/auth.php';