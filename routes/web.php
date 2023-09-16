<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\GenerateInvoice;
use App\Http\Controllers\importCategoryController;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\UserProductController;
use App\Models\Ipaddress;
use App\Models\Order;

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
    return redirect()->route('dashboard');
});

/**
 * Route For Printer Function
 */

Route::get('/auto-print', [PrinterController::class, 'autoPrint']);
Route::get('/print/{pdf}', [PrinterController::class, 'isPrintedTrue']);

/**
 * Login Page
 */
Route::get('/login', [AdminController::class, 'loginPage'])->name('loginPageAdmin');
Route::post('/login', [AdminController::class, 'login'])->name('loginAdmin');
Route::get('/logout', [AdminController::class, 'logout'])->name('logoutAdmin');


/**
 * Dashboard Page
 */

Route::middleware(['login'])->group(function () {
    /**Printers */
    Route::post('/cashier-printer', [PrinterController::class, 'cashierPrinter'])->name('cashierPrinter');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route Product
    Route::get('/products', [ProductController::class, 'index'])->name('getProduct');
    Route::get('/edit-products/{id}', [ProductController::class, 'editPageProduct'])->name('editPageProduct');
    Route::get('/products-add', [ProductController::class, 'addProductPage'])->name('addProductPage');
    Route::post('/product-post', [ProductController::class, 'store'])->name('postProduct');
    Route::post('/product-edit', [ProductController::class, 'postEditProduct'])->name('postEditProduct');
    Route::get('/stock-edit/{uuid}', [ProductController::class, 'editStock'])->name('editStock');
    Route::get('/delete-product/{uuid}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::get('/bundle-add', [ProductController::class, 'createBundlePage'])->name('createBundlePage');
    Route::post('/bundle-store', [ProductController::class, 'storeBundle'])->name('storeBundle');

    // Route Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('getCategory');
    Route::get('/categories-status/{id}', [CategoryController::class, 'editStatus'])->name('editStatusCategory');
    Route::post('/categories', [CategoryController::class, 'add'])->name('postCategory');
    Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/update-category', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::post('/import-categories', [importCategoryController::class, 'store'])->name('importCategory');
    Route::get('/categories/{id}', [CategoryController::class, 'subCategory'])->name('subCategory');

    // Route Outlet
    Route::get('/outlets', [OutletController::class, 'index'])->name('getOutlets');
    Route::post('/outlets', [OutletController::class, 'add'])->name('postOutlet');
    Route::get('/delete-outlet/{id}', [OutletController::class, 'deleteOutlet'])->name('deleteOutlet');
    Route::post('/update-outlet', [OutletController::class, 'updateOutlet'])->name('updateOutlet');

    /**Route Promo */
    Route::get('promo', [PromoController::class, 'index'])->name('getPromo');
    Route::get('promo/delete/{id}', [PromoController::class, 'delete'])->name('deletePromo');
    Route::get('promo/product/{id}', [PromoController::class, 'detailProduct']);
    Route::post('promo', [PromoController::class, 'storePromo'])->name('storePromo');
    Route::get('promo/search-product', [PromoController::class, 'searchProduk'])->name('promoSearchProduk');

    /**Route Orders */
    Route::get('/orders', [OrderController::class, 'index'])->name('getOrders');
    Route::get('/order-datas', [OrderController::class, 'orderData'])->name('orderDataApi');
    Route::post('/payment', [OrderController::class, 'payment'])->name('paymentApi');
    Route::get('/delete-invoice-product/{id}', [OrderController::class, 'deleteProductInvoice'])->name('deleteProductInvoice');
    Route::get('/invoices', [OrderController::class, 'getInvoices'])->name('getInvoices');
    Route::post('/payment-table', [OrderController::class, 'paymentTable'])->name('paymentTableApi');
    Route::get('/orders-export', [ExportOrderController::class, 'export'])->name('exportOrder');
    Route::post('/change-status-order', [OrderController::class, 'editStatus'])->name('changeStatusOrder');


    /**Live Order Data */
    Route::get('/live-order', [OrderController::class, 'liveOrder'])->name('liveOrder');
    Route::get('/live-order-data', [OrderController::class, 'liveOrderData'])->name('liveOrderData');
    Route::post('/change-status', [OrderController::class, 'editStatus'])->name('editStatusInvoice');

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('userManagement');
    Route::post('/user', [UserManagementController::class, 'store'])->name('postUser');
    Route::get('/delete-user/{uuid}', [UserManagementController::class, 'deleteUser'])->name('deleteUser');
    Route::post('/update-user', [UserManagementController::class, 'updateUser'])->name('updateUsers');

    /**Setting */
    Route::get('/setting', [AdminController::class, 'setting'])->name('settingPage');
    Route::post('/setting-save', [AdminController::class, 'saveSetting'])->name('saveSetting');
    Route::post('/setting-save-whatsapp', [AdminController::class, 'saveWhatsapp'])->name('saveWhatsapp');
    Route::get('/whatsapp-change-status/{id}', [AdminController::class, 'whatsappChangeStatus'])->name('whatsappChangeStatus');
    Route::post('/ipaddress', [AdminController::class, 'postIpAddress'])->name('postIpAddress');
    Route::get('/wifi-change-status/{id}', [AdminController::class, 'wifiChangeStatus'])->name('wifiChangeStatus');

    /**Statistic Route */
    Route::get('/statistic', [StatisticController::class, 'view'])->name('getStatistic');
    /**Chart Data Based On Omset Per Month */
    Route::get('/statistic-omset', [StatisticController::class, 'statisticOmset'])->name('statisticOmset');
    /**Chart Data Based On Outlet*/
    Route::get('/statistic-outlet', [StatisticController::class, 'statisticOutlet'])->name('statisticOutlet');
    /**Chart Data Based On Product*/
    Route::get('/statistic-product', [StatisticController::class, 'statisticProduct'])->name('statisticProduct');
    /**Chart Data Based On Omset Per Month */
    Route::get('/statistic-omset-day', [StatisticController::class, 'statisticOmsetDat'])->name('statisticOmsetDat');

    Route::get('/admin/kritik', [KritikController::class, 'indexAdmin'])->name('kritikPageAdmin');

    Route::get('banners', [BannerController::class, 'index'])->name('getBanner');
    Route::get('banners/add', [BannerController::class, 'add'])->name('addBanner');
    Route::post('banners/add', [BannerController::class, 'store'])->name('storeBanner');
    Route::get('banners/delete/{id}', [BannerController::class, 'delete'])->name('deleteBanner');
    Route::get('banners/change-status/{id}', [BannerController::class, 'updateStatus'])->name('changeBannerStatus');
});

/**
 * Route For Users / Waiters
 */
Route::middleware(['limitedIp'])->group(function () {
    Route::get('dashboard-user/{code}', [UserController::class, 'dashboard'])->name('dashboardUser');
    Route::get('/shopping/{code}', [UserController::class, 'view'])->name('userPage');
    Route::get('/shopping-banner/{code}', [UserController::class, 'viewBanner'])->name('userPageBanner');
    Route::get('/carts/{code}', [UserController::class, 'carts'])->name('cartPage');
    Route::get('/invoice/{code}', [UserController::class, 'invoice'])->name('invoice');
    Route::get('cek-invoices', [UserController::class, 'checkInvoices']);
});
Route::get('/invoice-search', [InvoiceController::class, 'search'])->name('searchInvoice');
Route::post('/kritik', [KritikController::class, 'store'])->name('storeKritik');
Route::get('user-product', [UserProductController::class, 'index'])->name('userGetProduct');
Route::post('/carts', [UserController::class, 'storeCart'])->name('storeCart');

Route::get('wifi/{code}', [UserController::class, 'wifiPage'])->name('wifiList');
