<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutomakerController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLevelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeadquarterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductStoreController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
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
//TUDO RELACIONADO A PARTE DO E-COMMERCE ------------------------- INÍCIO
//index da loja
Route::get('/', [StoreController::class, 'index'])->name('welcome');
//políticas
Route::get('/policies', [StoreController::class, 'policies'])->name('policies');
//sobre
Route::get('/about', [StoreController::class, 'about'])->name('about');
//contatos
Route::get('/contacts', [StoreController::class, 'contacts'])->name('contacts');
Route::post('/client-emailing', [StoreController::class, 'clientEmailing'])->name('client-emailing');
//produtos em loja
Route::post('/products/suggestions', [ProductStoreController::class, 'suggestions'])->name('suggested-products');
Route::post('/products/search-bar', [ProductStoreController::class, 'search'])->name('search-bar');
Route::get('/products', [ProductStoreController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductStoreController::class, 'show'])->name('product');
//carrinho
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/store', [CartController::class, 'store'])->name('cart-store-product');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart-update-product');
Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart-destroy-product');
//TUDO RELACIONADO A PARTE DO E-COMMERCE ------------------------- FIM

//ACCESSO (LOGIN, CRIAR CONTA E RECUPERAR SENHA)
//login
Route::get('/login-auth', [AuthController::class, 'index'])->name('auth.login');
Route::post('/process-auth', [AuthController::class, 'process'])->name('auth.process');
//recuperar senha
Route::get('/recovery-auth', [AuthController::class, 'recovery'])->name('auth.recovery');
Route::post('/recovering-auth', [AuthController::class, 'recovering'])->name('auth.recovering');
Route::get('/reset-auth/{token}', [AuthController::class, 'reset'])->name('auth.reset');
Route::post('/resetting-auth', [AuthController::class, 'resetting'])->name('auth.resetting');
Route::post('/login-auth', [AuthController::class, 'index'])->name('password.reset');
//criar conta
Route::get('/create-auth', [AuthController::class, 'create'])->name('auth.create');
Route::post('/store-auth', [AuthController::class, 'store'])->name('auth.store');

