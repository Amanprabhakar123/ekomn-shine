<?php

use App\Http\Controllers\APIAuth\AuthController;
use App\Http\Controllers\APIAuth\BulkUploadController;
use App\Http\Controllers\APIAuth\BuyerInventoryController;
use App\Http\Controllers\APIAuth\BuyerRegistrationController;
use App\Http\Controllers\APIAuth\CategoryController;
use App\Http\Controllers\APIAuth\FeedBackController;
use App\Http\Controllers\APIAuth\ForgotController;
use App\Http\Controllers\APIAuth\OrderController;
use App\Http\Controllers\APIAuth\OrderPaymentController;
use App\Http\Controllers\APIAuth\PaymentController;
use App\Http\Controllers\APIAuth\ProductInvetoryController;
use App\Http\Controllers\APIAuth\RegisterController;
use App\Http\Controllers\APIAuth\ResetController;
use App\Http\Controllers\APIAuth\SupplierRegistraionController;
use App\Http\Controllers\APIAuth\VerificationController;
use App\Http\Controllers\Auth\AuthViewController;
use App\Http\Controllers\Auth\CourierDetailsController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Import\ImportController;
use App\Http\Controllers\MsiSettingAdmin\HomeController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Define the root route that returns the welcome view
Route::get('/', function () {
    return view('web.index');
})->name('home');

// Define routes for buyer, supplier, and admin login and registration forms
Route::get('buyer/login', [AuthViewController::class, 'loginFormView'])->name('buyer.login');
Route::get('supplier/login', [AuthViewController::class, 'loginFormView'])->name('supplier.login');
Route::get('center/admin/login', [AuthViewController::class, 'adminloginFormView'])->name('admin.login');
Route::get('buyer/register', [AuthViewController::class, 'loginFormView'])->name('buyer.register');
Route::get('supplier/register', [AuthViewController::class, 'loginFormView'])->name('supplier.register');
Route::get('supplier/forget', [AuthViewController::class, 'loginFormView'])->name('supplier.forget');
Route::get('buyer/forget', [AuthViewController::class, 'loginFormView'])->name('buyer.forget');
Route::get('verify/show/email', [ResetController::class, 'showVerifyEmailForm'])->name('verification.email.verify');
Route::get('reset', [AuthViewController::class, 'loginFormView'])->name('password.reset');
Route::get('verify/email', [ResetController::class, 'showVerifyForm'])->name('verification.verify');
Route::get('thankyou', [AuthViewController::class, 'loginFormView'])->name('thankyou');
Route::get('payment-failed', [AuthViewController::class, 'loginFormView'])->name('payment.failed');
Route::get('product-category', [WebController::class, 'productCategory'])->name('product.category');
Route::get('product-details', [WebController::class, 'productDetails'])->name('product.details');
Route::get('sub-category', [WebController::class, 'subCategory'])->name('sub.category');
Route::get('category-list', [HomeController::class, 'index'])->name('category.list');
Route::get('top-product', [HomeController::class, 'productAddView'])->name('top.product');
Route::get('banner', [HomeController::class, 'banner'])->name('banner');
Route::get('categories-list', [HomeController::class, 'listCategories'])->name('categories.list');

// Define routes for Google authentication
Route::group(['prefix' => 'auth/google', 'as' => 'auth.google.'], function () {
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('/call-back', [GoogleController::class, 'handleGoogleCallback'])->name('callback');
});

