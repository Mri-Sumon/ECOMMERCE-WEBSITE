<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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
});

require __DIR__ . '/auth.php';

Route::get('/admin', function () {
    return view('backend.layouts.master');
});

Route::get('/home', function () {
    return view('backend.dashboard');
});

Route::get('/category', function () {
    return view('backend.category.index');
});

Route::middleware('auth')->group(function () {
    //Category Route
    Route::get('/home', [HomeController::class, 'home'])->name('categories.home');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.list');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/category-pdf', [CategoryController::class, 'categoryPdf'])->name('categories.pdf');
    Route::get('/category-excel', [CategoryController::class, 'export'])->name('categories.excel');

    Route::get('/Home', [HomeController::class, 'home'])->name('home');

    //Product Route
    Route::get('/products', [ProductController::class, 'index'])->name('products.list');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/trash-products', [ProductController::class, 'trash'])->name('products.trashed');
    Route::get('/trash-products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/trash-products/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');

    //USER ROUTE
    Route::get('/users', [UserController::class, 'index'])->name('user.list');
    Route::get('/role', [UserController::class, 'roleList'])->name('user.role');
    Route::get('/role-users/{role}', [UserController::class, 'usersList'])->name('role.user-list');
});


//FRONTEND
Route::get('/frontend', [FrontendController::class, 'index'])->name('frontend.index');
