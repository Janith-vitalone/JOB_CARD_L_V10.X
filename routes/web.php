<?php

use App\Http\Controllers\AssignPermissionController;
use App\Http\Controllers\AssignRolesController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\FinishingController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobCardController;
use App\Http\Controllers\LaminationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OtherPaymentController;
use App\Http\Controllers\PaymentCategoriesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\PrinterMaterialController;
use App\Http\Controllers\PrintTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockApprovelController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockProductCategoriesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierProductsController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [HomeController::class, 'dashboard']);
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    Route::resource('designation', DesignationController::class);
    Route::get('designation/get/all', [DesignationController::class, 'getAllDesignations']);

    Route::resource('user-role',UserRoleController::class);
    Route::get('user-role/get/all',[UserRoleController::class, 'getAllRoles']);

    Route::resource('user-assign',AssignRolesController::class);

    Route::get('get/assign/role',[AssignRolesController::class, 'getAllAssignedRole']);

    Route::resource('user', UserController::class);
    Route::get('user/get/all', [UserController::class, 'getAllUsers']);
    Route::get('user/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
    Route::post('user/change-password/{id}', [UserController::class, 'changePassword'])->name('change.password');

    Route::resource('permission', PermissionController::class);
    Route::get('permission/get/all', [PermissionController::class, 'getAllPermissions']);

    Route::resource('assign-permission', AssignPermissionController::class);
    Route::get('assign-permission/get/all', [AssignPermissionController::class, 'getRolePermissions']);
    Route::get('assign-permission/get/role/{id}', [AssignPermissionController::class, 'getRolePermissionsById']);

    Route::resource('jobcard', JobCardController::class);
    Route::post('jobcard/new/job', [JobCardController::class, 'createJob']);
    Route::post('jobcard/edit/job', [JobCardController::class, 'updateJob']);
    Route::get('jobcard/get/all', [JobCardController::class, 'getAllJobs']);
    Route::get('jobcard/change/status/{id}/{status}', [JobCardController::class, 'changeStatus']);
    Route::get('jobcard/get/data/bytype/{type}', [JobCardController::class, 'getDataByJobType']);

    Route::resource('client', ClientController::class);
    Route::get('client/get/all', [ClientController::class, 'getAllClients']);
    Route::get('client/get/all/{id}', [ClientController::class, 'getClientById']);
    Route::get('client/get/all/quotation/{id}', [ClientController::class, 'getQuotationByClientId']);
    Route::get('client/get/quotation/{id}', [ClientController::class, 'getQuotationDetails']);

    Route::resource('printer', PrinterController::class);
    Route::get('printer/get/all', [PrinterController::class, 'getAllPrinters']);

    Route::resource('printtype', PrintTypeController::class);
    Route::get('printtype/get/all', [PrintTypeController::class, 'getAllPrintTypes']);
    Route::get('printtype/get/byid/{id}', [PrintTypeController::class, 'getPrintTypeById']);

    Route::resource('unit', UnitController::class);
    Route::get('unit/get/all', [UnitController::class, 'getAllUnits']);

    Route::resource('material', MaterialController::class);
    Route::get('material/get/all', [MaterialController::class, 'getAllMaterials']);

    Route::resource('lamination', LaminationController::class);
    Route::get('lamination/get/all', [LaminationController::class, 'getAllLaminations']);
    Route::get('lamination/get/byid/{id}', [LaminationController::class, 'getLaminationById']);

    Route::resource('finishing', FinishingController::class);
    Route::get('finishing/get/all', [FinishingController::class, 'getAllFinishings']);
    Route::get('finishing/get/byid/{id}', [FinishingController::class, 'getFinishingById']);

    Route::resource('printermaterial', PrinterMaterialController::class);
    Route::get('printermaterial/get/all', [PrinterMaterialController::class, 'getPrinterMaterials']);
    Route::get('printermaterial/get/material/{id}', [PrinterMaterialController::class, 'getPrinterMaterialsById']);

    Route::resource('format', FormatController::class);
    Route::get('format/get/all', [FormatController::class, 'getAllFormats']);
    Route::get('format/get/jobtype/{type}', [FormatController::class, 'getFormatByJobType']);
    Route::get('format/get/byid/{id}', [FormatController::class, 'getDependableDataById']);

    Route::resource('product', ProductController::class);
    Route::get('product/get/all', [ProductController::class, 'getAllProducts']);
    Route::get('product/get/byid/{id}', [ProductController::class, 'getProductById']);

    Route::resource('invoice', InvoiceController::class);
    Route::post('invoice/new/create', [InvoiceController::class, 'createInvoice']);
    Route::post('invoice/new/payment', [InvoiceController::class, 'addPayment']);
    Route::get('invoice/print/a4', [InvoiceController::class, 'print'])->name('invoice.print');
    Route::delete('invoice/delete/payment/{id}', [InvoiceController::class, 'deletePayment'])->name('invoice.delete.payment');
    //quick invoice
    Route::post('invoice/quick/create', [InvoiceController::class, 'createQuickInvoice']);
    Route::get('invoice/quick/print/{id}', [InvoiceController::class, 'quickPrint']);
    Route::get('invoice/quick/get/all', [InvoiceController::class, 'getAllQuickInvoice']);
    Route::get('invoice/quick/payment/{id}', [InvoiceController::class, 'getAllQuickInvoicePayment']);
    Route::post('invoice/quick/new/payment', [InvoiceController::class, 'addQuickPayment']);
    Route::get('invoice/quick/{id}/edit', [InvoiceController::class, 'edit']);
    Route::post('invoice/quick/update/{id}', [InvoiceController::class, 'update']);

    Route::resource('quotation', QuotationController::class);
    Route::post('quotation/new/quote', [QuotationController::class, 'createQuote']);
    Route::post('quotation/edit/quote', [QuotationController::class, 'editQuote']);
    Route::get('quotation/get/all', [QuotationController::class, 'getAllQuotations']);
    Route::get('quotation/to/pdf/{id}', [QuotationController::class, 'pdf']);
    Route::get('quotation/change/status/{id}/{status}', [QuotationController::class, 'changeQuoteStatus']);
    Route::get('sending-quotation', 'QuotationQueueEmails@sendQuotationEmails');

    //Accounts Routes
    Route::resource('payment-category',PaymentCategoriesController::class);
    Route::get('payment-category/get/all',[PaymentCategoriesController::class, 'getAllCategories']);

    Route::resource('other-payment',OtherPaymentController::class);
    Route::get('other-payment/get/all',[OtherPaymentController::class, 'getAllPayments']);

    Route::resource('bank',BankController::class);
    Route::get('bank/get/all',[BankController::class, 'getAllBanks']);

    Route::resource('branch',BranchController::class);
    Route::get('branch/get/all',[BranchController::class, 'getAllBranchs']);

    //Stock Routes
    Route::resource('stock-product-category', StockProductCategoriesController::class);
    Route::get('stock-product-category/get/all',[StockProductCategoriesController::class, 'getAllCategories']);

    Route::resource('supplier-product', SupplierProductsController::class);
    Route::get('supplier-product/get/all',[SupplierProductsController::class, 'getAllProducts']);
    Route::get('supplier-product/get/product/{id}', [SupplierProductsController::class, 'getProductById']);

    Route::resource('supplier', SupplierController::class);
    Route::get('supplier/get/all', [SupplierController::class, 'getAllSuppliers']);
    Route::get('supplier/get/all/{id}', [SupplierController::class, 'getSupplierById']);
    Route::get('supplier/get/stock-product-category/all/{id}', [SupplierController::class, 'getSupplierProductCategoryById']);
    Route::get('supplier/get/product/all/{id}/{id2}', [SupplierController::class, 'getSupplierProductById']);
    Route::get('supplier/get/product/all/{id}', [SupplierController::class, 'getSupplierProductByCategoryId']);

    Route::resource('stock', StockController::class);
    Route::get('stock/get/all', [StockController::class, 'getAllStocks']);

    Route::resource('stockin', StockInController::class);
    Route::get('stockin/get/all', [StockInController::class, 'getAllStockIns']);
    Route::get('stockin/view/{id}', [StockInController::class, 'show']);
    Route::post('stockin/create', [StockInController::class, 'createStockIn']);

    //stock update approvel
    Route::resource('stock-approvel', StockApprovelController::class);
    Route::get('stock-approvel/get/all', [StockApprovelController::class, 'getAllApprovals']);

    // Reports Routes
    Route::get('reports/invoices', [ReportController::class, 'showInvoiceReport'])->name('invoice.report');
    Route::get('reports/get/invoices', [ReportController::class, 'getInvoiceReportData'])->name('invoice.report.data');

    Route::get('reports/items', [ReportController::class, 'showItemsReport'])->name('item.report');
    Route::get('reports/get/items', [ReportController::class, 'getItemsReportData'])->name('item.report.data');

    Route::get('reports/other-payment', [ReportController::class, 'showOtherPaymentreport'])->name('other_payment.report');
    Route::get('reports/get/other-payment', [ReportController::class, 'getOtherPaymentReportData'])->name('other_payment.report.data');

    Route::get('reports/profitandloss', [ReportController::class, 'showProfitAndLossreport'])->name('profit_and_loss.report');
    Route::post('reports/profitandloss/genarate', [ReportController::class, 'generatepnl'])->name('profit_and_loss.generate');
    Route::get('reports/profitandloss/genarate/table', [ReportController::class, 'generatepnlTable'])->name('profit_and_loss.generate.table');

    Route::get('reports/quick-invoices', [ReportController::class, 'showQuickInvoiceReport'])->name('quick_invoice.report');
    Route::get('reports/get/quick-invoices', [ReportController::class, 'getQuickInvoiceReportData'])->name('quick_invoice.report.data');

    Route::get('reports/stock', [ReportController::class, 'showStockReport'])->name('stock.report');
    Route::get('reports/get/stocks', [ReportController::class, 'getStockReportData'])->name('stock.report.data');

});

require __DIR__.'/auth.php';