Route::middleware(['auth', 'api', 'emailverified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('editProfile', [DashboardController::class, 'editProfile'])->name('edit.profile');
    Route::get('myInventory', [DashboardController::class, 'myInventory'])->name('my.inventory');
    Route::get('addInventory', [DashboardController::class, 'addInventory'])->name('add.inventory');
    Route::get('bulk-upload', [DashboardController::class, 'bulkUpload'])->name('bulk-upload');
    Route::get('bulk-upload-list', [DashboardController::class, 'bulkUploadList'])->name('bulk-upload.list');
    Route::get('editInventory/{variation_id}', [DashboardController::class, 'editInventory'])->name('edit.inventory');
    Route::get('create-order', [DashboardController::class, 'createOrder'])->name('create.order');
    Route::get('my-orders', [DashboardController::class, 'myOrders'])->name('my.orders');
    Route::get('view-orders/{id}', [DashboardController::class, 'viewOrder'])->name('view.order');
    Route::get('courier-details', [CourierDetailsController::class, 'index'])->name('courier-details');
    Route::get('courier-list', [CourierDetailsController::class, 'show'])->name('courier.list');
    Route::get('edit-courier/{id}', [CourierDetailsController::class, 'edit'])->name('edit.courier');
    Route::get('order-tracking', [DashboardController::class, 'orderTracking'])->name('order.tracking');
    Route::get('order-payment', [OrderPaymentController::class, 'orderPayment'])->name('order.payment');
    Route::get('order-payment/bulk-upload', [BulkUploadController::class, 'paymentUpdate'])->name('payment.update');

});

