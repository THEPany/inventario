<?php

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

Auth::routes([
    'register' => false,
    'reset' => false
]);

Route::get('/', function () {
    return view('welcome');
})->middleware('install.system');

Route::get('install', [\App\Http\Controllers\InstallSystemController::class, 'index'])->name('install');
Route::get('install/system', [\App\Http\Controllers\InstallSystemController::class, 'installDatabase'])->name('install.system');
Route::get('install/admin', [\App\Http\Controllers\InstallSystemController::class, 'createAdmin'])->name('install.admin');
Route::post('install/admin', [\App\Http\Controllers\InstallSystemController::class, 'storeAdmin'])->name('install.admin.store');

Route::middleware('auth')->group(function () {
    Route::get('home', [\App\Http\Controllers\HomeController::class, 'index']);

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

    Route::resource('abilities', 'AbilitieController')->only('index');
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');

    Route::get('providers', [\App\Http\Controllers\ProviderController::class, 'index']);
    Route::get('providers/create', [\App\Http\Controllers\ProviderController::class, 'create']);
    Route::post('providers', [\App\Http\Controllers\ProviderController::class, 'store'])->name('providers.store');
    Route::get('providers/{provider}/edit', [\App\Http\Controllers\ProviderController::class, 'edit']);
    Route::put('providers/{provider}', [\App\Http\Controllers\ProviderController::class, 'update'])->name('providers.update');

    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::get('products/create', [\App\Http\Controllers\ProductController::class, 'create']);
    Route::post('products', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [\App\Http\Controllers\ProductController::class, 'edit']);
    Route::put('products/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');

    Route::get('purchases', [\App\Http\Controllers\PurchaseController::class, 'index']);
    Route::get('purchases/create', [\App\Http\Controllers\PurchaseController::class, 'create']);
    Route::post('purchases', [\App\Http\Controllers\PurchaseController::class, 'store'])->name('purchases.store');

    Route::get('branch/office', [\App\Http\Controllers\BranchOfficeController::class, 'index'])->name('branchOffice.index');
    Route::get('branch/office/create', [\App\Http\Controllers\BranchOfficeController::class, 'create'])->name('branchOffice.create');
    Route::post('branch/office', [\App\Http\Controllers\BranchOfficeController::class, 'store'])->name('branchOffice.store');
    Route::get('branch/office/{branchOffice}/edit', [\App\Http\Controllers\BranchOfficeController::class, 'edit'])->name('branchOffice.edit');
    Route::put('branch/office/{branchOffice}', [\App\Http\Controllers\BranchOfficeController::class, 'update'])->name('branchOffice.update');

    Route::get('transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::post('transactions', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/create', [\App\Http\Controllers\TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions/pass/product', [\App\Http\Controllers\TransactionPassProductController::class, 'store'])->name('transaction.pass.store');
});

Route::middleware('auth')->group(function () {
    Route::get('{branchOffice}/dashboard', [\App\Http\Controllers\Tenant\DashboardController::class, 'index']);

    Route::get('{branchOffice}/providers', [\App\Http\Controllers\Tenant\ProviderController::class, 'index']);
    Route::get('{branchOffice}/providers/create', [\App\Http\Controllers\Tenant\ProviderController::class, 'create']);
    Route::post('{branchOffice}/providers', [\App\Http\Controllers\Tenant\ProviderController::class, 'store'])->name('tenant.providers.store');
    Route::get('{branchOffice}/providers/{provider}/edit', [\App\Http\Controllers\Tenant\ProviderController::class, 'edit']);
    Route::put('{branchOffice}/providers/{provider}', [\App\Http\Controllers\Tenant\ProviderController::class, 'update'])->name('tenant.providers.update');

    Route::get('{branchOffice}/products', [\App\Http\Controllers\Tenant\ProductController::class, 'index']);
    Route::get('{branchOffice}/products/create', [\App\Http\Controllers\Tenant\ProductController::class, 'create']);
    Route::post('{branchOffice}/products', [\App\Http\Controllers\Tenant\ProductController::class, 'store'])->name('tenant.products.store');
    Route::get('{branchOffice}/products/{product}/edit', [\App\Http\Controllers\Tenant\ProductController::class, 'edit']);
    Route::put('{branchOffice}/products/{product}', [\App\Http\Controllers\Tenant\ProductController::class, 'update'])->name('tenant.products.update');

    Route::get('{branchOffice}/purchases', [\App\Http\Controllers\Tenant\PurchaseController::class, 'index']);
    Route::get('{branchOffice}/purchases/create', [\App\Http\Controllers\Tenant\PurchaseController::class, 'create']);
    Route::post('{branchOffice}/purchases', [\App\Http\Controllers\Tenant\PurchaseController::class, 'store'])->name('tenant.purchases.store');

    Route::get('{branchOffice}/transactions', [\App\Http\Controllers\Tenant\TransactionController::class, 'index'])->name('tenant.transactions.index');
    Route::post('{branchOffice}/transactions', [\App\Http\Controllers\Tenant\TransactionController::class, 'store'])->name('tenant.transactions.store');
    Route::get('{branchOffice}/transactions/create', [\App\Http\Controllers\Tenant\TransactionController::class, 'create'])->name('tenant.transactions.create');
});

