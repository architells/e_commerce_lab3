<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\ProfileController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoriesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products/description{productId}', [CustomerController::class, 'description'])->name('description');

Route::get('/products/search', [CustomerController::class, 'search'])->name('products.search');

Route::get('/products/filter', [CustomerController::class, 'filter'])->name('products.filter');
Route::get('/products', [CustomerController::class, 'cancelFilters'])->name('products.cancelFilters');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('can:isAdmin')->group(function () {

    Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.dashboard');
    Route::put('profile/update/{user_id}', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.main-dashboard');
    Route::resource('admin/products', ProductController::class);
    Route::get('/products/dashboard', [ProductController::class, 'index'])->name('admin.products.dashboard');
    Route::get('/products/show', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::get('/products/edit/{productId}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/update/{productId}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/destroy/{productId}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::resource('brand', BrandController::class);
    Route::get('/brand', [BrandController::class, 'index'])->name('admin.brand.dashboard');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('admin.brand.create');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('admin.brand.store');
    Route::get('/brand/edit/{brandId}', [BrandController::class, 'edit'])->name('admin.brand.edit');
    Route::put('/brand/update/{brandId}', [BrandController::class, 'update'])->name('admin.brand.update');
    Route::delete('/brand/destroy/{brandId}', [BrandController::class, 'destroy'])->name('admin.brand.destroy');
    Route::get('/products/brand/{brandId}', [BrandController::class, 'getProductsByBrand']);

    Route::resource('admin/categories', CategoryController::class);
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category.dashboard');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{categoryId}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::delete('/category/destroy/{categoryId}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::put('/category/update/{categoryId}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/products/category/{categoryId}', [CategoryController::class, 'getProductsByCategory']);

    Route::resource('admin/sub_category', SubCategoryController::class);
    Route::get('/sub_category', [SubCategoryController::class, 'index'])->name('admin.sub_category.dashboard');
    Route::get('/sub_category/create', [SubCategoryController::class, 'create'])->name('admin.sub_category.create');
    Route::get('/sub_category/edit/{sub_category_id}', [SubCategoryController::class, 'edit'])->name('sub_category.edit');
    Route::put('/sub_category/update/{sub_category_id}', [SubCategoryController::class, 'update'])->name('sub_category.update');
    Route::post('/sub_category/store', [SubCategoryController::class, 'store'])->name('sub_category.store');

    Route::resource('admin/sub_sub_category', SubSubCategoriesController::class);
    Route::get('/sub_sub_category/create', [SubSubCategoriesController::class, 'create'])->name('admin.sub_sub_category.create');
    Route::post('/sub_sub_category/store', [SubSubCategoriesController::class, 'store'])->name('sub_sub_category.store');
    Route::get('/sub_sub_category/edit/{sub_sub_category_id}', [SubSubCategoriesController::class, 'edit'])->name('sub_subcategory.edit');
    Route::put('/sub_sub_category/update/{sub_sub_category_id}', [SubSubCategoriesController::class, 'update'])->name('sub_subcategory.update');
    Route::delete('/sub_sub_category/destroy/{sub_sub_category_id}', [SubSubCategoriesController::class, 'destroy'])->name('sub_subcategory.destroy');

    Route::resource('admin/suppliers', SupplierController::class);
    Route::get('/supplier', [SupplierController::class, 'index'])->name('admin.supplier.dashboard');
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name('admin.supplier.create');
    Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier/edit/{supplierId}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/destroy/{supplierId}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::get('/products/supplier/{supplierId}', [SupplierController::class, 'getProductsBySupplier']);

    Route::resource('admin/stocks', StocksController::class);
    Route::get('/stocks', [StocksController::class, 'index'])->name('admin.stocks.dashboard');
    Route::get('/stocks/create', [StocksController::class, 'create'])->name('admin.stocks.create');
    Route::post('/stocks/store', [StocksController::class, 'store'])->name('stocks.store');
    Route::get('/stocks/edit/{productId}', [StocksController::class, 'edit'])->name('admin.stocks.edit');
    Route::put('/stocks/update/{productId}', [StocksController::class, 'update'])->name('admin.stocks.update');
    Route::get('admin/stocks/{productId}/history', [StocksController::class, 'showStockHistory'])->name('admin.stocks.stocks_history');

    Route::resource('discount', DiscountController::class);
    Route::get('/discount-products', [DiscountController::class, 'index'])->name('admin.product_discount.dashboard');
    Route::post('discount/store', [DiscountController::class, 'store'])->name('discount.store');
    Route::put('/discount/update/{discount_id}', [DiscountController::class, 'update'])->name('admin.discounts.update');
    Route::delete('/discount/destroy/{discount_id}', [DiscountController::class, 'destroy'])->name('admin.discounts.destroy');

    Route::resource('admin/product_discount', ProductDiscountController::class);
    Route::post('/discount-products/store', [ProductDiscountController::class, 'store'])->name('admin.product_discounts.store');
    Route::delete('/discount-products/destroy/{id}', [ProductDiscountController::class, 'destroy'])->name('admin.product_discounts.destroy');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity_logs.dashboard');

    Route::resource('admin/users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.dashboard');
    Route::post('users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/update/{user_id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user_id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

});



Route::middleware('can:isCustomer')->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('welcome');
    Route::get('/profile/{user_id}/edit', [ProfileController::class, 'edit'])->name('customer.profile.dashboard');
    Route::put('/profile/{user_id}', [ProfileController::class, 'update'])->name('profile.update');
    // Other customer routes
});