// If we need blade file data and update directory in blade that time we will use this route
Route::middleware(['auth', 'api', 'emailverified'])->group(function () {
    Route::prefix('api')->group(function () {
        Route::get('/product/inventory', [ProductInvetoryController::class, 'index'])->name('product.inventory');
        Route::get('/my/product/inventory/', [BuyerInventoryController::class, 'index'])->name('product.myinventory');
        // Route::post('/store/product/inventory', [BuyerInventoryController::class, 'store'])->name('product.inventory.store');
        Route::post('/export/product/inventory/', [BuyerInventoryController::class, 'exportProductVariationData'])->name('product.inventory.export');
        Route::post('/store/product/mapchannel', [BuyerInventoryController::class, 'storeChannelProductMap'])->name('product.channelMap.store');
        Route::post('/edit/product/mapchannel', [BuyerInventoryController::class, 'editChannelProductMap'])->name('product.channelMap.edit');
        Route::post('/delete/product/mapchannel', [BuyerInventoryController::class, 'deleteChannelProductMap'])->name('product.channelMap.delete');
        Route::delete('/remove/product/inventory/{id}', [BuyerInventoryController::class, 'delete'])->name('product.removeBuyerInventory');
        Route::post('/update/company-profile', [DashboardController::class, 'updateCompanyDetails'])->name('company-profile.update');
        Route::post('/add-inventory', [ProductInvetoryController::class, 'addInventory'])->name('inventory.store');
        Route::post('update-inventory', [ProductInvetoryController::class, 'updateInventory'])->name('inventory.update');
        Route::get('/product/find-category', [CategoryController::class, 'findCategory']);
        Route::post('bulk/import-product-inventory', [ImportController::class, 'importFile'])->name('import-product-inventory');
        Route::get('/download-template', [BulkUploadController::class, 'downloadSampleTemplate'])->name('download-template');
        Route::get('/download-template-payment', [BulkUploadController::class, 'downloadSampleTemplatePayment'])->name('download-template-payment');
        Route::get('/bulk-data', [ProductInvetoryController::class, 'getDataBulkInventory'])->name('bulk-data');
        Route::patch('/product/updateStock/{variation_id}', [ProductInvetoryController::class, 'updateStock'])->name('product.updateStock');
        Route::patch('/product/updateStatus/{variation_id}', [ProductInvetoryController::class, 'updateStatus'])->name('product.updateStatus');
        Route::get('import-error-message', [BulkUploadController::class, 'index'])->name('import-error-message'); // This route is not used in the application
        Route::get('state-city-list', [DashboardController::class, 'getStateCityList'])->name('state-city-list');
        Route::post('product/search/sku', [OrderController::class, 'searchProductBySku'])->name('product.search.sku');
        Route::delete('product/remove/cart/{id}', [OrderController::class, 'removeProductInCart'])->name('product.remove.sku');
        Route::post('product/cart/list', [OrderController::class, 'getProductInCart'])->name('product.cart.list');
        Route::post('product/cart/update/quantity', [OrderController::class, 'updateProductQuantityInCart'])->name('product.cart.update.quantity');
        Route::get('buyer-id/{id}', [DashboardController::class, 'getBuyerId'])->name('buyer-id');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders', [OrderController::class, 'orders'])->name('orders');
        Route::post('orders/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
        Route::post('/update-order', [OrderController::class, 'updateOrder'])->name('update.order');
        Route::get('order/tracking/list', [OrderController::class, 'OrderTrackingList'])->name('order.tracking.list');
        Route::post('order/tracking/update', [OrderController::class, 'updatOrderTrackingStatus'])->name('order.tracking.update');
        Route::post('rating', [FeedBackController::class, 'store'])->name('rating');
        Route::get('/download-invoice/{id}', [OrderController::class, 'downloadInvoice'])->name('download.invoice');
        Route::post('/orders-invoice', [OrderController::class, 'orderInvoice'])->name('orders.invoice');
        Route::post('orders-export-csv', [OrderController::class, 'exportOrders'])->name('orders.export');
        Route::post('courier-detail', [CourierDetailsController::class, 'courierDetails'])->name('courier-detail.store');
        Route::post('courier-update', [CourierDetailsController::class, 'update'])->name('courier.update');
        Route::get('payments/weekly', [OrderPaymentController::class, 'paymentWeekly'])->name('payment.weekly');
        Route::post('order-payment-update', [OrderPaymentController::class, 'orderPaymentUpdate'])->name('order.payment.update');
        Route::post('payments/export/weekly', [OrderPaymentController::class, 'exportPaymentWeekly'])->name('payment.export.weekly');
        Route::post('bulk/import-payment', [ImportController::class, 'importPaymentFile'])->name('import-payment');
        Route::post('/orders-payment-invoice', [OrderPaymentController::class, 'orderPaymentInvoice'])->name('orders.payment.invoice');
        Route::get('get-category', [HomeController::class, 'getCategory'])->name('get.category');
        Route::post('find-category', [HomeController::class, 'findProduct'])->name('find.category');
        Route::post('find-product', [HomeController::class, 'findCategoryByProduct'])->name('find.product');
        Route::get('get-top-product', [HomeController::class, 'TopProduct'])->name('get.top.product');
        Route::post('store-categories', [CategoryController::class, 'storeCategory'])->name('store.categories');
    });
});

// If we use json post and get data that time we will use this route
Route::middleware(['api', 'jwt.auth', 'emailverified'])->group(function () {
    Route::prefix('api')->group(function () {
        Route::post('store/product/inventory', [BuyerInventoryController::class, 'store'])->name('product.inventory.store');
        Route::post('product/add-to-cart', [OrderController::class, 'addToCart'])->name('add-to-cart');
    });
});

// Route group for API authentication routes
Route::group(['prefix' => 'api'], function () {
    Route::post('register', [RegisterController::class, 'registerUser']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('password/forget', [ForgotController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetController::class, 'reset']);
    Route::post('resend', [VerificationController::class, 'resend']);
    Route::post('verify', [VerificationController::class, 'verify'])->name('verify');
    Route::post('send-email-link', [VerificationController::class, 'sendEmailLink'])->name('sendEmailLink');
    Route::post('supplier/register', [SupplierRegistraionController::class, 'supplierPostData']);
    Route::post('buyer/register', [BuyerRegistrationController::class, 'buyerPostData']);

    // Razorpay payment gateway routes
    Route::post('create-payment', [PaymentController::class, 'createPayment'])->name('create.payment');
    Route::post('payment-success/callback', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::post('order/payment-success/callback', [OrderController::class, 'orderPaymentSuccess'])->name('order.payment.success');
});

// Define routes for authenticated API routes
Route::middleware(['api', 'jwt.auth', 'emailverified'])->group(function () {
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