//CHECANDO AUTENTICAÇÃO DE TODAS AS ROTAS INCLUSAS
Route::group(['middleware' => 'auth'], function () {
    //Página inicial do sistema
    Route::get('/admin', [HomeController::class, 'index'])->name('admin.home');
    //logout
    Route::get('/logout-auth', [AuthController::class, 'destroy'])->name('auth.logout');
    //gráficos
    Route::get('/admin/dashboards', [DashboardController::class, 'index'])->name('dashboards.index');
    //auditoria(somente do admin pra cima em hierarquia)
    Route::get('/admin/audit', [AuditController::class, 'index'])->name('audit.index');
    Route::get('/admin/audit/show/{id}', [AuditController::class, 'show'])->name('audit.show');
    Route::delete('/admin/audit/delete/{id}', [AuditController::class, 'destroy'])->name('audit.destroy');
    Route::get('/admin/audit/logs', [AuditController::class, 'logs'])->name('audit.logs');
    Route::delete('/admin/audit/logs', [AuditController::class, 'clear'])->name('audit.logs.destroy');
    //cotações
    Route::get('/admin/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/admin/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
    Route::get('/admin/budgets/clone/{id}', [BudgetController::class, 'clone'])->name('budgets.clone');
    Route::post('/admin/budgets/store', [BudgetController::class, 'store'])->name('budgets.store');
    Route::get('/admin/budgets/show/{id}', [BudgetController::class, 'show'])->name('budgets.show');
    Route::post('/admin/budgets/pdf', [BudgetController::class, 'generatePdf'])->name('budgets.generatePdf');
    Route::post('/admin/budgets/report-pdf', [BudgetController::class, 'reportItems'])->name('budgets.reportItems');
    Route::get('/admin/budgets/edit/{id}', [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::put('/admin/budgets/update/{id}', [BudgetController::class, 'update'])->name('budgets.update');
    Route::put('/admin/budgets/transform/{id}', [BudgetController::class, 'transform'])->name('budgets.transform');
    Route::delete('/admin/budgets/delete/{id}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
    //níveis dos clientes
    Route::get('/admin/levels', [CustomerLevelController::class, 'index'])->name('levels.index');
    Route::get('/admin/levels/create', [CustomerLevelController::class, 'create'])->name('levels.create');
    Route::post('/admin/levels/store', [CustomerLevelController::class, 'store'])->name('levels.store');
    Route::get('/admin/levels/show/{id}', [CustomerLevelController::class, 'show'])->name('levels.show');
    Route::get('/admin/levels/edit/{id}', [CustomerLevelController::class, 'edit'])->name('levels.edit');
    Route::put('/admin/levels/update/{id}', [CustomerLevelController::class, 'update'])->name('levels.update');
    Route::delete('/admin/levels/delete/{id}', [CustomerLevelController::class, 'destroy'])->name('levels.destroy');
    //clientes
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/admin/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/admin/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/admin/customers/show/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/admin/customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/admin/customers/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/admin/customers/delete/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    //endereços dos clientes
    Route::get('/admin/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/admin/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/admin/addresses/store', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/admin/addresses/show/{id}', [AddressController::class, 'show'])->name('addresses.show');
    Route::get('/admin/addresses/edit/{id}', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/admin/addresses/update/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/admin/addresses/delete/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    //funções
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/admin/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/admin/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/admin/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    //permissões
    Route::get('/admin/permissions/{role_id}', [PermissionController::class, 'index'])->name('permissions.index');
    Route::put('/admin/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    //usuários
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/show/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/admin/users/self-show/{id}', [UserController::class, 'selfShow'])->name('users.self-show');
    Route::get('/admin/users/self-edit/{id}', [UserController::class, 'selfEdit'])->name('users.self-edit');
    Route::put('/admin/users/self-update/{id}', [UserController::class, 'selfUpdate'])->name('users.self-update');
    Route::delete('/admin/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    //sedes da CO2
    Route::get('/admin/headquarters', [HeadquarterController::class, 'index'])->name('headquarters.index');
    Route::get('/admin/headquarters/create', [HeadquarterController::class, 'create'])->name('headquarters.create');
    Route::post('/admin/headquarters/store', [HeadquarterController::class, 'store'])->name('headquarters.store');
    Route::get('/admin/headquarters/show/{id}', [HeadquarterController::class, 'show'])->name('headquarters.show');
    Route::get('/admin/headquarters/edit/{id}', [HeadquarterController::class, 'edit'])->name('headquarters.edit');
    Route::put('/admin/headquarters/update/{id}', [HeadquarterController::class, 'update'])->name('headquarters.update');
    Route::delete('/admin/headquarters/delete/{id}', [HeadquarterController::class, 'destroy'])->name('headquarters.destroy');
    //categorias
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/show/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/admin/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    //montadoras
    Route::get('/admin/automakers', [AutomakerController::class, 'index'])->name('automakers.index');
    Route::get('/admin/automakers/create', [AutomakerController::class, 'create'])->name('automakers.create');
    Route::post('/admin/automakers/store', [AutomakerController::class, 'store'])->name('automakers.store');
    Route::get('/admin/automakers/show/{id}', [AutomakerController::class, 'show'])->name('automakers.show');
    Route::get('/admin/automakers/edit/{id}', [AutomakerController::class, 'edit'])->name('automakers.edit');
    Route::put('/admin/automakers/update/{id}', [AutomakerController::class, 'update'])->name('automakers.update');
    Route::delete('/admin/automakers/delete/{id}', [AutomakerController::class, 'destroy'])->name('automakers.destroy');
    //marcas
    Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/admin/brands/show/{id}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('/admin/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/admin/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/admin/brands/delete/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    //fornecedores
    Route::get('/admin/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/admin/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/admin/suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/admin/suppliers/show/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/admin/suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/admin/suppliers/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/admin/suppliers/delete/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    //produtos
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/products/excel-export', [ProductController::class, 'excelExport'])->name('products.excel-export'); //EXPORTAR O EXCEL
    Route::get('/admin/products/csv-export', [ProductController::class, 'csvExport'])->name('products.csv-export'); //EXPORTAR EM CSV
    Route::post('/admin/products/sell', [ProductController::class, 'sell'])->name('products.sell');
    Route::post('/admin/products/reverse-sell', [ProductController::class, 'reverseSale'])->name('products.reverse-sell');
    Route::get('/admin/products/withdrawal-records', [ProductController::class, 'withdrawalRecords'])->name('products.withdrawal-records');
    Route::get('/admin/products/withdrawal/{id}', [ProductController::class, 'withdrawal'])->name('products.withdrawal');
    Route::post('/admin/products/withdrawal-complete', [ProductController::class, 'withdrawalComplete'])->name('products.withdrawal-complete');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    //etiquetagem
    Route::get('/admin/labeling', [LabelingController::class, 'create'])->name('labeling.create');
    Route::post('/admin/labeling/store', [LabelingController::class, 'store'])->name('labeling.store');
    //corridas
    Route::get('/admin/races', [RaceController::class, 'index'])->name('races.index');
    Route::post('/admin/races/begin', [RaceController::class, 'begin'])->name('races.begin');
    Route::get('/admin/races/race/{id}', [RaceController::class, 'race'])->name('races.race');
    Route::post('/admin/races/race/add-stop/{id}', [RaceController::class, 'addStop'])->name('races.add-stop');
    Route::delete('/admin/races/race/remove-stop/{id}', [RaceController::class, 'removeStop'])->name('races.remove-stop');
    Route::put('/admin/races/finish/{id}', [RaceController::class, 'finish'])->name('races.finish');
    Route::get('/admin/races/show/{id}', [RaceController::class, 'show'])->name('races.show');
    Route::delete('/admin/races/delete/{id}', [RaceController::class, 'destroy'])->name('races.destroy');
    //veículos
    Route::get('/admin/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/admin/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/admin/vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/admin/vehicles/show/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/admin/vehicles/edit/{id}', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/admin/vehicles/update/{id}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/admin/vehicles/delete/{id}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
    //backup
    Route::get('/admin/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::get('/admin/backups/download/{file}', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('/admin/backups/delete/{file}', [BackupController::class, 'destroy'])->name('backups.destroy');
});
