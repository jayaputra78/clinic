<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DoinvoiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WareController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\HarborController;


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

Route::get('/', function () { return view('login3'); });
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil');
Route::post('/profil_update', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil_update');
Route::post('/profil_update2', [App\Http\Controllers\ProfilController::class, 'update2'])->name('profil_update2');

Route::group(['middleware' => ['auth','ceklevel:1,2,3,4']], function() { 
   
    Route::get('/group', [GroupController::class, 'index']);
    Route::post('/group_store', [GroupController::class, 'prod_store'])->name('group_store');
    Route::delete('/group_delete', [GroupController::class, 'prod_delete'])->name('group_delete');
    Route::get('/group_edit', [GroupController::class, 'prod_edit'])->name('group_edit');
    Route::post('/group_update', [GroupController::class, 'prod_update'])->name('group_update');
    Route::get('/group_index2', [GroupController::class, 'prod_index2'])->name('group_index2');
    Route::get('/group_export', [GroupController::class, 'prod_export'])->name('group_export');
    Route::get('/group_pdf', [GroupController::class, 'prod_pdf'])->name('group_pdf');
    Route::post('/group_import', [GroupController::class, 'prod_import'])->name('group_import');

    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/prod_index2', [ProductController::class, 'prod_index2'])->name('prod_index2');
    Route::post('/prod_store', [ProductController::class, 'prod_store'])->name('prod_store');
    Route::delete('/prod_delete', [ProductController::class, 'prod_delete'])->name('prod_delete');
    Route::get('/prod_edit', [ProductController::class, 'prod_edit'])->name('prod_edit');
    Route::post('/prod_update', [ProductController::class, 'prod_update'])->name('prod_update');
    Route::get('/prod_export', [ProductController::class, 'prod_export'])->name('prod_export');
    Route::get('/prod_pdf', [ProductController::class, 'prod_pdf'])->name('prod_pdf');

    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::post('/sp_store', [SupplierController::class, 'sp_store'])->name('sp_store');
    Route::delete('/sp_delete', [SupplierController::class, 'sp_delete'])->name('sp_delete');
    Route::get('/sp_edit', [SupplierController::class, 'sp_edit'])->name('sp_edit');
    Route::post('/sp_update', [SupplierController::class, 'sp_update'])->name('sp_update');
    Route::get('/sp_index2', [SupplierController::class, 'sp_index2'])->name('sp_index2');
    Route::get('/sp_export', [SupplierController::class, 'sp_export'])->name('sp_export');
    Route::get('/sp_pdf', [SupplierController::class, 'sp_pdf'])->name('sp_pdf');
    Route::post('/sp_import', [SupplierController::class, 'sp_import'])->name('sp_import');

    Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/cs_store', [CustomerController::class, 'cs_store'])->name('cs_store');
    Route::delete('/cs_delete', [CustomerController::class, 'cs_delete'])->name('cs_delete');
    Route::get('/cs_edit', [CustomerController::class, 'cs_edit'])->name('cs_edit');
    Route::post('/cs_update', [CustomerController::class, 'cs_update'])->name('cs_update');
    Route::get('/cs_index2', [CustomerController::class, 'cs_index2'])->name('cs_index2');
    Route::get('/cs_export', [CustomerController::class, 'cs_export'])->name('cs_export');
    Route::get('/cs_pdf', [CustomerController::class, 'cs_pdf'])->name('cs_pdf');
    Route::post('/cs_import', [CustomerController::class, 'cs_import'])->name('cs_import');

    Route::get('/client', [ClientController::class, 'index']);
    Route::post('/cl_store', [ClientController::class, 'cl_store'])->name('cl_store');
    Route::delete('/cl_delete', [ClientController::class, 'cl_delete'])->name('cl_delete');
    Route::get('/cl_edit', [ClientController::class, 'cl_edit'])->name('cl_edit');
    Route::post('/cl_update', [ClientController::class, 'cl_update'])->name('cl_update');
    Route::get('/cl_index2', [ClientController::class, 'cl_index2'])->name('cl_index2');
    Route::get('/cl_export', [ClientController::class, 'cl_export'])->name('cl_export');
    Route::get('/cl_pdf', [ClientController::class, 'cl_pdf'])->name('cl_pdf');
    Route::post('/cl_import', [ClientController::class, 'cl_import'])->name('cl_import');

    Route::get('/warehouse', [WarehouseController::class, 'index']);
    Route::post('/wr_store', [WarehouseController::class, 'wr_store'])->name('wr_store');
    Route::delete('/wr_delete', [WarehouseController::class, 'wr_delete'])->name('wr_delete');
    Route::get('/wr_edit', [WarehouseController::class, 'wr_edit'])->name('wr_edit');
    Route::post('/wr_update', [WarehouseController::class, 'wr_update'])->name('wr_update');
    Route::get('/wr_index2', [WarehouseController::class, 'wr_index2'])->name('wr_index2');
    Route::get('/wr_export', [WarehouseController::class, 'wr_export'])->name('wr_export');
    Route::get('/wr_pdf', [WarehouseController::class, 'wr_pdf'])->name('wr_pdf');
    Route::post('/wr_import', [WarehouseController::class, 'wr_import'])->name('wr_import');

    Route::get('/ware', [WareController::class, 'index']);
    Route::post('/wr2_store', [WareController::class, 'wr2_store'])->name('wr2_store');
    Route::delete('/wr2_delete', [WareController::class, 'wr2_delete'])->name('wr2_delete');
    Route::get('/wr2_edit', [WareController::class, 'wr2_edit'])->name('wr2_edit');
    Route::post('/wr2_update', [WareController::class, 'wr2_update'])->name('wr2_update');
    Route::get('/wr2_index2', [WareController::class, 'wr2_index2'])->name('wr2_index2');
    Route::get('/wr2_export', [WareController::class, 'wr2_export'])->name('wr2_export');
    Route::get('/wr2_pdf', [WareController::class, 'wr2_pdf'])->name('wr2_pdf');
    Route::post('/wr2_import', [WareController::class, 'wr2_import'])->name('wr2_import');

    Route::get('/boat', [BoatController::class, 'index']);
    Route::post('/bt_store', [BoatController::class, 'bt_store'])->name('bt_store');
    Route::delete('/bt_delete', [BoatController::class, 'bt_delete'])->name('bt_delete');
    Route::get('/bt_edit', [BoatController::class, 'bt_edit'])->name('bt_edit');
    Route::post('/bt_update', [BoatController::class, 'bt_update'])->name('bt_update');
    Route::get('/bt_index2', [BoatController::class, 'bt_index2'])->name('bt_index2');
    Route::get('/bt_export', [BoatController::class, 'bt_export'])->name('bt_export');
    Route::get('/bt_pdf', [BoatController::class, 'bt_pdf'])->name('bt_pdf');
    Route::post('/bt_import', [BoatController::class, 'bt_import'])->name('bt_import');

    Route::get('/pelabuhan', [HarborController::class, 'index']);
    Route::post('/pl_store', [HarborController::class, 'pl_store'])->name('pl_store');
    Route::delete('/pl_delete', [HarborController::class, 'pl_delete'])->name('pl_delete');
    Route::get('/pl_edit', [HarborController::class, 'pl_edit'])->name('pl_edit');
    Route::post('/pl_update', [HarborController::class, 'pl_update'])->name('pl_update');
    Route::get('/pl_index2', [HarborController::class, 'pl_index2'])->name('pl_index2');
    Route::get('/pl_export', [HarborController::class, 'pl_export'])->name('pl_export');
    Route::get('/pl_pdf', [HarborController::class, 'pl_pdf'])->name('pl_pdf');
    Route::post('/pl_import', [HarborController::class, 'pl_import'])->name('pl_import');

    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier_create');
    Route::get('/cashier_index2', [CashierController::class, 'ch_index2'])->name('cashier_index2');
    Route::post('/cashier_store', [CashierController::class, 'ch_store'])->name('cashier_store');
    Route::delete('/cashier_delete', [CashierController::class, 'ch_delete'])->name('cashier_delete');
    Route::get('/cashier_edit', [CashierController::class, 'ch_edit'])->name('cashier_edit');
    Route::post('/cashier_update', [CashierController::class, 'ch_update'])->name('cashier_update');
    Route::get('/cashier_export', [CashierController::class, 'ch_export'])->name('cashier_export');
    Route::get('/cashier_pdf', [CashierController::class, 'ch_pdf'])->name('cashier_pdf');
    Route::post('/cashier_import', [CashierController::class, 'ch_import'])->name('cashier_import');

    Route::get('/payinvoice', [PaymentController::class, 'index'])->name('payinvoice.index');
    Route::get('/pay_index2', [PaymentController::class, 'pay_index2'])->name('pay_index2');
    Route::get('/pay_index3', [PaymentController::class, 'pay_index3'])->name('pay_index3');
    Route::post('/payinvoice_simpan', [PaymentController::class, 'pay_simpan'])->name('payinvoice_simpan');
    Route::get('/payinvoice_index2', [PaymentController::class, 'index2'])->name('payinvoice_index2');
    Route::post('/payinvoice_saves', [PaymentController::class, 'pay_saves'])->name('payinvoice_saves');
    Route::delete('/payinvoice_delete', [PaymentController::class, 'pay_delete'])->name('payinvoice_delete');
    Route::get('/payinvoice_reload', [PaymentController::class, 'pay_reload'])->name('payinvoice_reload');
    Route::get('/payinvoice_reload2', [PaymentController::class, 'pay_reload2'])->name('payinvoice_reload2');

    Route::get('/doinvoice', [DoinvoiceController::class, 'index'])->name('doinvoice.index');
    Route::get('/do_index2', [DoinvoiceController::class, 'do_index2'])->name('do_index2');
    Route::post('/doinvoice_simpan', [DoinvoiceController::class, 'do_simpan'])->name('doinvoice_simpan');
    Route::get('/doinvoice_index2', [DoinvoiceController::class, 'index2'])->name('doinvoice_index2');
    Route::post('/doinvoice_saves', [DoinvoiceController::class, 'do_saves'])->name('doinvoice_saves');
    Route::delete('/doinvoice_delete', [DoinvoiceController::class, 'do_delete'])->name('doinvoice_delete');
    Route::get('/doinvoice_reload2', [DoinvoiceController::class, 'do_reload2'])->name('doinvoice_reload2');
    Route::get('/do_index3', [DoinvoiceController::class, 'do_index3'])->name('do_index3');
    Route::get('/doinvoice_print', [DoinvoiceController::class, 'do_cetak'])->name('doinvoice_print');
    Route::get('/doinvoice_cek', [DoinvoiceController::class, 'do_cekharga'])->name('doinvoice_cek');
    Route::get('/doinvoice_acc', [DoinvoiceController::class, 'do_acc'])->name('doinvoice_acc');
    Route::get('/doinvoice_cancelacc', [DoinvoiceController::class, 'do_cancellacc'])->name('doinvoice_cancellacc');
    Route::post('/doinvoice_update', [DoinvoiceController::class, 'do_update'])->name('doinvoice_update');
    Route::get('/doinvoice_editgbr', [DoinvoiceController::class, 'do_editgbr'])->name('doinvoice_editgbr');
    Route::get('/doinvoice_editegf', [DoinvoiceController::class, 'do_editegf'])->name('doinvoice_editegf');
    Route::post('/doinvoice_update2', [DoinvoiceController::class, 'do_update2'])->name('doinvoice_update2');



    //semua user bisa ubah sendiri .. tp yg bisa nambah cuma level 1 sd 4
    Route::get('/user_edit', [UserController::class, 'user_edit'])->name('user_edit');
    Route::post('/user_update', [UserController::class, 'user_update'])->name('user_update');
    Route::post('/user_update2', [UserController::class, 'user_update2'])->name('user_update2');    

    Route::get('/laporan_create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::get('/laporan_jual/{id}/{member}/{group}', [LaporanController::class, 'laporanjual'])->name('laporan.jual');
    Route::get('/lapjual_export/{id}/{member}/{group}', [LaporanController::class, 'lapjual_export'])->name('lapjual_export');
    Route::get('/laporan_createkasir', [LaporanController::class, 'createkasir'])->name('laporan.createkasir');
    Route::get('/laporan_cashier/{tglawal}/{tglakhir}/{id}/{kasir_id}', [LaporanController::class, 'laporancashier'])->name('laporan.cashier');
    Route::get('/laporan_createhutang', [LaporanController::class, 'createhutang'])->name('laporan.createhutang');
    Route::get('/laporan_hutang/{id}', [LaporanController::class, 'laporanhutang'])->name('laporan.hutang');
    Route::get('/laphutang_export/{id}', [LaporanController::class, 'laphutang_export'])->name('laphutang_export');

    Route::get('/laporan_createcashflow', [LaporanController::class, 'createcashflow'])->name('laporan.createcashflow');
    Route::get('/laporan_createrugilaba', [LaporanController::class, 'createrugilaba'])->name('laporan.createrugilaba');
    Route::get('/laporan_cashflow/{id}/{member_id}', [LaporanController::class, 'laporancashflow'])->name('laporan.cashflow');
    Route::get('/laporan_rugilaba/{tglawal}/{tglakhir}/{id}/{member_id}', [LaporanController::class, 'laporanrugilaba'])->name('laporan.rugilaba');

    Route::get('/account', [AccountController::class, 'index'])->name('account_create');
    Route::get('/account_index2', [AccountController::class, 'acc_index2'])->name('account_index2');
    Route::post('/account_store', [AccountController::class, 'acc_store'])->name('account_store');
    Route::delete('/account_delete', [AccountController::class, 'acc_delete'])->name('account_delete');
    Route::get('/account_edit', [AccountController::class, 'acc_edit'])->name('account_edit');
    Route::post('/account_update', [AccountController::class, 'acc_update'])->name('account_update');
    Route::get('/account_export', [AccountController::class, 'acc_export'])->name('account_export');
    Route::get('/account_pdf', [AccountController::class, 'acc_pdf'])->name('account_pdf');
    Route::post('/account_import', [AccountController::class, 'acc_import'])->name('account_import');


});

Route::group(['middleware' => ['auth','ceklevel:1,2,3,4,5']], function() { 

    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invinvoice.index');
    Route::get('/inv_index2', [InvoiceController::class, 'do_index2'])->name('inv_index2');
    Route::post('/invinvoice_simpan', [InvoiceController::class, 'do_simpan'])->name('invinvoice_simpan');
    Route::get('/invinvoice_index2', [InvoiceController::class, 'index2'])->name('invinvoice_index2');
    Route::post('/invinvoice_saves', [InvoiceController::class, 'do_saves'])->name('invinvoice_saves');
    Route::delete('/invinvoice_delete', [InvoiceController::class, 'do_delete'])->name('invinvoice_delete');
    Route::get('/invinvoice_reload2', [InvoiceController::class, 'do_reload2'])->name('invinvoice_reload2');
    Route::get('/inv_index3', [InvoiceController::class, 'do_index3'])->name('inv_index3');
    Route::get('/invinvoice_print', [InvoiceController::class, 'do_cetak'])->name('invinvoice_print');
    Route::get('/invinvoice_print2', [InvoiceController::class, 'do_cetak2'])->name('invinvoice_print2');
    Route::get('/invinvoice_cek', [InvoiceController::class, 'do_cekharga'])->name('invinvoice_cek');
    Route::get('/invinvoice_acc', [InvoiceController::class, 'do_acc'])->name('invinvoice_acc');
    Route::get('/invinvoice_cancelacc', [InvoiceController::class, 'do_cancellacc'])->name('invinvoice_cancellacc');
    Route::post('/invinvoice_update', [InvoiceController::class, 'do_update'])->name('invinvoice_update');
    Route::get('/invinvoice_editgbr', [InvoiceController::class, 'do_editgbr'])->name('invinvoice_editgbr');
    Route::get('/invinvoice_editegf', [InvoiceController::class, 'do_editegf'])->name('invinvoice_editegf');
    Route::post('/invinvoice_update2', [InvoiceController::class, 'do_update2'])->name('invinvoice_update2');
    Route::get('/invinvoice_edittugas', [InvoiceController::class, 'do_edittugas'])->name('invinvoice_edittugas');
    Route::post('/invinvoice_update3', [InvoiceController::class, 'do_update3'])->name('invinvoice_update3');
    Route::get('/invinvoice_uploadcont', [InvoiceController::class, 'do_uploadcont'])->name('invinvoice_uploadcont');
    Route::post('/invinvoice_updatecont', [InvoiceController::class, 'do_updatecont'])->name('invinvoice_updatecont');
    Route::get('/invinvoice_uploadvideo', [InvoiceController::class, 'do_uploadvideo'])->name('invinvoice_uploadvideo');
    Route::post('/invinvoice_updatevideo', [InvoiceController::class, 'do_updatevideo'])->name('invinvoice_updatevideo');

});

Route::group(['middleware' => ['auth','ceklevel:1,2,3']], function() { 

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user_index2', [UserController::class, 'user_index2'])->name('user_index2');
    Route::post('/user_store', [UserController::class, 'user_store'])->name('user_store');
    Route::delete('/user_delete', [UserController::class, 'user_delete'])->name('user_delete');
    Route::post('/user_upassw', [UserController::class, 'user_upassw'])->name('user_upassw');
    Route::get('/user_export', [UserController::class, 'user_export'])->name('user_export');
    Route::get('/user_pdf', [UserController::class, 'user_pdf'])->name('user_pdf');
    Route::post('/user_import', [UserController::class, 'user_import'])->name('user_import');
    
});


Route::group(['middleware' => ['auth','ceklevel:1,2,3']], function() { 
    Route::get('/member', [MemberController::class, 'index']);
    Route::get('/mem_index2', [MemberController::class, 'mem_index2'])->name('mem_index2');
    Route::post('/mem_store', [MemberController::class, 'mem_store'])->name('mem_store');
    Route::delete('/mem_delete', [MemberController::class, 'mem_delete'])->name('mem_delete');
    Route::get('/mem_edit', [MemberController::class, 'mem_edit'])->name('mem_edit');
    Route::post('/mem_update', [MemberController::class, 'mem_update'])->name('mem_update');
    Route::get('/mem_export', [MemberController::class, 'mem_export'])->name('mem_export');
    Route::get('/mem_pdf', [MemberController::class, 'mem_pdf'])->name('mem_pdf');
    Route::post('/mem_import', [MemberController::class, 'mem_import'])->name('mem_import');
});