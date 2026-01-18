<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    return redirect('/');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [ProductController::class, 'index'])->name('home');
    Route::get('/about', function () {
        return view(
            'about',
            [
                'company' => 'John Doe Corp',
                'founded' => 2025,
            ]
        );
    })->name('about');

    // routes (anyone can view)
    Route::resource('products', ProductController::class)->except('destroy');
    Route::resource('categories', CategoryController::class)->except(['index', 'destroy', 'update', 'store']);
});

Route::middleware(['auth', 'admin'])->group(function () {

    // product routes for admin only
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // category routes for admin only
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});



Route::middleware('auth')->get('/secret', function () {
    return 'You can only see this if logged in!';
});


require __DIR__ . '/auth.php';
