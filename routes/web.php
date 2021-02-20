<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PumpController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\BusinessTypeController;
use App\Http\Controllers\Admin\TankController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\AdjustmentController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\NozzleController;
use App\Http\Controllers\Admin\PumpTypeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FuelPriceHistoryController;
use App\Http\Controllers\Admin\ProductPriceHistoryController;
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SaleHistoryController;
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

Auth::routes();

Route::middleware('auth')->prefix('admin')->group(function ()  {
	Route::resource('/dashboard', DashboardController::class);
	Route::get('/preview', [DashboardController::class, 'preview'])->name('preview');
	Route::get('/print', [DashboardController::class, 'generatePDF'])->name('print');
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::resource('/shops', ShopController::class);
	Route::resource('/pumps', PumpController::class);
	Route::resource('/businesses', BusinessTypeController::class);
	Route::resource('/tanks', TankController::class);
	Route::resource('/counters', CounterController::class);
	Route::resource('/sales', SaleController::class);
	Route::get('/sales/test/{id}', [SaleController::class,'test'])->name('sales.test');
	Route::resource('/purchases', PurchaseController::class);
	Route::resource('/nozzles', NozzleController::class);
	Route::resource('/punp_types', PumpTypeController::class);
	Route::resource('/adjustments', AdjustmentController::class);
	Route::resource('/users', UserController::class);
	Route::resource('/products', ProductController::class);
	Route::get('/price_histories', [ProductPriceHistoryController::class, 'show']);
	Route::get('shopexport', [ShopController::class, 'fileExport'])->name('shopexport');
	Route::get('supplierexport', [SupplierController::class, 'fileExport'])->name('supplierexport');
	Route::get('adjustmentexport', [AdjustmentController::class, 'fileExport'])->name('adjustmentexport');
	Route::get('productexport', [ProductController::class, 'fileExport'])->name('productexport');
	Route::get('tankexport', [TankController::class, 'fileExport'])->name('tankexport');
	Route::get('pumpexport', [PumpController::class, 'fileExport'])->name('pumpexport');
	Route::get('vehicleexport', [VehicleController::class, 'fileExport'])->name('vehicleexport');
	Route::get('businessexport', [BusinessTypeController::class, 'fileExport'])->name('businessexport');
	Route::get('nozzleexport', [NozzleController::class, 'fileExport'])->name('nozzleexport');
	Route::get('counterexport', [CounterController::class, 'fileExport'])->name('counterexport');
	Route::get('saleexport', [SaleController::class, 'fileExport'])->name('saleexport');
	Route::get('dailysaleexport', [SaleController::class, 'dailysaleexport'])->name('dailysaleexport');
	Route::get('daily-sales', [SaleController::class, 'dailySale'])->name('dailysale');
	Route::post('userimport', [UserController::class, 'fileImport'])->name('userimport');
	Route::post('productimport', [ProductController::class, 'fileImport'])->name('productimport');
	Route::post('tank-import', [TankController::class, 'fileImport'])->name('tank-import');
	Route::post('pump-import', [PumpController::class, 'fileImport'])->name('pump-import');
	Route::post('supplierimport', [SupplierController::class, 'fileImport'])->name('supplierimport');
	Route::post('adjustmentimport', [AdjustmentController::class, 'fileImport'])->name('adjustmentimport');
	Route::post('saleimport', [SaleController::class, 'fileImport'])->name('saleimport');

	Route::post('nozzleimport', [NozzleController::class, 'fileImport'])->name('nozzleimport');
	Route::post('counterimport', [CounterController::class, 'fileImport'])->name('counterimport');
	Route::get('lang/home', [LangController::class, 'index']);
	Route::get('lang/change',[LangController::class, 'change'])->name('changeLang');
	Route::get('/sales_reports', [ReportController::class, 'salereport'])->name('sale.reports');
	Route::get('/purchasereport', [ReportController::class, 'purchasereport'])->name('purchase.reports');
	Route::get('/adjustmentreport', [ReportController::class, 'adjustmentreport'])->name('adjustment.reports');

	Route::post('/szyh-purchases-upload', [PurchaseController::class, 'szyhPurchaseUpload'])->name('szyhpurchaseupload');
	Route::post('/szyh-adjustments-upload', [AdjustmentController::class, 'szyhAdjustmentUpload'])->name('szyhadjustmentupload');
	Route::post('/szyhb-purchases-upload', [PurchaseController::class, 'szyhbPurchaseUpload'])->name('szyhbpurchaseupload');
	Route::post('/szyhb-adjustments-upload', [AdjustmentController::class, 'szyhbAdjustmentUpload'])->name('szyhbadjustmentupload');
	Route::post('/szyh-sales-upload', [SaleController::class, 'szyhSaleUpload'])->name('szyhsaleupload');
	Route::post('/szyhb-sales-upload', [SaleController::class, 'szyhbSaleUpload'])->name('szyhbsaleupload');
	Route::get('/sales-histories', [SaleHistoryController::class, 'show'])->name('saleshistories');
});
